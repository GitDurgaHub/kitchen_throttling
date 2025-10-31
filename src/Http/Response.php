<?php
namespace App\Http;

class Response {
    public static function json($data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function error(string $message, int $status = 500, array $meta = []): void {
        self::json(array_merge(['error' => $message], $meta ? ['meta' => $meta] : []), $status);
    }
}
