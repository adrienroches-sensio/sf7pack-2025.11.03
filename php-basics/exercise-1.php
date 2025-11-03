<?php

declare(strict_types=1);

require_once 'EventDispatcher.php';

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener('event-1', function() {
    echo 'event-1 / listener-1' . PHP_EOL;
});
$eventDispatcher->addListener('event-1', function() {
    echo 'event-1 / listener-2' . PHP_EOL;
});
$eventDispatcher->addListener('event-2', function() {
    echo 'event-2 / listener-1' . PHP_EOL;
});
$eventDispatcher->addListener('event-1', function() {
    echo 'event-1 / listener-3' . PHP_EOL;
});

$event = new stdClass();

$eventDispatcher->dispatch($event, 'event-1');
