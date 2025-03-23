<?php

return [
    'title' => 'Support Tickets',
    'admin_badge' => 'Admin',
    'new_ticket' => 'New Ticket',
    'status' => [
        'all' => 'Status: All',
        'open' => 'Open',
        'in_progress' => 'In Progress',
        'resolved' => 'Resolved',
        'closed' => 'Closed',
    ],
    'priority' => [
        'all' => 'Priority: All',
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent',
        'low_full' => 'Low Priority',
        'medium_full' => 'Medium Priority',
        'high_full' => 'High Priority',
        'urgent_full' => 'Urgent Priority',
    ],
    'search' => 'Search...',
    'reset' => 'Reset',
    'columns' => [
        'title' => 'Title',
        'creator' => 'Creator',
        'status' => 'Status',
        'priority' => 'Priority',
        'created_at' => 'Created',
        'actions' => 'Actions',
    ],
    'no_tickets' => 'No tickets found',
    'modal' => [
        'create' => [
            'title' => 'Create New Ticket',
            'form' => [
                'title' => 'Title',
                'description' => 'Description',
                'priority' => 'Priority',
                'placeholder' => [
                    'title' => 'Enter ticket title...',
                    'description' => 'Describe your issue in detail...',
                ],
                'validation' => [
                    'title_required' => 'Title field is required.',
                    'description_required' => 'Description field is required.',
                    'priority_required' => 'Priority field is required.',
                ],
            ],
            'buttons' => [
                'cancel' => 'Cancel',
                'create' => 'Create',
            ],
        ],
        'edit' => [
            'title' => 'Edit Ticket',
            'buttons' => [
                'cancel' => 'Cancel',
                'update' => 'Update',
            ],
        ],
        'response' => [
            'title' => 'Respond to Ticket',
            'responses_title' => 'Responses',
            'form' => [
                'placeholder' => 'Write your response here...',
                'validation' => [
                    'content_required' => 'This field is required.',
                ],
            ],
            'buttons' => [
                'cancel' => 'Cancel',
                'respond' => 'Respond',
            ],
        ],
    ],
    'actions' => [
        'reopen' => 'Reopen',
        'mark_in_progress' => 'Mark In Progress',
        'mark_resolved' => 'Mark Resolved',
        'close' => 'Close',
        'delete' => 'Delete Ticket',
    ],
    'messages' => [
        'created' => 'Ticket created successfully.',
        'updated' => 'Ticket updated successfully.',
        'responded' => 'Your response has been saved.',
        'status_changed' => 'Ticket status updated.',
        'deleted' => 'Ticket deleted successfully.',
        'no_permission' => 'You do not have permission to perform this action.',
        'no_edit_permission' => 'You do not have permission to edit this ticket.',
        'no_status_permission' => 'You do not have permission to change the status of this ticket.',
        'no_delete_permission' => 'You do not have permission to delete this ticket.',
        'invalid_ticket' => 'Invalid ticket ID.',
    ],
    'unknown' => 'Unknown',
    'confirm_delete' => 'Are you sure you want to delete this ticket? This action cannot be undone.',
]; 