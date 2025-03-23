<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ticket System Basic Settings
    |--------------------------------------------------------------------------
    |
    | This file contains the basic settings for the ticket system.
    |
    */

    // Ticket pagination per page
    'per_page' => 10,

    // Ticket statuses
    'statuses' => [
        'open' => 'Open',
        'in_progress' => 'In Progress',
        'resolved' => 'Resolved',
        'closed' => 'Closed',
    ],

    // Ticket priorities
    'priorities' => [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent',
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Authorization
    |--------------------------------------------------------------------------
    |
    | The setting to determine admin authorization. If null, admin authorization will be disabled.
    | If a method name is provided, the method will be called on the user model to check admin authorization.
    |
    */

    // The method name to check admin authorization (null is disabled)
    'admin' => 'isTicketAdmin',
];
