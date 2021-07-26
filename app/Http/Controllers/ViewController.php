<?php

namespace App\Http\Controllers;

/**
 * Class ViewController
 *
 * @package App\Http\Controllers
 */
class ViewController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
