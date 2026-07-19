<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\NotificationData;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationServiceInterface;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Database\Eloquent\Collection;

readonly class NotificationService implements NotificationServiceInterface
{
    public function __construct(private NotificationRepositoryInterface $repository) {}

    public function sendToUser(User $user, NotificationData $data): void
    {
        $user->notify(new SystemNotification($data));
    }

    public function getNotificationsForUser(User $user, int $limit = 20): Collection
    {
        return $this->repository->getForUser($user, $limit);
    }

    public function getUnreadCount(User $user): int
    {
        return $this->repository->getUnreadCount($user);
    }

    public function markAsRead(User $user, string $id): bool
    {
        return $this->repository->markAsRead($user, $id);
    }

    public function markAllAsRead(User $user): void
    {
        $this->repository->markAllAsRead($user);
    }

    public function delete(User $user, string $id): bool
    {
        return $this->repository->delete($user, $id);
    }
}
