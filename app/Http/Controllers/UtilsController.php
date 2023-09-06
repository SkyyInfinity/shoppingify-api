<?php

namespace App\Http\Controllers;

class UtilsController extends Controller
{
    /**
     * Generate a new token base on time and random number.
     */
    public function generateToken(): string
    {
        return md5(strval(time() * rand(175, 658)));
    }
}
