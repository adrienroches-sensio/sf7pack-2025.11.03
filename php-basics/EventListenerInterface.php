<?php

declare(strict_types=1);

interface EventListenerInterface
{
    public function handle(object $event): void;
}
