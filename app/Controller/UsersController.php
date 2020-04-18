<?php

namespace App\Controller;

class UsersController
{
    public function index()
    {
        return 'show all users. ';
    }

    public function show (array $id) {
        return 'User ' . $id['id'];
    }
}