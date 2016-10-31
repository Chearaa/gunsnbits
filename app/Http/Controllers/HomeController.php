<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Fbpost;
use App\Lanparty;

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
        }

        $posts = Fbpost::all()
            ->sortByDesc('created_time');

        return view('welcome', compact(
            'posts',
            'lanparty',
            'user',
            'usercanreserveseats',
            'reservedseats',
            'progress'
        ));
    }
}
