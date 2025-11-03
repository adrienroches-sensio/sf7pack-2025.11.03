<?php

declare(strict_types=1);

class EventDispatcherException extends RuntimeException
{
    public static function noListenersForEvent(string $eventName): self
    {
        return new self(
            "No event listeners found for event '{$eventName}'.",
        );
    }
}
