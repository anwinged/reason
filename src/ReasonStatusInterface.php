<?php

declare(strict_types=1);

namespace Anwinged\Reason;

interface ReasonStatusInterface
{
    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @return bool
     */
    public function isFail(): bool;

    /**
     * @return int
     */
    public function getWeight(): int;
}
