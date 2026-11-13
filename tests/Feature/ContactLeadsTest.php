<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ContactLeadsTest extends TestCase
{
    use RefreshDatabase;

    private const URL = 'https://app.losos.mx/prospectos/abc';

    private function form(array $extra = []): array
    {
        return $extra + [
            'first_name' => 'Cecilia', 'last_name' => 'Acevedo', 'email' => 'cecy@example.com',
            'phone_code' => '+52', 'phone' => '999 123 4567', 'company' => 'Constructora Sur', 'equipment' => 'Retroexcavadora',
        ];
    }

    public function test_contact_form_is_saved_and_sent_to_nerby(): void
    {
        config(['services.nerby.leads_url' => self::URL]);
        Http::fake([self::URL => Http::response(['ok' => true])]);

        $this->post(route('contact.store'), $this->form())
            ->assertRedirect(route('contact'))
            ->assertSessionHas('status');

        $message = ContactMessage::sole();
        $this->assertNotNull($message->nerby_sent_at);
        $this->assertSame('+52 999 123 4567', $message->phone);

        Http::assertSent(fn (Request $request) => $request->url() === self::URL
            && $request['nombre'] === 'Cecilia' && $request['apellido'] === 'Acevedo'
            && $request['correo'] === 'cecy@example.com' && $request['telefono'] === '+52 999 123 4567'
            && $request['empresa'] === 'Constructora Sur' && $request['interes'] === 'Retroexcavadora');
    }

    public function test_message_is_kept_and_retried_when_nerby_is_down(): void
    {
        config(['services.nerby.leads_url' => self::URL]);
        Http::fake([self::URL => Http::sequence()->pushStatus(500)->push(['ok' => true])->push(['ok' => true])]);

        // Nerby caído: la persona ve su "gracias" igual y el mensaje queda pendiente
        $this->post(route('contact.store'), $this->form())->assertRedirect(route('contact'))->assertSessionHas('status');
        $first = ContactMessage::sole();
        $this->assertNull($first->nerby_sent_at);
        $this->assertStringContainsString('500', $first->nerby_error);

        // El siguiente formulario llega y, de paso, se reenvía el pendiente
        $this->post(route('contact.store'), $this->form(['email' => 'otra@example.com']))->assertRedirect(route('contact'));
        $this->assertSame(0, ContactMessage::pending()->count());
        $this->assertSame(2, $first->fresh()->nerby_attempts);
    }

    public function test_command_resends_pending_messages(): void
    {
        config(['services.nerby.leads_url' => self::URL]);
        Http::fake([self::URL => Http::sequence()->pushStatus(503)->push(['ok' => true])]);
        $this->post(route('contact.store'), $this->form());

        $this->artisan('losos:prospectos')->expectsOutputToContain('Enviados: 1 · pendientes: 0')->assertSuccessful();
    }

    public function test_without_the_nerby_url_messages_are_still_saved(): void
    {
        config(['services.nerby.leads_url' => null]);
        Http::fake();

        $this->post(route('contact.store'), $this->form())->assertRedirect(route('contact'))->assertSessionHas('status');

        $this->assertSame(1, ContactMessage::pending()->count());
        Http::assertNothingSent();
        $this->artisan('losos:prospectos')->assertFailed();
    }
}
