<?php

return [
    'merge_to_navigation' => true,

    'navs' => [
        'sidebar' =>[
            [
                'name' => 'Baselinker client',
                'link' => '/baselinker-client/accounts',
                'icon' => 'speed',
                'key' => 'baselinker-client::menus.baselinker_client',
                'children_top' => [
                    [
                        'name' => 'Accounts',
                        'link' => '/baselinker-client/accounts',
                        'key' => 'baselinker-client::menus.accounts',
                    ],
                ],
                'children' => [
                    [
                        'name' => 'Accounts',
                        'link' => '/baselinker-client/accounts',
                        'key' => 'baselinker-client::menus.accounts',
                    ],
                ],
            ]
        ],
        'adminSidebar' =>[
            [
                'name' => 'Baselinker client',
                'link' => '/admin/baselinker-client/settings',
                'icon' => 'speed',
                'permissions' => 'manage_baselinker_client_settings',
                'key' => 'baselinker-client::menus.baselinker_client',
                'children_top' => [
                    [
                        'name' => 'Settings',
                        'link' => '/admin/baselinker-client/settings',
                        'key' => 'baselinker-client::menus.settings',
                    ],
                ],
                'children' => [
                    [
                        'name' => 'Settings',
                        'link' => '/admin/baselinker-client/settings',
                        'key' => 'baselinker-client::menus.settings',
                    ],
                ],
            ]
        ]
    ]
];
