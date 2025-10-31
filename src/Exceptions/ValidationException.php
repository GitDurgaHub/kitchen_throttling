<?php
namespace App\Exceptions;

class ValidationException extends HttpException {
    protected $errors;
    public function __construct(array $errors) {
        parent::__construct("Validation failed", 422);
        $this->errors = $errors;
    }
    public function getErrors(): array {
        return $this->errors;
    }
}
