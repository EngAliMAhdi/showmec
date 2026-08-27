<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'mail:test {email?}';

    protected $description = 'Send a test email to verify SMTP configuration';

    public function handle(): int
    {
        $email = $this->argument('email') ?? config('mail.from.address');

        try {
            Mail::raw('هذا إيميل تجريبي للتأكد من إعدادات SMTP.', function ($message) use ($email) {
                $message->to($email)->subject('Test — ShowMe');
            });

            $this->info("Test email sent to {$email}");

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
