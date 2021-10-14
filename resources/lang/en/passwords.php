<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'reset' => 'Your password has been reset!',
    'sent' => 'We have emailed your password reset link!',
    'throttled' => 'Please wait before retrying.',
    'token' => 'This password reset token is invalid.',
    'user' => "We can't find a user with that email address.",

    /*
    |--------------------------------------------------------------------------
    | Custom Auth Translations
    |--------------------------------------------------------------------------
    */

    'update-title' => 'Update Password',
    'update-subtitle' => 'Ensure your account is using a long, random password to stay secure.',

    'confirm-password-title' => 'Confirm Password',
    'confirm-password-text' => 'For your security, please confirm your password to continue.',
    'confirm-password-ok' => 'Confirm',
    'confirm-password-cancel' => 'Nevermind',

    'fields' => [
        'password' => 'Password',
        'password-confirm' => 'Confirm Password',
        'current-password' => 'Current Password',
        'new-password' => 'New password',
        'new-password-confirm' => 'Confirm new password',
    ],
];
