<?php

return [
    'datatable' => [
        'title' => 'Permissions',
        'add_btn' => 'Add',
        'columns' => [
            'number' => '#',
            'name' => 'Name',
            'guard_name' => 'Guard Name',
            'edit_btn' => 'Edit',
            'delete_btn' => 'Delete'
        ],
        'modal' => [
            'title_add' => 'Add',
            'title_edit' => 'Edit',
            'name' => 'Name',
            'guard_name' => [
                'title' => 'Guard Name',
                'option' => 'Guards'
            ],
            'button_add' => 'Add',
            'button_edit' => 'Edit',
            'cancel_btn' => 'Cancel'
        ]
    ],
    'store_message' => 'Permission added successfully',
    'update_message' => 'Permission updated successfully',
    'delete_message' => 'Permission deleted successfully',
];
