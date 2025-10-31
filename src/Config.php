<?php
namespace App;

class Config {
    public static function db() {
        return [
            'host' => '127.0.0.1',
            'dbname' => 'orders_db',
            'user' => 'root',
            'pass' => '',
            'charset' => 'utf8mb4'
        ];
    }

    // Kitchen capacity N
    public static function kitchenCapacity(): int {
        return 5; // change as needed
    }
}
