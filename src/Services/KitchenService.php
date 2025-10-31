<?php
namespace App\Services;

use App\Repositories\OrderRepository;
use App\Models\Order;
use App\DTO\CreateOrderRequest;
use App\Config;
use App\Exceptions\HttpException;

/**
 * Business logic: enforce kitchen capacity, VIP bypass.
 */
class KitchenService {
    private $repo;
    private $capacity;

    public function __construct(OrderRepository $repo, $capacity = null) {
        $this->repo = $repo;
        $this->capacity = $capacity ?? Config::kitchenCapacity();
    }

    public function canAccept(bool $isVip): bool {
        if ($isVip) return true;
        return $this->repo->countActive() < $this->capacity;
    }

    /**
     * Create an order (if capacity allows or it is VIP).
     * Returns Order model.
     * Throws HttpException(429) if not accepted.
     */
    public function createOrder(CreateOrderRequest $req): Order {
        $can = $this->canAccept($req->vip);
        if (!$can) {
            throw new HttpException("Kitchen is full", 429);
        }

        $order = new Order([
            'items' => $req->items,
            'vip' => $req->vip,
            'status' => 'active',
            'pickup_time' => $req->pickup_time
        ]);

        return $this->repo->create($order);
    }

    public function listActive(): array {
        return $this->repo->getActiveOrders();
    }

    public function completeOrder(int $id): bool {
        $found = $this->repo->findById($id);
        if (!$found) {
            throw new HttpException("Order not found", 404);
        }
        $ok = $this->repo->markCompleted($id);
        return $ok;
    }
}
