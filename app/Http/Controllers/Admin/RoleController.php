<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\User;

class RoleController extends BaseController
{
    public function index()
    {
        var_dump(User::where(['id' => 1])->first()->hasRole('admin')); // true
        var_dump(User::where(['id' => 1])->first()->can('create-post')); // true
        return view('admin.role.index');
    }
}
