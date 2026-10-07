<?php

namespace Tests\Feature;

use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_respond(): void
    {
        $this->seed(CatalogSeeder::class);

        foreach (['/', '/quienes-somos', '/productos', '/servicios', '/contacto', '/productos/maquinaria-muevetierra/ze215e-pro'] as $url) {
            $this->get($url)->assertOk();
        }
    }
}
