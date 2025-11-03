<?php

declare(strict_types=1);

interface StoppableEventInterface
{
    public function isPropagationStopped(): bool;

    public function stopPropagation(): void;
}
