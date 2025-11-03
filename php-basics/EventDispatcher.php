<?php

declare(strict_types=1);

final class EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventName, callable $listener): void
    {
        $this->listeners[$eventName] ??= [];

        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(object $event, string|null $eventName = null): object
    {
        foreach ($this->getListeners($eventName ?? $event::class) as $listener) {
            $listener($event);
        }

        return $event;
    }

    private function getListeners(string $eventName): array
    {
        return $this->listeners[$eventName] ?? [];
    }
}
