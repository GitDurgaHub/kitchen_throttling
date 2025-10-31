<?php
namespace App\DTO;

use App\Models\Order;

class OrderResponse {
    public static function fromModel(Order $o): array {
        $resp = [
            'id' => $o->id,
            'items' => $o->items,
            'VIP' => $o->vip
        ];
        if (isset($o->status)) $resp['status'] = $o->status;
        $resp['created_at'] = $o->created_at;
        $resp['pickup_time'] = $o->pickup_time;
        return $resp;
    }
}
