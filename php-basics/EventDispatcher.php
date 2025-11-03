<?php

declare(strict_types=1);

final class EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventName, callable|EventListenerInterface $listener): void
    {
        $this->listeners[$eventName] ??= [];

        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(object $event, string|null $eventName = null): object
    {
        $eventName ??= $event::class;

        $listeners = $this->getListeners($eventName);

        if (count($listeners) === 0) {
            throw EventDispatcherException::noListenersForEvent($eventName);
        }

        foreach ($listeners as $listener) {
            if ($listener instanceof EventListenerInterface) {
                $listener->handle($event);

                continue;
            }

            $listener($event);
        }

        return $event;
    }

    private function getListeners(string $eventName): array
    {
        return $this->listeners[$eventName] ?? [];
    }
}
