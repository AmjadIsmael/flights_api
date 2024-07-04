<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\FlightReminderEmail;
use App\Models\Passenger;
use App\Models\Flight;
use Carbon\Carbon;

class SendFlightReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flights:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to passengers 24 hours before flight departure';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $flights = Flight::where('departure_time', '<=', Carbon::now()->addDay())
            ->where('departure_time', '>', Carbon::now())
            ->get();

        foreach ($flights as $flight) {
            $passengers = $flight->passengers;

            foreach ($passengers as $passenger) {
                Mail::to($passenger->email)
                    ->send(new FlightReminderEmail($flight, $passenger));
            }

            $this->info("Reminder emails sent for flight {$flight->number}");
        }

        return 0;
    }
}
