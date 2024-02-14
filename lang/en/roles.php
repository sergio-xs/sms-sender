<?php

return [
    'datatable' => [
        'title' => 'Roles',
        'add_btn' => 'Add',
        'columns' => [
            'number' => '#',
            'name' => 'Name',
            'guard_name' => 'Guard Name',
            'edit_btn' => 'Edit'
        ],
        'modal' => [
            'title_add' => 'Add',
            'title_edit' => 'Edit',
            'name' => 'Name',
            'guard_name' => [
                'title' => 'Guard Name',
                'option' => 'Guards'
            ],
            'permissions' => 'Permissions',
            'button_add' => 'Add',
            'button_edit' => 'Edit',
            'cancel_btn' => 'Cancel'
        ]
    ],
    'store_message' => 'Role added successfully',
    'update_message' => 'Role updated successfully',
];
