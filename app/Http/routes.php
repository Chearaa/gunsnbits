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
 * PayPal Routes
 */
Route::get('/paypal/payment', [
    'as' => 'paypal.payment',
    'uses' => 'PaypalController@postPayment'
]);
Route::get('/paypal/payment/status', [
    'as' => 'paypal.payment.status',
    'uses' => 'PaypalController@getPaymentStatus'
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
Route::GET('/admin/user/permissions/ajax/delete/{userid}/{role}', [
    'as' => 'admin.user.permissions.ajax.delete',
    'uses' => 'Admin\UserController@permissionsAjaxDelete'
]);
Route::GET('/admin/user/permissions/ajax/add/{userid}/{role}', [
    'as' => 'admin.user.permissions.ajax.add',
    'uses' => 'Admin\UserController@permissionsAjaxAdd'
]);

/*
 * LanpartyController
 */
Route::get('/lanparty/reservation', [
    'as'        => 'lanparty.reservation',
    'uses'      => 'LanpartyController@reservation'
]);

Route::post('/lanparty/reservation', [
    'before'    => 'csrf',
    'as'        => 'lanparty.reservation.post',
    'uses'      => 'LanpartyController@reservationPost'
]);

Route::post('/lanparty/reservation/delete', [
    'before'    => 'csrf',
    'as'        => 'lanparty.reservation.delete',
    'uses'      => 'LanpartyController@reservationDelete'
]);

Route::post('/lanparty/reservation/code', [
    'before'    => 'csrf',
    'as'        => 'lanparty.reservation.code',
    'uses'      => 'LanpartyController@reservationCode'
]);

Route::post('/lanparty/reservation/coins', [
    'before'    => 'csrf',
    'as'        => 'lanparty.reservation.coins',
    'uses'      => 'LanpartyController@reservationCoins'
]);

Route::get('/lanparty/seatingplan', [
    'as'        => 'lanparty.seatingplan',
    'uses'      => 'LanpartyController@plan'
]);

Route::get('/lanparty/member', [
    'as'        => 'lanparty.member',
    'uses'      => 'LanpartyController@member'
]);

//admin routes

Route::get('/admin/lanparty', [
    'as'        => 'admin.lanparty.listing',
    'uses'      => 'LanpartyController@listing'
]);

Route::get('/admin/lanparty/add', [
    'as'        => 'admin.lanparty.add',
    'uses'      => 'LanpartyController@add'
]);

Route::post('/admin/lanparty/add', [
    'before'    => 'csrf',
    'as'        => 'admin.lanparty.add.post',
    'uses'      => 'LanpartyController@postAdd'
]);

Route::get('/admin/lanparty/edit/{lanpartyid}', [
    'as'        => 'admin.lanparty.edit',
    'uses'      => 'LanpartyController@edit'
]);

Route::post('/admin/lanparty/edit/{lanpartyid}', [
    'before'    => 'csrf',
    'as'        => 'admin.lanparty.edit.post',
    'uses'      => 'LanpartyController@postEdit'
]);

Route::post('/admin/lanparty/delete', [
    'before'    => 'csrf',
    'as'        => 'admin.lanparty.delete.post',
    'uses'      => 'LanpartyController@postDelete'
]);

Route::get('/admin/lanparty/regularseats', [
    'as'        => 'admin.lanparty.regularseats',
    'uses'      => 'LanpartyController@getRegularseats'
]);

Route::post('/admin/lanparty/regularseats', [
    'before'    => 'csrf',
    'as'        => 'admin.lanparty.regularseats',
    'uses'      => 'LanpartyController@postRegularseats'
]);

Route::get('/admin/lanparty/{lanpartyid}/seatingplan', [
    'as'        => 'admin.lanparty.seatingplan',
    'uses'      => 'LanpartyController@seatingplan'
]);

Route::post('/admin/lanparty/{lanpartyid}/seatingplan', [
    'before'    => 'csrf',
    'as'        => 'admin.lanparty.seatingplan.post',
    'uses'      => 'LanpartyController@postSeatingplan'
]);

Route::get('/admin/lanparty/{lanpartyid}/memberlist', [
    'as'        => 'admin.lanparty.memberlist',
    'uses'      => 'LanpartyController@memberlist'
]);

Route::post('/admin/lanparty/{lanpartyid}/memberlist', [
    'before'    => 'csrf',
    'as'        => 'admin.lanparty.memberlist.post',
    'uses'      => 'LanpartyController@postMemberlist'
]);

/*
 * SponsorController
 */
Route::get('/sponsors', [
    'as'        => 'sponsor.list',
    'uses'      => 'SponsorController@listing'
]);

Route::get('/sponsors/{sponsor}', [
    'as'        => 'sponsor.show',
    'uses'      => 'SponsorController@show'
]);

Route::get('/admin/sponsors', [
    'as'        => 'admin.sponsor.list',
    'uses'      => 'SponsorController@adminListing'
]);

Route::get('/admin/sponsors/add', [
    'as'        => 'admin.sponsor.add',
    'uses'      => 'SponsorController@adminAdd'
]);

Route::post('/admin/sponsors/add', [
    'before'    => 'csrf',
    'as'        => 'admin.sponsor.add.post',
    'uses'      => 'SponsorController@adminPostAdd'
]);

Route::get('/admin/sponsors/{sponsor_id}/edit', [
    'as'        => 'admin.sponsor.edit',
    'uses'      => 'SponsorController@adminEdit'
]);

Route::post('/admin/sponsors/{sponsor_id}/edit', [
    'before'    => 'csrf',
    'as'        => 'admin.sponsor.edit.post',
    'uses'      => 'SponsorController@adminPostEdit'
]);

Route::post('/admin/sponsors', [
    'before'    => 'csrf',
    'as'        => 'admin.sponsor.delete.post',
    'uses'      => 'SponsorController@adminPostDelete'
]);

/*
 * CateringController
 */
Route::get('/catering', [
    'as'        => 'catering.list',
    'uses'      => 'CateringController@listing'
]);

Route::get('/admin/catering', [
    'as'        => 'admin.catering.list',
    'uses'      => 'CateringController@adminList'
]);

Route::get('/admin/catering/add', [
    'as'        => 'admin.catering.add',
    'uses'      => 'CateringController@adminAdd'
]);

Route::post('/admin/catering/add/check', [
    'before'    => 'csrf',
    'as'        => 'admin.catering.add.check',
    'uses'      => 'CateringController@adminAddCheck'
]);

Route::post('/admin/catering/delete', [
    'before'    => 'csrf',
    'as'        => 'admin.catering.delete.post',
    'uses'      => 'CateringController@adminPostDelete'
]);

Route::post('/admin/catering/ajaxsort', [
    'as'        => 'admin.catering.ajaxsort',
    'uses'      => 'CateringController@adminAjaxSort'
]);

/*
 * CodeController
 */
Route::get('/admin/codes', [
    'as'        => 'admin.code.listing',
    'uses'      => 'CodeController@listing'
]);

Route::get('/admin/codes/add', [
    'as'        => 'admin.code.add',
    'uses'      => 'CodeController@add'
]);

Route::post('/admin/codes/add', [
    'before'    => 'csrf',
    'as'        => 'admin.code.add.post',
    'uses'      => 'CodeController@postAdd'
]);

/*
 * CoinController
 */
Route::get('/admin/coins', [
    'as'        => 'admin.coin.user',
    'uses'      => 'CoinController@user'
]);

Route::post('/admin/coins', [
    'before'    => 'csrf',
    'as'        => 'admin.coin.user.post',
    'uses'      => 'CoinController@postUser'
]);

Route::get('/admin/coins/user/{user_id}', [
    'as'        => 'admin.coin.user.list',
    'uses'      => 'CoinController@listUser'
]);

Route::post('/admin/coins/user/{user_id}/add', [
    'before'    => 'csrf',
    'as'        => 'admin.coin.user.add',
    'uses'      => 'CoinController@addUser'
]);

Route::post('/admin/coins/user/{user_id}/delete', [
    'before'    => 'csrf',
    'as'        => 'admin.coin.user.delete',
    'uses'      => 'CoinController@deleteCoin'
]);

/*
 * AjaxController
 */
Route::get('/ajax/users', [
    'as'        => 'ajax.users',
    'uses'      => 'AjaxController@users'
]);