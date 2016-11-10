<?php

namespace App\Http\Controllers;

use App\Bankaccountcheck;
use App\Http\Requests;
use App\Sponsor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Fbpost;
use App\Lanparty;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Home view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home() {
        return redirect(route('welcome'));
    }

    /**
     * Welcome view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome() {

        $reservedseats = null;
        $usercanreserveseats = 0;
        $progress = [
            'max' => 0,
            'min' => 0,
            'reserved' => [
                'percent' => 0,
                'value' => 0
            ],
            'marked' => [
                'percent' => 0,
                'value' => 0
            ],
            'free' => [
                'percent' => 0,
                'value' => 0
            ],
            'disabled' => [
                'percent' => 0,
                'value' => 0
            ]
        ];
        $last_bankaccount_check = null;

        //get next lanparty
        $lanparty = Lanparty::getNextLan();
        $user = (Auth::check()) ? Auth::user() : null;

        if ($lanparty instanceof Lanparty) {
            $reservedseats = $lanparty->getReservedSeats();
            $usercanreserveseats = (!is_null($user) && $user->seats()->where('lanparty_id', $lanparty->id)->get()->count() < $user->maxseats) ? ($user->maxseats - $user->seats()->where('lanparty_id', $lanparty->id)->get()->count()) : 0;

            $progress['max'] = config('lanparty')['maxseats'];

            $progress['reserved']['value'] = count($lanparty->getReservations()['reserved']);
            $progress['marked']['value'] = count($lanparty->getReservations()['marked']);
            $progress['deactivated']['value'] = count($lanparty->getReservations()['deactivated']);
            $progress['free']['value'] = $progress['max'] - $progress['reserved']['value'] - $progress['marked']['value'] - $progress['deactivated']['value'];

            $progress['reserved']['percent'] = (100/$progress['max']) * $progress['reserved']['value'];
            $progress['marked']['percent'] = (100/$progress['max']) * $progress['marked']['value'];
            $progress['deactivated']['percent'] = (100/$progress['max']) * $progress['deactivated']['value'];
            $progress['free']['percent'] = (100/$progress['max']) * $progress['free']['value'];

            //get last check
            $last_bankaccount_check = Bankaccountcheck::all()->last();
        }

        $posts = Fbpost::all()
            ->sortByDesc('created_time')->take(5);

        $sponsors = Sponsor::all()->shuffle();

        $users = User::all()->where('deleted_at', null);

        return view('welcome', compact(
            'posts',
            'lanparty',
            'user',
            'usercanreserveseats',
            'reservedseats',
            'progress',
            'last_bankaccount_check',
            'sponsors',
            'users'
        ));
    }

    /**
     * bankaccount check function
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function bankaccountcheck() {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
            return redirect(route('home'));
        }

        $now = new Carbon();

        $check = new Bankaccountcheck([
            'user_id' => Auth::user()->id,
            'last_check' => $now
        ]);
        $check->save();

        return redirect(route('home'));
    }

    public function location() {
        return view('location.show');
    }
}
