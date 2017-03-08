<?php

declare(strict_types=1);

namespace Anwinged\Reason\Status;

use Anwinged\Reason\ReasonStatusInterface;

class BooleanStatus implements ReasonStatusInterface
{
    /**
     * @var bool
     */
    private $value;

    /**
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isFail(): bool
    {
        return !$this->value;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->value ? 0 : 1;
    }
}
