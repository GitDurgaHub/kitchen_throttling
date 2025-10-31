<?php
namespace App\Models;

class Order {
    public $id;
    public $items;
    public $vip;
    public $status;
    public $created_at;
    public $pickup_time;
    public $completed_at;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->items = $data['items'] ?? [];
        $this->vip = (bool)($data['vip'] ?? false);
        if (isset($data['status'])) $this->status = $data['status'] ?? 'active';
        $this->created_at = $data['created_at'] ?? date('Y-m-d H:i:s');
        $this->pickup_time = $data['pickup_time'] ?? null;
        $this->completed_at = $data['completed_at'] ?? null;
    }
}
