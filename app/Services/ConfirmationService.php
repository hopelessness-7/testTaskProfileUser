<?php

namespace App\Services;

use App\Notifications\Confirmation\EmailNotification;
use App\Notifications\Confirmation\SMSNotification;
use App\Notifications\Confirmation\TelegramNotification;
use App\Repositories\Eloquent\ConfirmationRepository;
use Carbon\Carbon;

class ConfirmationService
{
    protected ConfirmationRepository $confirmationRepository;

    public function __construct(ConfirmationRepository $confirmationRepository)
    {
        $this->confirmationRepository = $confirmationRepository;
    }

    public  function sendConfirmationCode($user, $type): void
    {
        $code = random_int(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);

        $this->confirmationRepository->create([
            'user_id' => $user->id,
            'type' => $type,
            'code' => $code,
            'expires_at' => $expiresAt,
        ]);

        switch ($type) {
            case 'email':
                $this->sendEmail($user, $code);
                break;
            case 'sms':
                $this->sendSms($user, $code);
                break;
            case 'telegram':
                $this->sendTelegram($user, $code);
                break;
        }
    }

    public function checkConfirmationCode($user, $code): void
    {
        $confirm = $this->confirmationRepository->where('code', $code)->first();

        if (!$confirm) {
            throw new \Exception('code not found', 404);
        }

        $expiresAt = Carbon::parse($confirm->expires_at);
        $now = Carbon::now();

        if ($now->greaterThan($expiresAt)) {
            throw new \Exception('Time has expired', 500);
        }

        $this->confirmationRepository->delete($confirm->id);
    }

    private function sendEmail($user, int $code): void
    {
        $user->notify(new EmailNotification($code));
    }

    private function sendSms($user, int $code): void
    {
        $user->notify(new SMSNotification($code));
    }

    private function sendTelegram($user, int $code): void
    {
        $user->notify(new TelegramNotification($code));
    }
}
