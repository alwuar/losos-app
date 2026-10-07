<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        return view('admin.brands.index', ['brands' => Brand::ordered()->get()]);
    }

    public function create(): View
    {
        return view('admin.brands.form', ['brand' => new Brand(['is_active' => true, 'sort_order' => Brand::max('sort_order') + 1])]);
    }

    public function store(BrandRequest $request): RedirectResponse
    {
        $brand = Brand::create($this->attributes($request));
        $this->syncLogo($request, $brand);

        return redirect()->route('admin.brands.index')->with('status', 'Marca agregada.');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.form', ['brand' => $brand]);
    }

    public function update(BrandRequest $request, Brand $brand): RedirectResponse
    {
        $brand->update($this->attributes($request));
        $this->syncLogo($request, $brand);

        return redirect()->route('admin.brands.index')->with('status', 'Cambios guardados.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        Uploads::delete($brand->logo);
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('status', "Se eliminó «{$brand->name}».");
    }

    protected function attributes(BrandRequest $request): array
    {
        return [
            'name' => $request->validated('name'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->validated('sort_order') ?? 0,
        ];
    }

    protected function syncLogo(BrandRequest $request, Brand $brand): void
    {
        if ($request->boolean('remove_logo') || $request->hasFile('logo')) {
            Uploads::delete($brand->logo);
            $brand->update(['logo' => null]);
        }

        if ($request->hasFile('logo')) {
            $brand->update(['logo' => Uploads::store($request->file('logo'), 'brands')]);
        }
    }
}
