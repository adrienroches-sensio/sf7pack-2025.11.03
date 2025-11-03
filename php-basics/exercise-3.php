<?php

declare(strict_types=1);

require_once 'EventDispatcherException.php';
require_once 'EventListenerInterface.php';
require_once 'EventDispatcher.php';

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener('event-1', function() {
    echo 'event-1 / listener-1' . PHP_EOL;
});
$eventDispatcher->addListener('event-1', function() {
    echo 'event-1 / listener-2' . PHP_EOL;
});

$event = new stdClass();

$eventDispatcher->dispatch($event, 'event-2');
