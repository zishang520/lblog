<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return response()->json(["a" => '管理员']);
    }
}
