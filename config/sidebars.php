<?php
return [
    /*
        Admin Sidebar
    */

    'admin_sidebar' => [
        [
            'title' => 'Dashboard',
            'role' => '2',
            'items' => [
                [
                    'title' => 'Dashboard',
                    'route' => 'admin.dashboard',
                    'icon' => 'fas fa-fw fa-tachometer-alt',
                    'role' => '2',
                ],
            ],
        ],

        [
            'title' => 'Users',
            'role' => '1',
            'items' => [
                [
                    'title' => 'Teachers',
                    'route' => 'admin.teachers.index',
                    'icon' => 'fa-fw fas fa-user-tie',
                    'role' => '1',
                ],

                [
                    'title' => 'Students',
                    'route' => 'admin.students.index',
                    'icon' => 'fa-fw fas fa-user-graduate',
                    'role' => '2',
                ],
            ],
        ],

        [
            'title' => 'Course',
            'role' => '3',
            'items' => [
                [
                    'title' => 'Levels',
                    'route' => 'admin.levels.index',
                    'icon' => 'fa-fw fas fa-layer-group',
                    'role' => '2',
                ],
                [
                    'title' => 'Exams',
                    'route' => 'admin.exams.index',
                    'icon' => 'fa-fw fas fa-pencil-alt',
                    'role' => '2',
                ],
            ]

        ],

        [
            'title' => 'Reports',
            'role' => '1',
            'items' => [
                [
                    'title' => 'Reports',
                    'route' => 'admin.reports.index',
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
                    'route' => 'admin.settings.index',
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
