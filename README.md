**Super PHP Description**

**Super PHP** is a lightweight, dynamic PHP framework designed for simplicity and flexibility in handling HTTP requests. It is built to dynamically process and respond to requests without relying on specific modules, functions, or namespaces, making it versatile and easy to extend. Below is an overview of its features:

### Features:
1. **Dynamic Routing:**
   - Supports `GET`, `POST`, `PUT`, and `DELETE` HTTP methods.
   - Allows registration of custom routes with corresponding handlers.
   - Includes a fallback route (`/404`) for unmatched paths.

2. **Autoloader:**
   - Automatically loads modules located in the `modules` directory.
   - Simplifies adding new functionality through modular PHP files.

3. **Request Handling:**
   - Parses request methods and URIs.
   - Handles query parameters (`$_GET`) and JSON/form data from the request body.
   - Routes requests to the appropriate handler dynamically.

4. **JSON-Based Responses:**
   - Outputs responses in a standardized JSON format.
   - Includes HTTP status codes for better API integration.

5. **Extensibility:**
   - Can be expanded with additional routes and handlers.
   - Easily integrates with external libraries and services.

6. **Minimalistic Structure:**
   - Provides a simple yet powerful framework for building APIs or lightweight web applications.
   - Does not rely on external dependencies, ensuring a low overhead.

### Example Use Cases:
- Creating RESTful APIs with minimal effort.
- Rapid prototyping of PHP applications.
- Building modular applications with an easy-to-use autoloading mechanism.

### CLI Support:

- Detects if the script is running in CLI mode using php_sapi_name().
- Accepts the HTTP method, URI, and JSON body as command-line arguments.
- Example CLI usage:

`php run.php POST /submit '{"name":"John", "age":30}'`


**Super PHP** is ideal for developers seeking a clean, simple, and customizable framework to manage dynamic PHP requests and responses effectively.
