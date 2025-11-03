<?php

declare(strict_types=1);

final class EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventName, callable|EventListenerInterface $listener, int $priority = 0): void
    {
        $this->listeners[$eventName] ??= [];

        if ($listener instanceof EventListenerInterface) {
            $listener = $listener->handle(...);
        }

        $this->listeners[$eventName][] = [$listener, $priority];
    }

    public function dispatch(object $event, string|null $eventName = null): object
    {
        $eventName ??= $event::class;

        $listeners = $this->getListeners($eventName);

        if (count($listeners) === 0) {
            throw EventDispatcherException::noListenersForEvent($eventName);
        }

        foreach ($listeners as $listener) {
            $listener($event);
        }

        return $event;
    }

    private function getListeners(string $eventName): array
    {
        $listeners = $this->listeners[$eventName] ?? [];

        usort($listeners, function (array $listenerConfig1, array $listenerConfig2): int {
            [, $priority1] = $listenerConfig1;
            [, $priority2] = $listenerConfig2;

            return $priority2 <=> $priority1;
        });

        return array_column($listeners, 0, null);
    }
}
