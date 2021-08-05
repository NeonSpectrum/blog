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
     * @return User[]|Collection
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return array
     */
    public function store(Request $request) : array
    {
        if ($this->checkIfUserExists($request->get('username'))) {
            return ['success' => false, 'message' => __('api.user.already_exists')];
        }

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
        $user->fill($request->only(['name', 'username', 'password', 'userType']));

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
     * @return array
     */
    public function destroy(int $id) : array
    {
        $user = User::find($id);

        if (!$user->delete()) {
            return ['success' => false, 'message' => __('api.delete_failed')];
        }

        return ['success' => true, 'message' => __('api.delete_success')];
    }

    /**
     * Check if username exists on database
     *
     * @param string $username
     *
     * @return bool
     */
    private function checkIfUserExists(string $username) : bool
    {
       return User::where('username', $username)->exists();
    }
}
