<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Permissions view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permissions() {
        return view('admin.user.permissions', [
            'users' => User::all()
        ]);
    }

    /**
     * Ajax action to delete permissionmanager role.
     *
     * @param $userid
     * @return string
     */
    public function permissionsAjaxDelete($userid) {
        $user = User::findOrFail($userid);
        if (!is_null($user) && $user->id != Auth::user()->id) {
            if ($user->hasRole('permissionmanager')) {
                $user->removeRole('permissionmanager');
                return 'success';
            }
        }
        return 'error';
    }

    /**
     * Ajax action to add permissionmanager role.
     *
     * @param $userid
     * @return string
     */
    public function permissionsAjaxAdd($userid) {
        $user = User::findOrFail($userid);
        if (!is_null($user)) {
            if (!$user->hasRole('permissionmanager')) {
                $user->assignRole('permissionmanager');
                return 'success';
            }
        }
        return 'error';
    }
}
