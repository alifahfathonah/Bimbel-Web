<?php
return [
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
                    'url' => 'user/profile',
                    'icon' => 'fas fa-fw fa-user'
                ],
                [
                    'title' => 'Change Password',
                    'url' => 'user/changepassword',
                    'icon' => 'fas fa-fw fa-key'
                ],
                [
                    'title' => 'Logout',
                    'url' => 'user/logout',
                    'icon' => 'fas fa-fw fa-sign-out-alt'
                ],
            ]

        ]
    ]
];
