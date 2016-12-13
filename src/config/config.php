<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/12/16
 * Time: 6:35 PM
 */

return [
    'Facebook'=>[
        'options' => ['email'],
        'keys'=>[
            'id'    => 'facebook_123',
            'secret' => 'secret_password'
        ]
    ],
    'Twitter'=>[
        'options' => ['include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true'],
        'keys'=>[
            'id'    => 'twitter_123',
            'secret' => 'secret_password'
        ]
    ]
];