<?php

namespace Tests\Feature;

use App\Models\HeroSlide;
use App\Models\User;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HeroSliderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogSeeder::class);
    }

    public function test_one_visible_slide_is_a_static_header(): void
    {
        $this->assertSame(1, HeroSlide::active()->count());

        $this->get('/')
            ->assertOk()
            ->assertSee('convierte en construcción.')
            ->assertDontSee('data-hero-slider', false);
    }

    public function test_two_visible_slides_become_a_slider(): void
    {
        HeroSlide::create([
            'image' => 'images/home/hero.jpg',
            'title' => 'Renta de maquinaria',
            'primary_label' => 'Ver servicios',
            'primary_url' => '/servicios',
            'sort_order' => 2,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('data-hero-slider', false)
            ->assertSee('Renta de maquinaria')
            ->assertSee(url('/servicios'), false);
    }

    public function test_hidden_slides_are_not_shown_and_header_falls_back_to_default(): void
    {
        HeroSlide::query()->update(['is_active' => false]);

        $this->get('/')
            ->assertOk()
            ->assertSee('convierte en construcción.')
            ->assertDontSee('data-hero-slider', false);
    }

    public function test_admin_can_create_update_and_delete_slides(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        $this->post(route('admin.slides.store'), [
            'image' => UploadedFile::fake()->image('slide.jpg', 1920, 840),
            'title' => 'Nueva promoción',
            'text' => 'Texto de prueba',
            'primary_label' => 'Cotizar',
            'primary_url' => '/contacto',
            'is_active' => 1,
            'sort_order' => 5,
        ])->assertRedirect(route('admin.slides.index'));

        $slide = HeroSlide::where('title', 'Nueva promoción')->firstOrFail();
        Storage::disk('public')->assertExists(str_replace('storage/', '', $slide->image));

        $this->put(route('admin.slides.update', $slide), [
            'title' => 'Promoción editada',
            'is_active' => 0,
            'sort_order' => 5,
        ])->assertRedirect(route('admin.slides.index'));

        $this->assertFalse($slide->fresh()->is_active);
        $this->assertSame('Promoción editada', $slide->fresh()->title);

        $this->delete(route('admin.slides.destroy', $slide))->assertRedirect(route('admin.slides.index'));
        $this->assertModelMissing($slide);
        Storage::disk('public')->assertMissing(str_replace('storage/', '', $slide->image));
    }

    public function test_slide_requires_image_and_valid_button_links(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('admin.slides.store'), [
            'title' => 'Sin imagen',
            'primary_label' => 'Ver',
            'primary_url' => 'productos',
        ])->assertSessionHasErrors(['image', 'primary_url']);
    }

    public function test_guests_cannot_manage_slides(): void
    {
        $this->get(route('admin.slides.index'))->assertRedirect(route('admin.login'));
    }
}
