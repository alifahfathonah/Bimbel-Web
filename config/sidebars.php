<?php
return [
    /*
        Students Sidebar
    */

    'admin_sidebar' => [
        [
            'title' => 'Dashboard',
            'role' => '2',
            'items' => [
                [
                    'title' => 'Dashboard',
                    'url' => 'tryout/dashboard',
                    'icon' => 'fas fa-fw fa-tachometer-alt',
                    'role' => '2',
                ],
            ],
        ],

        [
            'title' => 'Account',
            'role' => '3',
            'items' => [
                [
                    'title' => 'Profile',
                    'url' => 'admin/profile',
                    'icon' => 'fa-fw far fa-address-card',
                    'role' => '2',
                ],
            ]

        ],

        [
            'title' => 'Users',
            'role' => '1',
            'items' => [
                [
                    'title' => 'Teachers',
                    'url' => 'admin/teachers',
                    'icon' => 'fa-fw fas fa-user-tie',
                    'role' => '1',
                ],

                [
                    'title' => 'Students',
                    'url' => 'admin/students',
                    'icon' => 'fa-fw fas fa-user-graduate',
                    'role' => '2',
                ],
            ],
        ],

        [
            'title' => 'Reports',
            'role' => '1',
            'items' => [
                [
                    'title' => 'Reports',
                    'url' => 'admin/reports',
                    'icon' => 'fa-fw fas fa-tasks',
                    'role' => '1',
                ],
            ],
        ],

        [
            'title' => 'Settings',
            'role' => '1',
            'items' => [
                [
                    'title' => 'Settings',
                    'url' => 'admin/settings',
                    'icon' => 'fa-fw fas fa-cog',
                    'role' => '1',
                ],
            ],
        ],
    ],



    /*
        Students Sidebar
    */

    'student_sidebar' => [
        [
            'title' => 'Dashboard',
            'items' => [
                [
                    'title' => 'Dashboard',
                    'url' => 'tryout/dashboard',
                    'icon' => 'fas fa-fw fa-tachometer-alt',
                ],
            ],
        ],
        [
            'title' => 'Course',
            'items' => [
                [
                    'title' => 'Course',
                    'url' => 'tryout/course',
                    'icon' => 'fab fa-fw fa-leanpub',
                ],
            ],
        ],
        [
            'title' => 'Account',
            'items'=> [
                [
                    'title' => 'Profile',
                    'url' => 'tryout/profile',
                    'icon' => 'fas fa-fw fa-user'
                ],
                [
                    'title' => 'Change Password',
                    'url' => 'tryout/changepassword',
                    'icon' => 'fas fa-fw fa-key'
                ],
                [
                    'title' => 'Logout',
                    'url' => 'tryout/logout',
                    'icon' => 'fas fa-fw fa-sign-out-alt'
                ],
            ]

        ]
    ]
];
