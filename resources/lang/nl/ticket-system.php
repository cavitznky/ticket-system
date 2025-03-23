<?php

return [
    'title' => 'Ondersteuning Tickets',
    'admin_badge' => 'Admin',
    'new_ticket' => 'Nieuw Ticket',
    'status' => [
        'all' => 'Status: Alle',
        'open' => 'Open',
        'in_progress' => 'In Behandeling',
        'resolved' => 'Opgelost',
        'closed' => 'Gesloten',
    ],
    'priority' => [
        'all' => 'Prioriteit: Alle',
        'low' => 'Laag',
        'medium' => 'Gemiddeld',
        'high' => 'Hoog',
        'urgent' => 'Urgent',
        'low_full' => 'Lage Prioriteit',
        'medium_full' => 'Gemiddelde Prioriteit',
        'high_full' => 'Hoge Prioriteit',
        'urgent_full' => 'Urgente Prioriteit',
    ],
    'search' => 'Zoeken...',
    'reset' => 'Resetten',
    'columns' => [
        'title' => 'Titel',
        'creator' => 'Aangemaakt door',
        'status' => 'Status',
        'priority' => 'Prioriteit',
        'created_at' => 'Aangemaakt op',
        'actions' => 'Acties',
    ],
    'no_tickets' => 'Geen tickets gevonden',
    'modal' => [
        'create' => [
            'title' => 'Nieuw Ticket Aanmaken',
            'form' => [
                'title' => 'Titel',
                'description' => 'Beschrijving',
                'priority' => 'Prioriteit',
                'placeholder' => [
                    'title' => 'Voer ticket titel in...',
                    'description' => 'Beschrijf uw probleem in detail...',
                ],
                'validation' => [
                    'title_required' => 'Titel veld is verplicht.',
                    'description_required' => 'Beschrijving veld is verplicht.',
                    'priority_required' => 'Prioriteit veld is verplicht.',
                ],
            ],
            'buttons' => [
                'cancel' => 'Annuleren',
                'create' => 'Aanmaken',
            ],
        ],
        'edit' => [
            'title' => 'Ticket Bewerken',
            'buttons' => [
                'cancel' => 'Annuleren',
                'update' => 'Bijwerken',
            ],
        ],
        'response' => [
            'title' => 'Reageren op Ticket',
            'responses_title' => 'Reacties',
            'form' => [
                'placeholder' => 'Schrijf uw reactie hier...',
                'validation' => [
                    'content_required' => 'Dit veld is verplicht.',
                ],
            ],
            'buttons' => [
                'cancel' => 'Annuleren',
                'respond' => 'Reageren',
            ],
        ],
    ],
    'actions' => [
        'reopen' => 'Heropenen',
        'mark_in_progress' => 'Markeren als In Behandeling',
        'mark_resolved' => 'Markeren als Opgelost',
        'close' => 'Sluiten',
        'delete' => 'Ticket Verwijderen',
    ],
    'messages' => [
        'created' => 'Ticket succesvol aangemaakt.',
        'updated' => 'Ticket succesvol bijgewerkt.',
        'responded' => 'Uw reactie is opgeslagen.',
        'status_changed' => 'Ticket status bijgewerkt.',
        'deleted' => 'Ticket succesvol verwijderd.',
        'no_permission' => 'U heeft geen toestemming om deze actie uit te voeren.',
        'no_edit_permission' => 'U heeft geen toestemming om dit ticket te bewerken.',
        'no_status_permission' => 'U heeft geen toestemming om de status van dit ticket te wijzigen.',
        'no_delete_permission' => 'U heeft geen toestemming om dit ticket te verwijderen.',
        'invalid_ticket' => 'Ongeldige ticket ID.',
    ],
    'unknown' => 'Onbekend',
    'confirm_delete' => 'Weet u zeker dat u dit ticket wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.',
];
