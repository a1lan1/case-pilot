<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Repositories;

use App\Modules\Case\Domain\Entities\CaseEntity;

interface CaseRepositoryInterface
{
    public function save(CaseEntity $case): void;

    public function find(int $id): ?CaseEntity;

    public function delete(int $id, int $version): void;

    public function submit(int $id, int $version): void;

    public function review(int $id, int $version): void;

    public function approve(int $id, int $version): void;

    public function reject(int $id, int $version): void;

    public function assign(int $id, int $version, string $assigneeId): void;

    public function start(int $id, int $version): void;

    public function complete(int $id, int $version): void;

    public function close(int $id, int $version): void;

    public function cancel(int $id, int $version): void;
}
