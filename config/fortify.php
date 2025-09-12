<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    'passwords' => 'users',
    'username' => 'employee_id',
    'email' => null,

    'home' => '/dashboard',

    'prefix' => '',
    'domain' => null,

    'middleware' => ['web'],

    'limiters' => [
        'login' => 'login',
    ],

    'views' => true,

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        // Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]),
    ],
];
