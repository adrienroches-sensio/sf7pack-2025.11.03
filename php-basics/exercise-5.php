<?php

require_once 'StoppableEventInterface.php';
require_once 'EventDispatcher.php';

$dispatcher = new EventDispatcher();
$dispatcher->addListener('event-1', function (object $myEvent): void {
    echo 'Listener - 1 / Event - 1' . PHP_EOL;

    if ($myEvent instanceof StoppableEventInterface) {
        $myEvent->stopPropagation();
    }
}, 10);
$dispatcher->addListener('event-1', function (): void {
    echo 'Listener - 2 / Event - 1'  . PHP_EOL;
}, 0);
$dispatcher->addListener('event-1', function (): void {
    echo 'Listener - 3 / Event - 1'  . PHP_EOL;
}, 50);
$dispatcher->addListener('event-1', function (): void {
    echo 'Listener - 4 / Event - 1'  . PHP_EOL;
}, -50);

$myEvent = new class implements StoppableEventInterface {
    private bool $stop = false;

    public function isPropagationStopped(): bool
    {
        return $this->stop;
    }

    public function stopPropagation(): void
    {
        $this->stop = true;
    }
};

$dispatcher->dispatch($myEvent, 'event-1');
