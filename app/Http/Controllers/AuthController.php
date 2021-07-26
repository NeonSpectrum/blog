<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function login(Request $request) : array
    {
        $credentials = $request->only(['username', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return ['success' => false, 'message' => __('auth.failed')];
        }

        return ['success' => true, 'message' => __('auth.success'), 'token' => $token];
    }

    /**
     * @return array
     */
    public function user() : array
    {
        return ['user' => auth()->user()];
    }
}
