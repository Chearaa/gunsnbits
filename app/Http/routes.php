<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
 * Authentication Routes
 */
$this->get('login', [
    'as' => 'auth.login',
    'uses' => 'Auth\AuthController@showLoginForm'
]);
$this->post('login', [
    'as' => 'auth.login',
    'uses' => 'Auth\AuthController@login'
]);
$this->get('logout', [
    'as' => 'auth.logout',
    'uses' => 'Auth\AuthController@logout'
]);

/*
 * Registration Routes
 */
$this->get('register', [
    'as' => 'auth.register',
    'uses' => 'Auth\AuthController@showRegistrationForm'
]);
$this->post('register', [
    'as' => 'auth.register',
    'uses' => 'Auth\AuthController@register'
]);

/*
 * Password Reset Routes
 */
$this->get('password/reset/{token?}', [
    'as' => 'auth.password.reset',
    'uses' => 'Auth\PasswordController@showResetForm'
]);
$this->post('password/email', [
    'as' => 'auth.password.email',
    'uses' => 'Auth\PasswordController@sendResetLinkEmail'
]);
$this->post('password/reset', [
    'as' => 'auth.password.reset',
    'uses' => 'Auth\PasswordController@reset'
]);

/*
 * Facebook Routes
 */
Route::get('/facebook/callback', [
    'as' => 'facebook.callback',
    'uses' => 'Auth\FacebookController@callback'
]);
Route::get('/facebook/error', [
    'as' => 'facebook.error',
    'uses' => 'Auth\FacebookController@error'
]);

/*
 * HomeController
 */
Route::get('/', [
    'as' => 'welcome',
    'uses' => 'HomeController@welcome'
]);

Route::get('/home', [
    'as' => 'home',
    'uses' => 'HomeController@home'
]);

/*
 * AdminUserController
 */
Route::get('/admin/user/permissions', [
    'as' => 'admin.user.permissions',
    'uses' => 'Admin\UserController@permissions'
]);
Route::GET('/admin/user/permissions/ajax/delete/{userid}', [
    'as' => 'admin.user.permissions.ajax.delete',
    'uses' => 'Admin\UserController@permissionsAjaxDelete'
]);
Route::GET('/admin/user/permissions/ajax/add/{userid}', [
    'as' => 'admin.user.permissions.ajax.add',
    'uses' => 'Admin\UserController@permissionsAjaxAdd'
]);

