<?php
namespace App\Exceptions;

class HttpException extends \Exception {
    protected $statusCode;

    public function __construct(string $message = "", int $statusCode = 500) {
        parent::__construct($message, $statusCode);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int {
        return $this->statusCode;
    }
}
