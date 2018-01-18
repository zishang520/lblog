<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\User;

class UserCOntroller extends BaseController
{
    public function index()
    {
        return view('admin.user.index')->withUsers(User::all());
    }
}
