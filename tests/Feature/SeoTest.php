<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogSeeder::class);
    }

    public function test_pages_have_social_meta_tags(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<meta property="og:title"', false)
            ->assertSee('<meta property="og:image"', false)
            ->assertSee('<meta name="twitter:card" content="summary_large_image">', false)
            ->assertSee('<link rel="canonical"', false)
            ->assertSee('"@type":"LocalBusiness"', false);
    }

    public function test_product_page_has_its_own_title_canonical_and_breadcrumbs(): void
    {
        $product = Product::query()->published()->with('category')->firstOrFail();
        $url = route('products.show', [$product->category->slug, $product->slug]);

        $this->get($url)
            ->assertOk()
            ->assertSee('<title>'.e($product->name), false)
            ->assertSee('<link rel="canonical" href="'.$url.'">', false)
            ->assertSee('"@type":"BreadcrumbList"', false);
    }

    public function test_pages_are_not_indexable_outside_production(): void
    {
        config(['losos.seo.indexable' => false]);

        $this->get('/')->assertSee('<meta name="robots" content="noindex, nofollow">', false);

        config(['losos.seo.indexable' => true]);

        $this->get('/')->assertSee('<meta name="robots" content="index, follow', false);
    }

    public function test_sitemap_lists_published_products(): void
    {
        $product = Product::query()->published()->with('category')->firstOrFail();
        $hidden = Product::query()->published()->with('category')->latest('id')->firstOrFail();
        $hidden->update(['is_published' => false]);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(route('products.show', [$product->category->slug, $product->slug]), false)
            ->assertDontSee(route('products.show', [$hidden->category->slug, $hidden->slug]), false);
    }
}
