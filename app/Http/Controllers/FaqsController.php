<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqsController extends Controller
{
    public function index(){
        $faqs=DB::table('faqs')->paginate(100);
        return view('admin.faqs.index',compact('faqs'));
    }

     public function create()
    {
        $faq = new Faq();
        return view("admin.faqs.create", compact('faq'));
    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        if (!$faq)
            return redirect()->back();
        return view("admin.faqs.create", compact('faq'));
    }

     public function submit(Request $request)
    {
        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ Added Successfully');
    }

        public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ updated successfully.');
    }


}
