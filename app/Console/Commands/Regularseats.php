<?php

namespace App\Console\Commands;

use App\Regularseat;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Mail;

class Regularseats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gnb:regularseats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to all members with regular seats.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = new Collection();
        $lanparty = \App\Lanparty::getNextLan();
        $regularseats = Regularseat::all();

        foreach ($regularseats as $regularseat) {
            if (!$users->contains($regularseat->user)) {
                $users->push($regularseat->user);
            }
        }

        foreach ($users as $user) {
            Mail::send('email.regularseats', [
                'user' => $user,
                'lanparty' => $lanparty,
                'regularseats' => $user->regularseats
            ], function($m) use ($user, $lanparty) {
                $m->from('info@gunsnbits.de', 'Guns`n Bits e.V.');
                $m->to($user->email, $user->username);
                $m->subject('Die Anmeldung zur ' . $lanparty->title . ' ist geöffnet!');
            });

            $this->info($user->email);
        }

        $this->info('Emails send out successfully.');
    }
}
