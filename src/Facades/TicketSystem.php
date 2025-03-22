<?php

namespace Digitalcake\TicketSystem\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Digitalcake\TicketSystem\TicketSystem
 */
class TicketSystem extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Digitalcake\TicketSystem\TicketSystem::class;
    }
}
