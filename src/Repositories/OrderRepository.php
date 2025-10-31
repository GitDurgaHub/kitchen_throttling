<?php
namespace App\Repositories;

use App\Database;
use App\Models\Order;
use PDO;

class OrderRepository {
    private $db;
    public function __construct() {
        $this->db = \App\Database::getConnection();
    }

    public function create(Order $order): Order {
        $stmt = $this->db->prepare(
            "INSERT INTO orders (items, vip, status, pickup_time) VALUES (:items, :vip, :status, :pickup_time)"
        );
        $stmt->execute([
            ':items' => json_encode($order->items, JSON_UNESCAPED_UNICODE),
            ':vip' => $order->vip ? 1 : 0,
            ':status' => $order->status,
            ':pickup_time' => $order->pickup_time
        ]);
        $order->id = (int)$this->db->lastInsertId();
        return $order;
    }

    public function countActive(): int {
        $stmt = $this->db->query("SELECT COUNT(*) AS c FROM orders WHERE status = 'active'");
        $row = $stmt->fetch();
        return (int)$row['c'];
    }

    public function getActiveOrders(): array {
        $stmt = $this->db->query("SELECT id, items, vip, created_at, pickup_time FROM orders WHERE status = 'active' ORDER BY created_at ASC");
        $rows = $stmt->fetchAll();
        return array_map([$this, 'rowToModel'], $rows);
    }

    public function findById(int $id): ?Order {
        $stmt = $this->db->prepare("SELECT id, items FROM orders WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        $row = (array)$row;
        return new Order([
            'id' => (int)$row['id'],
            'items' => json_decode($row['items'], true) ?: []
        ]);
    }

    public function markCompleted(int $id): bool {
        $stmt = $this->db->prepare("UPDATE orders SET status = 'completed', completed_at = NOW() WHERE id = :id AND status = 'active'");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    private function rowToModel(array $row): Order {
        return new Order([
            'id' => (int)$row['id'],
            'items' => json_decode($row['items'], true) ?: [],
            'vip' => (bool)$row['vip'],
            'created_at' => $row['created_at'],
            'pickup_time' => $row['pickup_time']
        ]);
    }
}
