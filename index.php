<?php
// require_once __DIR__ . '/vendor/autoload.php'; // optional if using composer autoload
// If you don't have composer autoload, require files manually or use a simple autoloader:
spl_autoload_register(function($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) require $file;
});

use App\Controllers\OrderController;

$method = $path = '';
$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : "";
$path = isset($_SERVER['REQUEST_METHOD']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : "";

// normalize base if not placed at root
$base = ''; // set if your app sits under subpath, e.g. '/api'
$route = $base ? substr($path, strlen($base)) : $path;

// simple routing
$controller = new OrderController();

if ($method === 'POST' && preg_match('#/orders/?$#', $route)) {
    $controller->create();
} elseif ($method === 'GET' && preg_match('#/orders/active/?$#', $route)) {
    $controller->listActive();
} elseif ($method === 'POST' && preg_match('#/orders/(\d+)/complete?$#', $route, $m)) {
    $id = (int)$m[1];
    $controller->complete($id);
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error'=>'Not found']);
    exit;
}
