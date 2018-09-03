<?php

namespace Acostadu\Pagos_pro\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index(Request $request)
    {
        //return Cat::says();
        return "Hola mundo Laravel";
    }
}