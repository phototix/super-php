<?php  
// Define a function to register routes
function registerRoute($method, $path, $handler) {
    global $routes;
    $routes[strtoupper($method)][$path] = $handler;
}

// Middleware for authentication
function authenticate($headers) {
    $authHeader = $headers['Authorization'] ?? null;
    if (!$authHeader || $authHeader !== 'Bearer super-secret-token') {
        http_response_code(401);
        echo json_encode(["status" => 401, "message" => "Unauthorized"]);
        exit;
    }
}

// Function to get headers
function getHeaders() {
    if (!function_exists('getallheaders')) {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (str_starts_with($name, 'HTTP_')) {
                $headers[str_replace('_', '-', substr($name, 5))] = $value;
            }
        }
        return $headers;
    }
    return getallheaders();
}
?>