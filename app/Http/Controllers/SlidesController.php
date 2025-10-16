<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SlidesController extends Controller
{
    public function index()
    {
        $slides = DB::table('slides')->paginate(20);
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        $slide = new Slide();
        return view("admin.slides.create", compact('slide'));
    }

    public function edit($id)
    {
        $slide = Slide::find($id);
        if (!$slide)
            return redirect()->back();
        return view("admin.slides.create", compact('slide'));
    }


    public function submit(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        $slide = new Slide();
        if ($request->hasFile('image')) {
            $slide->image = CommonController::imgUpload($request->image, 'Slide Images');
        }
        $slide->link = $request->link;
        $slide->text = $request->text;
        $slide->save();
        return redirect()
            ->route('admin.slide.index')
            ->with('success', 'Slide Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $previousImage = $slide->image;
            $slide->image = CommonController::imgUpload($request->image, 'Slide Images', $previousImage);
        }
        $slide->text = $request->text;
        $slide->link = $request->link;
        $slide->save();
        return redirect()
            ->route('admin.slide.index')
            ->with('success', 'Slide updated successfully.');
    }
}
