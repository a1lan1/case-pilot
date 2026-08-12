<?php

declare(strict_types=1);

namespace App\Modules\Case\Infrastructure\Persistence\Repositories;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Events\CaseApproved;
use App\Modules\Case\Domain\Events\CaseAssigned;
use App\Modules\Case\Domain\Events\CaseCancelled;
use App\Modules\Case\Domain\Events\CaseClosed;
use App\Modules\Case\Domain\Events\CaseCompleted;
use App\Modules\Case\Domain\Events\CaseCreated;
use App\Modules\Case\Domain\Events\CaseRejected;
use App\Modules\Case\Domain\Events\CaseStarted;
use App\Modules\Case\Domain\Events\CaseSubmitted;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Domain\States\Approved;
use App\Modules\Case\Domain\States\Assigned;
use App\Modules\Case\Domain\States\Cancelled;
use App\Modules\Case\Domain\States\Closed;
use App\Modules\Case\Domain\States\Completed;
use App\Modules\Case\Domain\States\InProgress;
use App\Modules\Case\Domain\States\Rejected;
use App\Modules\Case\Domain\States\Submitted;
use App\Modules\Case\Domain\States\UnderReview;
use App\Modules\Case\Domain\ValueObjects\CaseNumber;
use App\Modules\Case\Infrastructure\Persistence\Models\CaseModel;
use App\Shared\Domain\Events\DomainEvent;
use App\Shared\Domain\Events\DomainEventDispatcher;
use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\Exceptions\OptimisticLockingException;
use App\Shared\Domain\ValueObjects\UuidValueObject;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class EloquentCaseRepository implements CaseRepositoryInterface
{
    /**
     * @var array<class-string, class-string<DomainEvent>|null>
     */
    private const array TRANSITION_EVENTS = [
        Submitted::class => CaseSubmitted::class,
        UnderReview::class => null,
        Approved::class => CaseApproved::class,
        Rejected::class => CaseRejected::class,
        Assigned::class => CaseAssigned::class,
        InProgress::class => CaseStarted::class,
        Completed::class => CaseCompleted::class,
        Closed::class => CaseClosed::class,
        Cancelled::class => CaseCancelled::class,
    ];

    public function __construct(private readonly DomainEventDispatcher $dispatcher) {}

    /**
     * @throws OptimisticLockingException
     */
    public function save(CaseEntity $case): void
    {
        $model = CaseModel::findOrNew($case->id);

        if ($model->exists && $model->version !== $case->version) {
            throw new OptimisticLockingException;
        }

        $isNew = ! $model->exists;

        $model->number = $case->number->value;
        $model->title = $case->title;
        $model->description = $case->description;
        $model->priority = $case->priority;
        $model->type = $case->type;
        $model->customer_id = $case->customerId;
        $model->assignee_id = $case->assigneeId instanceof UuidValueObject ? $case->assigneeId->value : null;

        if ($isNew) {
            $model->version = 1;
        } else {
            $model->version++;
        }

        $model->save();

        $case->id = (int) $model->id;
        $case->version = $model->version;

        if ($isNew) {
            $case->record(new CaseCreated($case->id, $case->number->value));
        }

        $this->dispatcher->dispatch($case->releaseEvents());
    }

    public function find(int $id): ?CaseEntity
    {
        $model = CaseModel::find($id);

        if (! $model) {
            return null;
        }

        return $this->toEntity($model);
    }

    /**
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    public function submit(int $id, int $version): void
    {
        $this->transition($id, $version, Submitted::class, timestampColumn: 'submitted_at');
    }

    /**
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    public function review(int $id, int $version): void
    {
        $this->transition($id, $version, UnderReview::class);
    }

    /**
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    public function approve(int $id, int $version): void
    {
        $this->transition($id, $version, Approved::class, timestampColumn: 'approved_at');
    }

    /**
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    public function reject(int $id, int $version): void
    {
        $this->transition($id, $version, Rejected::class);
    }

    /**
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    public function assign(int $id, int $version, string $assigneeId): void
    {
        $this->transition($id, $version, Assigned::class, timestampColumn: 'assigned_at', assigneeId: $assigneeId);
    }

    /**
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    public function start(int $id, int $version): void
    {
        $this->transition($id, $version, InProgress::class, timestampColumn: 'started_at');
    }

    /**
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    public function complete(int $id, int $version): void
    {
        $this->transition($id, $version, Completed::class, timestampColumn: 'completed_at');
    }

    /**
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    public function close(int $id, int $version): void
    {
        $this->transition($id, $version, Closed::class, timestampColumn: 'closed_at');
    }

    /**
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    public function cancel(int $id, int $version): void
    {
        $this->transition($id, $version, Cancelled::class, timestampColumn: 'cancelled_at');
    }

    /**
     * @param  class-string  $targetState
     *
     * @throws CouldNotPerformTransition
     * @throws OptimisticLockingException
     */
    private function transition(int $id, int $version, string $targetState, ?string $timestampColumn = null, ?string $assigneeId = null): void
    {
        $model = CaseModel::findOrFail($id);

        if ($model->version !== $version) {
            throw new OptimisticLockingException;
        }

        if ($assigneeId !== null) {
            $model->assignee_id = $assigneeId;
        }

        $model->status->transitionTo($targetState);

        if ($timestampColumn !== null) {
            $model->{$timestampColumn} = now();
        }

        $model->version++;
        $model->save();

        $this->dispatchTransitionEvent($model, $targetState, $assigneeId);
    }

    /**
     * @param  class-string  $targetState
     */
    private function dispatchTransitionEvent(CaseModel $model, string $targetState, ?string $assigneeId): void
    {
        $eventClass = self::TRANSITION_EVENTS[$targetState];

        if ($eventClass === null) {
            return;
        }

        $event = $eventClass === CaseAssigned::class
            ? new $eventClass($model->id, $model->number, $assigneeId)
            : new $eventClass($model->id, $model->number);

        $this->dispatcher->dispatch([$event]);
    }

    /**
     * @throws OptimisticLockingException
     * @throws DomainException
     */
    public function delete(int $id, int $version): void
    {
        $model = CaseModel::findOrFail($id);

        if ($model->version !== $version) {
            throw new OptimisticLockingException;
        }

        if ((string) $model->status !== 'draft') {
            throw new DomainException('Only draft cases can be deleted.');
        }

        $model->delete();
    }

    private function toEntity(CaseModel $model): CaseEntity
    {
        return new CaseEntity(
            id: $model->id,
            number: CaseNumber::fromString($model->number),
            title: $model->title,
            description: $model->description,
            status: $model->status->getValue(),
            priority: $model->priority,
            type: $model->type,
            customerId: $model->customer_id,
            assigneeId: $model->assignee_id ? new UuidValueObject($model->assignee_id) : null,
            version: $model->version,
        );
    }
}
