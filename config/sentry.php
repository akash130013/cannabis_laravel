<?php

return [

   // 'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    'dsn' => 'https://7745214f151a49168d41ffca503c02c0@sentry.io/1775382',

    // capture release as git sha
    // 'release' => trim(exec('git --git-dir ' . base_path('.git') . ' log --pretty="%h" -n1 HEAD')),

    'breadcrumbs' => [

        // Capture bindings on SQL queries logged in breadcrumbs
        'sql_bindings' => true,

    ],

];
