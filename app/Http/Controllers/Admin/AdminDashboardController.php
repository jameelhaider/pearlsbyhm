<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.admin');
    }

    public function settings()
    {
        $settings = DB::table('settings')->where('id', '1')->first();
        return view('admin.settings', compact('settings'));
    }

    public function settingsupdate(Request $request)
    {
        $request->validate([
            'site_name' => ['required'],
            'shipping_charges'  => ['required'],
            'shipping_free_on'      => ['required'],
            'site_description'    => ['required'],
        ]);
        $settings = Setting::first();
        if ($request->hasFile('site_logo')) {
            $previousImagePath = $settings->site_logo;
            $settings->site_logo = CommonController::imgUpload($request->site_logo, 'Site Logos', $previousImagePath);
        }
        $settings->site_name = $request->site_name;
        $settings->shipping_charges = $request->shipping_charges;
        $settings->shipping_free_on = $request->shipping_free_on;
        $settings->site_description = $request->site_description;
        $settings->save();
        return back()->with('success', 'Settings Updated Successfully!');
    }
}
