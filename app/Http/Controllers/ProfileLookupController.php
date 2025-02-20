<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileLookupController extends Controller
{
    public function index()
    {
        return view('profile.lookup');
    }
}