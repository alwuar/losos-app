<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteImage;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteImageController extends Controller
{
    public function index(): View
    {
        // Asegura que existan todas las imágenes definidas en config/losos.php
        $order = 0;

        foreach (config('losos.site_images') as $key => $item) {
            SiteImage::firstOrCreate(['key' => $key], [
                'label' => $item['label'],
                'help' => $item['help'] ?? null,
                'sort_order' => $order++,
            ]);
        }

        return view('admin.site-images.index', [
            'images' => SiteImage::query()
                ->whereIn('key', array_keys(config('losos.site_images')))
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function update(Request $request, SiteImage $siteImage): RedirectResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ], [], ['image' => 'imagen']);

        Uploads::delete($siteImage->path);
        $siteImage->update(['path' => Uploads::store($request->file('image'), 'site')]);
        SiteImage::flushCache();

        return redirect()->route('admin.site-images.index')->with('status', "Se actualizó «{$siteImage->label}».");
    }

    /**
     * Vuelve a la imagen por defecto.
     */
    public function destroy(SiteImage $siteImage): RedirectResponse
    {
        Uploads::delete($siteImage->path);
        $siteImage->update(['path' => null]);
        SiteImage::flushCache();

        return redirect()->route('admin.site-images.index')->with('status', "«{$siteImage->label}» volvió a la imagen original.");
    }
}
