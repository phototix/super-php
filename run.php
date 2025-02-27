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

// Determine the request context (CLI or web server)
$isCli = php_sapi_name() === 'cli';

if ($isCli) {
    // Handle CLI requests
    $requestMethod = strtoupper($argv[1] ?? 'GET'); // First argument is the method (default: GET)
    $requestUri = $argv[2] ?? '/'; // Second argument is the URI (default: /)
    $queryParams = []; // Query parameters are not supported in CLI mode
    $bodyParams = json_decode($argv[3] ?? '{}', true) ?? []; // Third argument is the JSON body (optional)
} else {
    // Handle web server requests
    $requestMethod = $_SERVER['REQUEST_METHOD'] ?? null;
    $requestUri = $_SERVER['REQUEST_URI'] ?? null;
    $requestUri = strtok($requestUri, '?'); // Remove query string
    $queryParams = $_GET; // Query parameters (if any)
    $bodyParams = json_decode(file_get_contents('php://input'), true) ?? []; // JSON or form data
}

if (!$requestMethod || !$requestUri) {
    die("Invalid request. Ensure this script is running in a proper environment.\n");
}

// Basic routing structure
$routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => []
];

// Define a function to register routes
function registerRoute($method, $path, $handler) {
    global $routes;
    $routes[strtoupper($method)][$path] = $handler;
}

// Register routes (Example handlers)
registerRoute('GET', '/', function () {
    return ["status" => 200, "message" => "Welcome to Super PHP!"];
});

registerRoute('POST', '/', function ($bodyParams) {
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

if ($isCli) {
    // Provide CLI-friendly output
    echo "\nCLI Response:\n";
    print_r($response);
    echo "\n";
}

/**
 * Example Modules:
 * - Create additional PHP files in the 'modules' directory
 * - Name classes/functions as needed, and they will be autoloaded
 */
