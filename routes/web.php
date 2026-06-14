<?php

$routes = [
    __DIR__ . '/web/superadmin.php',
    __DIR__ . '/web/public.php',
    __DIR__ . '/web/student.php',
    __DIR__ . '/web/faculty.php',
    __DIR__ . '/web/guest-account.php',
    __DIR__ . '/web/admin.php',
];

foreach ($routes as $routeFile) {
    require $routeFile;
}