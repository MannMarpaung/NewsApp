<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// p
class ProfileController extends Controller
{
    public function index() {
        return view('home.profile.index');
    }
}