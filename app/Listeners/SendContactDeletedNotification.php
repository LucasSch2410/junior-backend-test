<?php

namespace App\Listeners;

use App\Events\ContactDeleted;
use App\Mail\ContactDeletedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendContactDeletedNotification implements ShouldQueue
{
    public $tries = 3;

    public function handle(ContactDeleted $event): void
    {
        $adminEmail = config('mail.admin_email', config('mail.from.address'));
        
        Mail::to($adminEmail)
            ->send(new ContactDeletedMail($event->contact));
    }

    public function failed(ContactDeleted $event, \Throwable $exception): void
    {
        \Log::error('Failed to send contact deleted notification', [
            'contact_id' => $event->contact->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
