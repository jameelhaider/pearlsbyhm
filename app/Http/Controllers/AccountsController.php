<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
       public function index()
    {
        return view('accounts.index');
    }
      public function myorders()
    {
        $myorders=DB::table('orders')->where('user_id',Auth::id())->get();
        return view('accounts.myorders',compact('myorders'));
    }
       public function myaddresses()
    {
        $myaddresses=DB::table('addresses')->where('user_id',Auth::id())->get();
        return view('accounts.myaddresses',compact('myaddresses'));
    }
}
