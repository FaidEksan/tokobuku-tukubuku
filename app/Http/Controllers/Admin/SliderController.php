<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Traits\ImageHandlerTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ImageHandlerTrait;

    /**
     * Display a listing of the sliders.
     */
    public function index()
    {
        $sliders = Slider::paginate(5);
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new slider.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created slider in storage.
     */
    public function store(SliderRequest $request)
    {
        // Upload gambar menggunakan trait
        $imageName = $this->uploadImage($request->file('image'), 'sliders');

        Slider::create([
            'image' => $imageName,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully.');
    }

    /**
     * Show the form for editing the specified slider.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified slider in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Update image using trait
            $slider->image = $this->updateImage($slider->image, $request->file('image'), 'sliders');
        }

        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    /**
     * Remove the specified slider from storage.
     */
    public function destroy(Slider $slider)
    {
        // Delete image using trait
        $this->deleteImage($slider->image, 'sliders');
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully.');
    }
}