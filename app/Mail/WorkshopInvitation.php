<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WorkshopInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Registration $registration)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'دعوة ورشة المكياج — INGLOT Sally Qadry',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.workshop-invitation',
            with: [
                'workshop' => config('workshop'),
                'base' => rtrim((string) config('app.url'), '/'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
