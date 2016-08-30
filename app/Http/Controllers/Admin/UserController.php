<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
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
     * Ajax action to delete roles from user.
     *
     * @param $userid
     * @return string
     */
    public function permissionsAjaxDelete($userid, $roleid) {
        $user = User::findOrFail($userid);
        $role = Role::findOrFail($roleid);
        if ((!is_null($user) && !is_null($role) && !($user->id == Auth::user()->id && $role->name == 'permissionmanager')) || Auth::user()->isAdmin()) {
            if ($user->hasRole($role->name)) {
                $user->removeRole($role->name);
                return 'success';
            }
        }
        return 'error';
    }

    /**
     * Ajax action to add roles to user.
     *
     * @param $userid
     * @return string
     */
    public function permissionsAjaxAdd($userid, $roleid) {
        $user = User::findOrFail($userid);
        $role = Role::findOrFail($roleid);
        if ((!is_null($user) && !is_null($role) && !($user->id == Auth::user()->id && $role->name == 'permissionmanager')) || Auth::user()->isAdmin()) {
            if (!$user->hasRole($role->name)) {
                $user->assignRole($role->name);
                return 'success';
            }
        }
        return 'error';
    }
}
