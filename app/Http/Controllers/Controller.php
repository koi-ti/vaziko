<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        $this->middleware('ability:admin,consultar', ['only' => ['index', 'show']]);
        $this->middleware('ability:admin,crear', ['only' => ['create']]);
        $this->middleware('ability:admin,crear|editar', ['only' => ['store']]);
        $this->middleware('ability:admin,editar', ['only' => ['edit', 'update']]);
        $this->middleware('ability:admin,eliminar', ['only' => ['destroy']]);
        $this->middleware('ability:admin,anular', ['only' => ['anular']]);
        $this->middleware('ability:admin,cerrar', ['only' => ['cerrar']]);
        $this->middleware('ability:admin,abrir', ['only' => ['abrir']]);
        $this->middleware('ability:admin,culminar', ['only' => ['culminar']]);
        $this->middleware('ability:admin,clonar', ['only' => ['clonar']]);
        $this->middleware('ability:admin,exportar', ['only' => ['exportar']]);
        $this->middleware('ability:admin,graficas', ['only' => ['graficas']]);
    }
}
