<?php

declare(strict_types=1);

namespace Anwinged\Reason;

class Reason
{
    /**
     * @var ReasonStatusInterface
     */
    private $status;

    /**
     * @var string[]
     */
    private $messages;

    /**
     * @param ReasonStatusInterface $status
     * @param string[]              $messages
     */
    public function __construct(ReasonStatusInterface $status, array $messages)
    {
        $this->status = $status;
        $this->messages = $messages;
    }

    /**
     * Clones the reason.
     */
    public function __clone()
    {
        $this->status = clone $this->status;
    }

    /**
     * @return ReasonStatusInterface
     */
    public function getStatus(): ReasonStatusInterface
    {
        return clone $this->status;
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * Checks is status successful.
     *
     * Shortcut for $this->getStatus()->isSuccess()
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->status->isSuccess();
    }

    /**
     * Checks is status failed.
     *
     * Shortcut for $this->getStatus()->isFail()
     *
     * @return bool
     */
    public function isFail(): bool
    {
        return $this->status->isFail();
    }

    /**
     * Appends reason to current and returns new reason.
     *
     * Reason with highest weighs wins.
     *
     * If other reason has highest weight, then it will be returned without changes.
     * If weights are equal, then messages will be merged. Otherwise,
     * returns current reason.
     *
     * Don't change original objects.
     *
     * @param Reason $other
     *
     * @return self
     */
    public function andX(Reason $other): self
    {
        if ($other->status->getWeight() > $this->status->getWeight()) {
            return clone $other;
        }

        if ($other->status->getWeight() === $this->status->getWeight()) {
            return $this->withMessages($other->getMessages());
        }

        return clone $this;
    }

    /**
     * Join reason to current and return new reason.
     *
     * Reason with lowest weight wins.
     *
     * If other reason has lowest weight, then it will be returned without changes.
     * If weights are equal, then messages will be merged. Otherwise,
     * returns current reason.
     *
     * @param Reason $other
     *
     * @return self
     */
    public function orX(Reason $other): self
    {
        if ($other->status->getWeight() < $this->status->getWeight()) {
            return clone $other;
        }

        if ($other->status->getWeight() === $this->status->getWeight()) {
            return $this->withMessages($other->getMessages());
        }

        return clone $this;
    }

    /**
     * @param string[] $messages
     *
     * @return self
     */
    private function withMessages(array $messages): self
    {
        $reason = clone $this;
        $reason->messages = array_merge($reason->messages, $messages);

        return $reason;
    }
}
