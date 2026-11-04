<?php

namespace App\Http\Controllers;

use App\Services\LiteLLM\ModelsCatalog;

class DocsController extends Controller
{
    public function __construct(private readonly ModelsCatalog $models) {}

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
        return view('docs.models', [
            'groups' => $this->models->grouped(),
        ]);
    }
}
