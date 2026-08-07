<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\States;

use Override;
use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class CaseState extends State
{
    /**
     * @throws InvalidConfig
     */
    #[Override]
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class)
            ->registerState([
                Draft::class,
                Submitted::class,
                UnderReview::class,
                Approved::class,
                Rejected::class,
                Assigned::class,
                InProgress::class,
                Completed::class,
                Closed::class,
                Cancelled::class,
            ])
            ->allowTransition(Draft::class, Submitted::class)
            ->allowTransition(Draft::class, Cancelled::class)
            ->allowTransition(Submitted::class, UnderReview::class)
            ->allowTransition(Submitted::class, Cancelled::class)
            ->allowTransition(UnderReview::class, Approved::class)
            ->allowTransition(UnderReview::class, Rejected::class)
            ->allowTransition(Approved::class, Assigned::class)
            ->allowTransition(Approved::class, Cancelled::class)
            ->allowTransition(Assigned::class, InProgress::class)
            ->allowTransition(Assigned::class, Cancelled::class)
            ->allowTransition(InProgress::class, Completed::class)
            ->allowTransition(Completed::class, Closed::class);
    }
}
