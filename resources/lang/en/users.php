<?php

return [
    'resource' => 'User',
    'resource_plural' => 'Users(s)',

    'fields' => [
        'id' => 'User ID',
        'name' => 'Name',
        'email' => 'E-Mail',
        'verification_code' => 'Code',
        'recovery_code' => 'Recovery Code',
        'profile_photo_url' => 'Profile Photo',
    ],

    'delete-title' => 'Delete Account',
    'delete-subtitle' => 'Permanently delete your account on :site_name. All your data will be deleted.',
    'delete-warning' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
    'delete-confirmation' => 'Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',

    'sessions-title' => 'Browser Sessions',
    'sessions-subtitle' => 'Manage and logout your active sessions on other browsers and devices.',
    'sessions-description' => 'If necessary, you may logout of all of your other browser sessions across all of your devices. If you feel your account has been compromised, you should also update your password.',
    'sessions-this-device' => 'This device',
    'sessions-last-active' => 'Last Active :time',
    'sessions-logout-other' => 'Logout Other Devices',

    'two-factor-title' => 'Two Factor Authentication',
    'two-factor-subtitle' => 'Add additional security to your account using two factor authentication.',
    'two-factor-on' => 'You have enabled two factor authentication.',
    'two-factor-on-description' => ' Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.',
    'two-factor-off' => 'You have not enabled two factor authentication.',
    'two-factor-description' => 'When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application or Authy.',
    'two-factor-recovery-codes' => 'Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.',
    'two-factor-generate' => 'Regenerate Codes',
    'two-factor-show-codes' => 'Show Codes',

    'profile-title' => 'Profile Information',
    'profile-subtitle' => 'Update your account\'s profile information and email address.',

    'action-upload-photo' => 'Upload new photo',
];
