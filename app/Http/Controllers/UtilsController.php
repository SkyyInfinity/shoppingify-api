<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilsController extends Controller
{
    /**
     * Generate a new token base on time and random number.
     *
     * @return string
     */
    public function generateToken(): string
    {
        return md5(strval(time() * rand(175, 658)));
    }
}
