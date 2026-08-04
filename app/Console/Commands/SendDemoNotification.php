<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Data\NotificationData;
use App\Enums\NotificationTypeEnum;
use App\Interfaces\NotificationServiceInterface;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

#[Description('Send a demo notification to all users')]
#[Signature('app:send-demo-notification')]
final class SendDemoNotification extends Command
{
    public function handle(NotificationServiceInterface $notificationService): int
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        $data = new NotificationData(
            title: trim((string) $author),
            message: trim((string) $message),
            type: NotificationTypeEnum::INFO,
        );

        User::query()->each(fn (User $user) => $notificationService->sendToUser($user, $data));

        $this->info('Demo notifications sent successfully.');

        return self::SUCCESS;
    }
}
