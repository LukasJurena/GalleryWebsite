<?php
// app/Http/Kernel.php

protected $routeMiddleware = [
    // Ostatní middleware...
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];
