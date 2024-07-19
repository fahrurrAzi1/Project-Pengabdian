<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $contents = Content::all();

        return view('guru.dashboard', compact('contents'));
    }
}
