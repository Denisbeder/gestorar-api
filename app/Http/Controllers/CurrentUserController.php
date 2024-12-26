<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CurrentUserController extends Controller
{
    public function __invoke(Request $request): User
    {
        return $request->user();
    }
}
