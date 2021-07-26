<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection|User[]
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param string  $userType
     *
     * @return array
     */
    public function store(Request $request) : array
    {
        $user = new User;
        $user->fill($request->only(['name', 'username', 'password']));

        if (optional(auth()->user())->user_type === 'admin') {
            $user->user_type = $request->get('userType');
        } else {
            $user->user_type = 'user';
        }

        if (!$user->save()) {
            return ['success' => false, 'message' => __('api.user.register_failed')];
        }

        return ['success' => true, 'message' => __('api.user.register_success')];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return array
     */
    public function update(Request $request, $id) : array
    {
        $user = User::find($id);
        $user->fill($request->only(['name', 'username', 'password']));

        if (!$user->save()) {
            return ['success' => false, 'message' => __('api.save_failed')];
        }

        return ['success' => true, 'message' => __('api.save_success')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
