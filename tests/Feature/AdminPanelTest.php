<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogSeeder::class);
        Storage::fake('public');
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin/productos')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_log_in(): void
    {
        $user = User::factory()->create(['password' => 'secreto123']);

        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'secreto123'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_pages_load(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([
            route('admin.dashboard'),
            route('admin.products.index'),
            route('admin.products.create'),
            route('admin.products.edit', Product::first()),
            route('admin.categories.index'),
            route('admin.categories.edit', Category::first()),
            route('admin.brands.index'),
            route('admin.brands.create'),
            route('admin.site-images.index'),
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_admin_can_create_a_product_with_images_and_specs(): void
    {
        $this->actingAs(User::factory()->create());
        $category = Category::where('slug', 'maquinaria-muevetierra')->first();

        $this->post(route('admin.products.store'), [
            'name' => 'Equipo de prueba',
            'category_id' => $category->id,
            'product_type_id' => $category->types->first()->id,
            'is_published' => 1,
            'card_specs' => [['label' => 'Peso', 'value' => '10 t'], ['label' => '', 'value' => '']],
            'spec_groups' => [['title' => 'Motor', 'rows' => [['label' => 'Potencia', 'value' => '90 kW']]]],
            'images' => [UploadedFile::fake()->image('foto.jpg', 1200, 900)],
        ])->assertRedirect();

        $product = Product::where('slug', 'equipo-de-prueba')->firstOrFail();

        $this->assertSame([['label' => 'Peso', 'value' => '10 t']], $product->card_specs);
        $this->assertSame('Motor', $product->spec_groups[0]['title']);
        $this->assertCount(1, $product->images);
        Storage::disk('public')->assertExists(substr($product->images->first()->path, strlen('storage/')));

        $this->get(route('products.show', [$category->slug, $product->slug]))->assertOk()->assertSee('Equipo de prueba');
    }

    public function test_type_must_belong_to_category(): void
    {
        $this->actingAs(User::factory()->create());
        [$first, $second] = Category::ordered()->get();

        $this->post(route('admin.products.store'), [
            'name' => 'Mal tipo',
            'category_id' => $first->id,
            'product_type_id' => $second->types->first()->id,
        ])->assertSessionHasErrors('product_type_id');
    }

    public function test_category_with_products_cannot_be_deleted(): void
    {
        $this->actingAs(User::factory()->create());
        $category = Category::has('products')->first();

        $this->delete(route('admin.categories.destroy', $category))->assertSessionHas('error');
        $this->assertModelExists($category);
    }

    public function test_hidden_brands_are_not_shown(): void
    {
        Brand::where('name', 'Zoomlion')->update(['is_active' => false]);

        $this->get('/quienes-somos')->assertOk()->assertDontSee('Zoomlion</li>', false);
    }
}
