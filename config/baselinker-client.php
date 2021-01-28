<?php
return [
    // this resources has been auto load to layout
    'dist' => [
        'js/main.js',
        'js/main.legacy.js',
        'css/main.css',
    ],
    'routes' => [
        // all routes is active
        'active' => true,
        // Administrator section.
        'admin' => [
            'installation' => [
                'active' => true,
                'prefix' => '/installation/baselinker-client',
                'name_prefix' => 'baselinker_client.admin.installation.',
                // this routes has beed except for installation module
                'expect' => [
                    'module-assets.assets',
                    'baselinker-client.admin.installation.index',
                    'baselinker-client.admin.installation.store',
                ]
            ],
            'setting' => [
                'active' => true,
                'prefix' => '/admin/baselinker-client/settings',
                'name_prefix' => 'baselinker_client.admin.setting.',
                'middleware' => [
                    'web',
                    'auth',
                    'can:manage_baselinker_client_settings'
                ]
            ],
        ],
        // User section
        'user' => [
            'account' => [
                'active' => true,
                'prefix' => '/baselinker-client/accounts',
                'name_prefix' => 'baselinker_client.user.account.',
                'middleware' => [
                    'web',
                    'auth',
                    'verified'
                ]
            ],
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Use permissions in application.
    |--------------------------------------------------------------------------
    |
    | This permission has been insert to database with migrations
    | of module permission.
    |
    */
    'permissions' => [
        'install_packages',
        'manage_baselinker_client_settings',
    ],
    /*
    |--------------------------------------------------------------------------
    | Can merge permissions to module permission
    |--------------------------------------------------------------------------
    */
    'merge_permissions' => true,
    'installation' => [
        'auto_redirect' => [
            // user with this permission has been automation redirect to
            // installation package
            'permission' => 'install_packages'
        ]
    ],
    'database' => [
        'tables' => [
            'users' => 'users',
            'baselinker_client_accounts' => 'baselinker_client_accounts',
            'baselinker_client_settings' => 'baselinker_client_settings',
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    |
    | The amount of time that information is kept in the cache of baselinker-client
    | storages.
    |
    */
    'cache_baselinker_client_storages_ttl' => 100,
];
