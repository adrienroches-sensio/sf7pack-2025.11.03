<?php

declare(strict_types=1);

require_once 'EventListenerInterface.php';
require_once 'EventDispatcher.php';

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener('event-1', function() {
    echo 'event-1 / listener-1' . PHP_EOL;
}, -1000);
$eventDispatcher->addListener('event-1', function() {
    echo 'event-1 / listener-2' . PHP_EOL;
}, +1000);
$eventDispatcher->addListener('event-1', function() {
    echo 'event-1 / listener-3' . PHP_EOL;
});
$eventDispatcher->addListener('event-1', new class implements EventListenerInterface {
    public function handle(object $event): void
    {
        echo 'event-1 / listener-4' . PHP_EOL;
    }
}, +50);

$event = new stdClass();

$eventDispatcher->dispatch($event, 'event-1');
