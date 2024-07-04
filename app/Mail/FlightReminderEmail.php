<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Flight;
use App\Models\Passenger;

class FlightReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $flight;
    public $passenger;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Flight $flight, Passenger $passenger)
    {
        $this->flight = $flight;
        $this->passenger = $passenger;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Reminder: Flight {$this->flight->number} Departure")
            ->view('emails.flight-reminder');
    }
}
