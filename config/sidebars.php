<?php
return [

    /** Admin Sidebar */
    'admin_sidebar' => [

        /** Dashboard */
        [
            'items' => [
                [
                    'title' => 'Dashboard',
                    'route' => 'admin.dashboard',
                    'icon' => 'fas fa-fw fa-tachometer-alt',
                    'uri' => 'dashboard',
                    'role' => '2',
                ],
            ],
        ],

        /** Users */
        [
            'title' => 'Users',
            'items' => [
                [
                    'title' => 'Teachers',
                    'icon' => 'fa-fw fas fa-user-tie',
                    'uri' => 'teachers',
                    'role' => '1',
                    'items' => [
                        [
                            'title' => 'General',
                            'items' => [
                                [
                                    'title' => 'Teacher List',
                                    'route' => 'admin.teachers.index',
                                    'role' => '1',
                                ],
                                [
                                    'title' => 'New Teacher',
                                    'route' => 'admin.teachers.create',
                                    'role' => '1',
                                ],
                            ]
                        ]
                    ],
                ],
                [
                    'title' => 'Students',
                    'icon' => 'fa-fw fas fa-user-graduate',
                    'uri' => 'students',
                    'role' => '1',
                    'items' => [
                        [
                            'title' => 'General',
                            'items' => [
                                [
                                    'title' => 'Student List',
                                    'route' => 'admin.students.index',
                                    'role' => '1',
                                ],
                                [
                                    'title' => 'New Student',
                                    'route' => 'admin.students.create',
                                    'role' => '1',
                                ],
                            ]
                        ]
                    ],
                ],
            ],
        ],

        /** Course */
        [
            'title' => 'Course',
            'role' => '3',
            'items' => [
                [
                    'title' => 'Levels',
                    'uri' => 'levels',
                    'route' => 'admin.levels.index',
                    'icon' => 'fa-fw fas fa-layer-group',
                    'role' => '2',
                ],
                [
                    'title' => 'Exams',
                    'uri' => 'exams',
                    'route' => 'admin.exams.index',
                    'icon' => 'fa-fw fas fa-pencil-alt',
                    'role' => '2',
                ],
            ]

        ],

        /** Reports */
        [
            'title' => 'Reports',
            'role' => '1',
            'items' => [
                [
                    'title' => 'Reports',
                    'uri' => 'reports',
                    'route' => 'admin.reports.index',
                    'icon' => 'fa-fw fas fa-tasks',
                    'role' => '1',
                ],
            ],
        ],

        /** Settings */
        [
            'title' => 'Settings',
            'role' => '1',
            'items' => [
                [
                    'title' => 'Settings',
                    'uri' => 'settings',
                    'route' => 'admin.settings.index',
                    'icon' => 'fa-fw fas fa-cog',
                    'role' => '1',
                ],
            ],
        ],
    ],



    /** Students Sidebar */
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
