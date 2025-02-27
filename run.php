<?php
/**
 * Super PHP: A simple, dynamic PHP router and request handler.
 */

// Define a basic autoloader for modular functionality (if needed)
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/modules/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Handle the incoming request dynamically
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = strtok($_SERVER['REQUEST_URI'], '?'); // Remove query string
$queryParams = $_GET; // Query parameters (if any)
$bodyParams = json_decode(file_get_contents('php://input'), true) ?? []; // JSON or form data

// Basic routing structure
$routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => []
];

// Define a function to register routes
define('registerRoute', function ($method, $path, $handler) use (&$routes) {
    $routes[strtoupper($method)][$path] = $handler;
});

// Register routes (Example handlers)
registerRoute('GET', '/', function () {
    return ["status" => 200, "message" => "Welcome to Super PHP!"];
});

registerRoute('POST', '/submit', function ($bodyParams) {
    return ["status" => 200, "message" => "Data received.", "data" => $bodyParams];
});

// Fallback handler for unmatched routes
$routes['GET']['/404'] = function () {
    return ["status" => 404, "message" => "Page not found."];
};

// Router logic to match the request
$handler = $routes[$requestMethod][$requestUri] ?? $routes['GET']['/404'];

// Execute the matched handler
$response = is_callable($handler) ? $handler($bodyParams) : ["status" => 500, "message" => "Internal server error."];

// Output the response as JSON
header('Content-Type: application/json');
http_response_code($response['status'] ?? 200);
echo json_encode($response);

/**
 * Example Modules:
 * - Create additional PHP files in the 'modules' directory
 * - Name classes/functions as needed, and they will be autoloaded
 */
