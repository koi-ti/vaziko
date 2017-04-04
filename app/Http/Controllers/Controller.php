<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        $this->middleware('permission:consultar');
        $this->middleware('permission:crear', ['only' => 'create', 'store']);
        $this->middleware('permission:editar', ['only' => 'edit', 'update']);
    }
}
