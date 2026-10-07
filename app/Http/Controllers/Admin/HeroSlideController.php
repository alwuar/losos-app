<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroSlideRequest;
use App\Models\HeroSlide;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        return view('admin.slides.index', [
            'slides' => HeroSlide::ordered()->get(),
            'activeCount' => HeroSlide::active()->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.slides.form', [
            'slide' => new HeroSlide(['is_active' => true, 'sort_order' => HeroSlide::max('sort_order') + 1]),
        ]);
    }

    public function store(HeroSlideRequest $request): RedirectResponse
    {
        HeroSlide::create([
            ...$this->attributes($request),
            'image' => Uploads::store($request->file('image'), 'slides'),
        ]);

        return redirect()->route('admin.slides.index')->with('status', 'Diapositiva agregada.');
    }

    public function edit(HeroSlide $slide): View
    {
        return view('admin.slides.form', ['slide' => $slide]);
    }

    public function update(HeroSlideRequest $request, HeroSlide $slide): RedirectResponse
    {
        $slide->update($this->attributes($request));

        if ($request->hasFile('image')) {
            Uploads::delete($slide->image);
            $slide->update(['image' => Uploads::store($request->file('image'), 'slides')]);
        }

        return redirect()->route('admin.slides.index')->with('status', 'Cambios guardados.');
    }

    public function destroy(HeroSlide $slide): RedirectResponse
    {
        Uploads::delete($slide->image);
        $slide->delete();

        return redirect()->route('admin.slides.index')->with('status', 'Diapositiva eliminada.');
    }

    protected function attributes(HeroSlideRequest $request): array
    {
        return [
            ...$request->safe()->only([
                'title', 'text',
                'primary_label', 'primary_url',
                'secondary_label', 'secondary_url',
            ]),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->validated('sort_order') ?? 0,
        ];
    }
}
