<?php

return [
    'title' => 'Tickets de Support',
    'admin_badge' => 'Admin',
    'new_ticket' => 'Nouveau Ticket',
    'status' => [
        'all' => 'Statut: Tous',
        'open' => 'Ouvert',
        'in_progress' => 'En Cours',
        'resolved' => 'Résolu',
        'closed' => 'Fermé',
    ],
    'priority' => [
        'all' => 'Priorité: Tous',
        'low' => 'Basse',
        'medium' => 'Moyenne',
        'high' => 'Haute',
        'urgent' => 'Urgente',
        'low_full' => 'Priorité Basse',
        'medium_full' => 'Priorité Moyenne',
        'high_full' => 'Priorité Haute',
        'urgent_full' => 'Priorité Urgente',
    ],
    'search' => 'Rechercher...',
    'reset' => 'Réinitialiser',
    'columns' => [
        'title' => 'Titre',
        'creator' => 'Créateur',
        'status' => 'Statut',
        'priority' => 'Priorité',
        'created_at' => 'Créé',
        'actions' => 'Actions',
    ],
    'no_tickets' => 'Aucun ticket trouvé',
    'modal' => [
        'create' => [
            'title' => 'Créer un Nouveau Ticket',
            'form' => [
                'title' => 'Titre',
                'description' => 'Description',
                'priority' => 'Priorité',
                'placeholder' => [
                    'title' => 'Entrez le titre du ticket...',
                    'description' => 'Décrivez votre problème en détail...',
                ],
                'validation' => [
                    'title_required' => 'Le champ de titre est requis.',
                    'description_required' => 'Le champ de description est requis.',
                    'priority_required' => 'Le champ de priorité est requis.',
                ],
            ],
            'buttons' => [
                'cancel' => 'Annuler',
                'create' => 'Créer',
            ],
        ],
        'edit' => [
            'title' => 'Modifier le Ticket',
            'buttons' => [
                'cancel' => 'Annuler',
                'update' => 'Mettre à jour',
            ],
        ],
        'response' => [
            'title' => 'Répondre au Ticket',
            'responses_title' => 'Réponses',
            'form' => [
                'placeholder' => 'Écrivez votre réponse ici...',
                'validation' => [
                    'content_required' => 'Ce champ est requis.',
                ],
            ],
            'buttons' => [
                'cancel' => 'Annuler',
                'respond' => 'Répondre',
            ],
        ],
    ],
    'actions' => [
        'reopen' => 'Rouvrir',
        'mark_in_progress' => 'Marquer En Cours',
        'mark_resolved' => 'Marquer Résolu',
        'close' => 'Fermer',
        'delete' => 'Supprimer le Ticket',
    ],
    'messages' => [
        'created' => 'Ticket créé avec succès.',
        'updated' => 'Ticket mis à jour avec succès.',
        'responded' => 'Votre réponse a été enregistrée.',
        'status_changed' => 'Statut du ticket mis à jour.',
        'deleted' => 'Ticket supprimé avec succès.',
        'no_permission' => 'Vous n\'avez pas l\'autorisation d\'effectuer cette action.',
        'no_edit_permission' => 'Vous n\'avez pas l\'autorisation de modifier ce ticket.',
        'no_status_permission' => 'Vous n\'avez pas l\'autorisation de changer le statut de ce ticket.',
        'no_delete_permission' => 'Vous n\'avez pas l\'autorisation de supprimer ce ticket.',
        'invalid_ticket' => 'ID de ticket invalide.',
    ],
    'unknown' => 'Inconnu',
    'confirm_delete' => 'Êtes-vous sûr de vouloir supprimer ce ticket ? Cette action ne peut pas être annulée.',
]; 