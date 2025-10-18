<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountsController extends Controller
{
    public function index()
    {
        return view('accounts.index');
    }
    public function myorders()
    {
        $myorders = DB::table('orders')->where('user_id', Auth::id())
        ->orderBy('created_at','desc')->get();
        return view('accounts.orders.myorders', compact('myorders'));
    }

    public function myorderdetail($url)
    {
        $order = DB::table('orders')->where('url', $url)->first();
        if (!$order) {
            return redirect()->route('myorders.index')->with('error', 'Order not found.');
        }
        if ($order->user_id != auth()->id()) {
            return redirect()->route('myorders.index')->with('error', 'Unauthorized action.');
        }
        $order_items = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'order_items.*',
                'products.image as product_image',
                'products.url as url',
            )
            ->where('order_items.order_id', $order->id)
            ->get();
        return view('accounts.orders.details', compact('order', 'order_items'));
    }


    public function myaddresses()
    {
        $myaddresses = DB::table('addresses')->where('user_id', Auth::id())->get();
        return view('accounts.address.index', compact('myaddresses'));
    }
    public function createaddress()
    {
        $address = new Address();
        return view('accounts.address.create', compact('address'));
    }
    public function editaddress($url)
    {
        $address = DB::table('addresses')->where('url', $url)->first();
        if (!$address) {
            return redirect()->route('address.index')
                ->with('error', 'Address not found!');
        }
        if ($address->user_id == Auth::id()) {

            return view('accounts.address.create', compact('address'));
        } else {
            return redirect()->route('address.index')
                ->with('error', 'Unauthorized action!');
        }
    }
    public function saveaddress(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'last_name'  => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'address'    => ['required', 'string', 'max:500'],
            'city'       => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'phone'      => ['required', 'regex:/^03[0-9]{2}-[0-9]{7}$/'],
            'postal_code' => ['nullable', 'regex:/^[0-9]{5}$/'],
            'landmark'   => ['nullable', 'string', 'max:255'],
        ], [
            'first_name.regex' => 'First name can only contain letters and spaces.',
            'last_name.regex'  => 'Last name can only contain letters and spaces.',
            'city.regex'       => 'City name can only contain letters and spaces.',
            'phone.regex'      => 'Phone number must be in the format 03XX-XXXXXXX (e.g., 0300-0000000).',
            'postal_code.regex' => 'Postal code must be a 5-digit number.',
        ]);


        $address = new Address();
        $address->url = 'address'.'-r' . rand(1000, 9999) . '-t' . time();
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->landmark = $request->landmark ?? null;
        $address->postal_code = $request->postal_code ?? null;
        $address->user_id = Auth::id();
        $address->save();
        return redirect()->route('address.index')->with('success', 'Address Save Successfully!');
    }

    public function updateaddress(Request $request, $id)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'last_name'  => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'address'    => ['required', 'string', 'max:500'],
            'city'       => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'phone'      => ['required', 'regex:/^03[0-9]{2}-[0-9]{7}$/'],
            'postal_code' => ['nullable', 'regex:/^[0-9]{5}$/'],
            'landmark'   => ['nullable', 'string', 'max:255'],
        ], [
            'first_name.regex' => 'First name can only contain letters and spaces.',
            'last_name.regex'  => 'Last name can only contain letters and spaces.',
            'city.regex'       => 'City name can only contain letters and spaces.',
            'phone.regex'      => 'Phone number must be in the format 03XX-XXXXXXX (e.g., 0300-0000000).',
            'postal_code.regex' => 'Postal code must be a 5-digit number.',
        ]);
        $address = Address::find($id);
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->url = $address->url;
        $address->landmark = $request->landmark ?? null;
        $address->postal_code = $request->postal_code ?? null;
        $address->user_id = Auth::id();
        $address->update();
        return redirect()->route('address.index')->with('success', 'Address Updated Successfully!');
    }


    public function deleteaddress($id)
    {
        $address = Address::find($id);
        if (!$address) {
            return redirect()->route('address.index')
                ->with('error', 'Address not found!');
        }
        if ($address->user_id == Auth::id()) {
            $address->delete();
            return redirect()->route('address.index')
                ->with('success', 'Address Deleted Successfully!');
        } else {
            return redirect()->route('address.index')
                ->with('error', 'Unauthorized action!');
        }
    }


    public function changepassword()
    {
        return view('accounts.changepassword');
    }

    public function changepasswordsave(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8'],
        ]);
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Your new password cannot be the same as the old password.']);
        }
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        return redirect()->route('change.password')->with('success', 'Password updated successfully!');
    }
}
