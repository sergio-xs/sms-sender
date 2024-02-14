<?php

return [
    'datatable' => [
        'title' => 'Users',
        'add_btn' => 'Add',
        'columns' => [
            'number' => '#',
            'name' => 'Name',
            'email' => 'Email',
            'role' => 'Role',
            'edit_btn' => 'Edit',
            'gsm_box_btn' => 'Gsm Box',
            'delete_btn' => 'Delete'
        ],
        'modal' => [
            'title_add' => 'Add',
            'title_edit' => 'Edit',
            'name' => 'Name',
            'email' => 'Email',
            'role' => [
                'title' => 'Role',
                'option' => 'Roles'
            ],
            'permissions' => 'Permissions',
            'button_add' => 'Add',
            'button_edit' => 'Edit',
            'cancel_btn' => 'Cancel'
        ],
        'gsm_box_modal' => [
            'title' => 'GSM BOX',
            'providers' => 'Gsm Box providers',
            'ports' => 'Ports',
            'button_save' => 'Save',
            'button_cancel' => 'Cancel',
        ]
    ],
    'store_message' => 'User added successfully!',
    'update_message' => 'User updated successfully!',
    'delete_message' => 'User deleted successfully!',
    'gsm_message' => 'Gsm Box permission given successfully!',
];
