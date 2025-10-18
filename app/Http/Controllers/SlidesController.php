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
        $slide->link = $request->link ?? null;
        $slide->text = $request->text ?? null;
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
        $slide->text = $request->text ?? null;
        $slide->link = $request->link ?? null;
        $slide->save();
        return redirect()
            ->route('admin.slide.index')
            ->with('success', 'Slide updated successfully.');
    }



    public function delete($id)
    {
        $slide = DB::table('slides')->where('id', $id)->first();
        if ($slide) {
            if (file_exists(public_path($slide->image))) {
                unlink(public_path($slide->image));
            }
            DB::table('slides')->where('id', $id)->delete();
            return redirect()
                ->route('admin.slide.index')
                ->with('success', 'Slide deleted successfully.');
        } else {
            return redirect()
                ->route('admin.slide.index')
                ->with('error', 'Slide not found.');
        }
    }
}
