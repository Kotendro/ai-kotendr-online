<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{
    public function index()
    {
        return view('docs.index');
    }

    public function integration()
    {
        return view('docs.integration');
    }

    public function models()
    {
        return view('docs.models');
    }
}