<?php

namespace App\Controller;

class PostController
{
    public function index()
    {
        return'show all posts. ';
    }

    public function show(array $id)
    {
        return'show '. $id['id'];
    }
}