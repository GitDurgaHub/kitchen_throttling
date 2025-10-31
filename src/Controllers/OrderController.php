<?php
namespace App\Controllers;

use App\Http\Response;
use App\DTO\CreateOrderRequest;
use App\Repositories\OrderRepository;
use App\Services\KitchenService;
use App\DTO\OrderResponse;
use App\Validators\CreateOrderValidator;
use App\Exceptions\HttpException;
use App\Exceptions\ValidationException;

class OrderController {
    private $kitchen;

    public function __construct() {
        $repo = new OrderRepository();
        $this->kitchen = new KitchenService($repo);
    }

    public function create(): void {
        try {
            $payload = json_decode(file_get_contents('php://input'), true);
            if ($payload === null) {
                throw new ValidationException(['body' => 'Invalid JSON']);
            }
            $req = new CreateOrderRequest($payload);
            CreateOrderValidator::validate($req);

            $dt = new \DateTime($req->pickup_time);
            $req->pickup_time = $dt->format('Y-m-d H:i:s');

            $order = $this->kitchen->createOrder($req);
            Response::json(['data' => OrderResponse::fromModel($order)], 201);
        } catch (ValidationException $ve) {
            Response::json(['error' => 'validation_failed', 'details' => $ve->getErrors()], 422);
        } catch (HttpException $he) {
            Response::error($he->getMessage(), $he->getStatusCode());
        } catch (\Throwable $t) {
            Response::error('Server error: ' . $t->getMessage(), 500);
        }
    }

    public function listActive(): void {
        try {
            $orders = $this->kitchen->listActive();
            $out = array_map(function($o) {
                return OrderResponse::fromModel($o);
            }, $orders);
            Response::json(['data' => $out], 200);
        } catch (\Throwable $t) {
            Response::error('Server error: ' . $t->getMessage(), 500);
        }
    }

    public function complete(int $id): void {
        try {
            $ok = $this->kitchen->completeOrder($id);
            if ($ok) {
                Response::json(['message' => 'Order marked completed'], 200);
            } else {
                // If not updated, either already completed or not active; report 404 for simplicity
                Response::error('Order not active or not found', 404);
            }
        } catch (HttpException $he) {
            Response::error($he->getMessage(), $he->getStatusCode());
        } catch (\Throwable $t) {
            Response::error('Server error: ' . $t->getMessage(), 500);
        }
    }
}
