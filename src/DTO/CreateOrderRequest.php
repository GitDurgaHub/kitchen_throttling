<?php
namespace App\DTO;

class CreateOrderRequest {
    public $items;
    public $pickup_time;
    public $vip;

    public function __construct(array $payload) {
        $this->items = $payload['items'] ?? [];
        $this->pickup_time = $payload['pickup_time'] ?? null;
        $this->vip = isset($payload['VIP']) ? (bool)$payload['VIP'] : (bool)($payload['vip'] ?? false);
    }
}