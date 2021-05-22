<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'master' => [
        'title' => 'Masters',

        'actions' => [
            'index' => 'Masters',
            'create' => 'New Master',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'userid' => 'Userid',
            'title' => 'Title',
            'descr' => 'Descr',
            'status' => 'Status',
            'score' => 'Score',
            
        ],
    ],

    'offer' => [
        'title' => 'Offers',

        'actions' => [
            'index' => 'Offers',
            'create' => 'New Offer',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'descr' => 'Descr',
            'price' => 'Price',
            'client' => 'Client',
            'master' => 'Master',
            'status' => 'Status',
            'location' => 'Location',
            'accepted' => 'Accepted',
            'finished' => 'Finished',
            
        ],
    ],

    'client' => [
        'title' => 'Clients',

        'actions' => [
            'index' => 'Clients',
            'create' => 'New Client',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'userid' => 'Userid',
            'title' => 'Title',
            'status' => 'Status',
            'score' => 'Score',
            
        ],
    ],

    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'usertype' => 'Usertype',
            'name' => 'Name',
            'email' => 'Email',
            'email_verified_at' => 'Email verified at',
            'password' => 'Password',
            'two_factor_secret' => 'Two factor secret',
            'two_factor_recovery_codes' => 'Two factor recovery codes',
            
        ],
    ],

    'moderator' => [
        'title' => 'Moderators',

        'actions' => [
            'index' => 'Moderators',
            'create' => 'New Moderator',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'username' => 'Username',
            'pass' => 'Pass',
            'email' => 'Email',
            'name' => 'Name',
            'status' => 'Status',
            
        ],
    ],

    'feedback' => [
        'title' => 'Feedbacks',

        'actions' => [
            'index' => 'Feedbacks',
            'create' => 'New Feedback',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'descr' => 'Descr',
            'status' => 'Status',
            'request' => 'Request',
            'type' => 'Type',
            'score' => 'Score',
            'master' => 'Master',
            'client' => 'Client',
            
        ],
    ],

    'moderator' => [
        'title' => 'Moderators',

        'actions' => [
            'index' => 'Moderators',
            'create' => 'New Moderator',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'username' => 'Username',
            'pass' => 'Pass',
            'email' => 'Email',
            'name' => 'Name',
            'status' => 'Status',
            
        ],
    ],

    'feedback' => [
        'title' => 'Feedbacks',

        'actions' => [
            'index' => 'Feedbacks',
            'create' => 'New Feedback',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'descr' => 'Descr',
            'status' => 'Status',
            'request' => 'Request',
            'type' => 'Type',
            'score' => 'Score',
            'master' => 'Master',
            'client' => 'Client',
            
        ],
    ],

    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'usertype' => 'Usertype',
            'name' => 'Name',
            'email' => 'Email',
            'email_verified_at' => 'Email verified at',
            'password' => 'Password',
            'two_factor_secret' => 'Two factor secret',
            'two_factor_recovery_codes' => 'Two factor recovery codes',
            
        ],
    ],

    'client' => [
        'title' => 'Clients',

        'actions' => [
            'index' => 'Clients',
            'create' => 'New Client',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'userid' => 'Userid',
            'title' => 'Title',
            'status' => 'Status',
            'score' => 'Score',
            
        ],
    ],

    'offer' => [
        'title' => 'Offers',

        'actions' => [
            'index' => 'Offers',
            'create' => 'New Offer',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'descr' => 'Descr',
            'price' => 'Price',
            'client' => 'Client',
            'master' => 'Master',
            'status' => 'Status',
            'location' => 'Location',
            'accepted' => 'Accepted',
            'finished' => 'Finished',
            
        ],
    ],

    'master' => [
        'title' => 'Masters',

        'actions' => [
            'index' => 'Masters',
            'create' => 'New Master',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'userid' => 'Userid',
            'title' => 'Title',
            'descr' => 'Descr',
            'status' => 'Status',
            'score' => 'Score',
            
        ],
    ],

    'feedback' => [
        'title' => 'Feedbacks',

        'actions' => [
            'index' => 'Feedbacks',
            'create' => 'New Feedback',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'descr' => 'Descr',
            'status' => 'Status',
            'request' => 'Request',
            'type' => 'Type',
            'score' => 'Score',
            'master' => 'Master',
            'client' => 'Client',
            
        ],
    ],

    'master' => [
        'title' => 'Masters',

        'actions' => [
            'index' => 'Masters',
            'create' => 'New Master',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'userid' => 'Userid',
            'title' => 'Title',
            'descr' => 'Descr',
            'location' => 'Location',
            'status' => 'Status',
            'score' => 'Score',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];