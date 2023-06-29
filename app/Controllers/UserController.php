<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController
{
    public function index(): string
    {
        return view('pages/users/index');
    }

    public function create(): string
    {
        return view('pages/users/form');
    }

    public function edit(int $id): string
    {
        $userModel = new User();

        $user = $userModel->find($id);

        return view('pages/users/form', [
            'user' => $user,
        ]);
    }
}
