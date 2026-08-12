<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\ValueObjects;

use Illuminate\Support\Facades\DB;
use RuntimeException;
use Stringable;

final readonly class CaseNumber implements Stringable
{
    private function __construct(public string $value) {}

    /**
     * @throws \Throwable
     */
    public static function generate(): self
    {
        $prefix = 'CP-';
        $nextId = self::nextSequenceValue();
        $paddedId = str_pad((string) $nextId, 6, '0', STR_PAD_LEFT);

        return new self($prefix.$paddedId);
    }

    /**
     * @throws \Throwable
     */
    private static function nextSequenceValue(): int
    {
        return DB::transaction(function (): int {
            $sequence = DB::table('case_number_sequences')->lockForUpdate()->first();

            if (! $sequence) {
                throw new RuntimeException('Case number sequence is not initialized.');
            }

            $nextId = (int) $sequence->next_value;

            DB::table('case_number_sequences')->update(['next_value' => $nextId + 1]);

            return $nextId;
        });
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
