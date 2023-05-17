<?php

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With");
header("Access-Control-Allow-Methods: OPTIONS, POST, GET, PUT, DELETE");
header('Content-Type: application/json');

$dotenv = Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'pgsql',
    'host'      => 'postgres',
    'database'  => 'postgres',
    'username'  => 'postgres',
    'password'  => '123456',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

