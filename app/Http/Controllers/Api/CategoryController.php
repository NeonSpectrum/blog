<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Category[]|Collection
     */
    public function index()
    {
        return Category::all();
    }
}
