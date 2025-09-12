<?php

return [

    // 既定のハッシュドライバは bcrypt
    'driver' => 'bcrypt',

    // bcrypt のオプション
    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 12),
    ],

    // （参考）argon の設定。今回は使いません
    'argon' => [
        'memory'  => 65536,
        'threads' => 1,
        'time'    => 4,
    ],
];
