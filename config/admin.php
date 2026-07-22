<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Superadmin Credentials
    |--------------------------------------------------------------------------
    |
    | Here you can configure the default superadmin credentials that will be
    | used when seeding the database. This allows you to securely set the
    | password in your .env file without committing it to source control.
    |
    */

    'superadmin_email' => env('SUPERADMIN_EMAIL', 'superadmin@gmail.com'),
    'superadmin_password' => env('SUPERADMIN_PASSWORD', 'password123'),

];
