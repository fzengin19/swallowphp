<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Swallow Framework</title>
  <link rel="stylesheet" href="https://cdn.tailwindcss.com/2.2.4/tailwind.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/themes/prism-tomorrow.min.css">
</head>

<body class="bg-gray-100 text-gray-900">
  <header class="bg-white shadow">
    <div class="container mx-auto px-4 py-6 flex justify-between items-center">
      <div>
        <h1 class="text-3xl text-sky-700 font-bold">Welcome to Swallow Framework</h1>
        <p class="text-lg text-gray-800 mt-2">A fast and lightweight PHP framework for building web applications.</p>
      </div>
    </div>
  </header>

  <main class="container mx-auto px-4 py-6">
    <section id="routing" class="mb-8">
      <h2 class="text-2xl font-bold mb-4">Routing</h2>
      <p class="mb-4">Swallow Framework provides a simple and elegant routing system that makes it easy to define your application's endpoints.</p>
      <div class="code-block rounded-lg overflow-hidden">
        <pre><code class="language-php">
// Define a route
Route::get('/hello', function () {
  return 'Hello, World!';
});

// Handle the request
$router = new Router();
$router->dispatch();
        </code></pre>
      </div>
    </section>

    <section id="middleware" class="mb-8">
      <h2 class="text-2xl font-bold mb-4">Middleware</h2>
      <p class="mb-4">Middleware allows you to intercept and modify requests and responses before they are processed by your application's endpoints.</p>
      <div class="code-block rounded-lg overflow-hidden">
        <pre><code class="language-php">
// Define middleware
class AuthMiddleware {
  public function handle(Request $request, Closure $next)
  {
    // Perform authentication logic

    // Call the next middleware or the endpoint handler
    return $next($request);
  }
}

// Apply middleware to a route
Route::get('/profile', 'ProfileController@index')->middleware(AuthMiddleware::class);

// Handle the request
class ProfileController {
  public function index()
  {
    // Handle the authenticated request
  }
}
        </code></pre>
      </div>
    </section>

    <section id="database" class="mb-8">
      <h2 class="text-2xl font-bold mb-4">Database</h2>
      <p class="mb-4">Swallow Framework includes a powerful database abstraction layer that simplifies database operations and allows you to work with different database systems.</p>
      <div class="code-block rounded-lg overflow-hidden">
        <pre><code class="language-php">
// Retrieve records from a table
$users = DB::table('users')->where('status', 'active')->get();

// Insert a new record
DB::table('users')->insert([
  'name' => 'John Doe',
  'email' => 'john@example.com',
  'status' => 'active'
]);

// Update records
DB::table('users')->where('id', 1)->update(['status' => 'inactive']);

// Delete records
DB::table('users')->where('status', 'inactive')->delete();
        </code></pre>
      </div>
    </section>

    <section id="views">
      <h2 class="text-2xl font-bold mb-4">Views</h2>
      <p class="mb-4">The framework's view system allows you to easily render dynamic content using simple and intuitive syntax.</p>
      <div class="code-block rounded-lg overflow-hidden">
        <pre><code class="language-php">
// Render a view with data
$viewData = ['title' => 'Welcome', 'message' => 'Hello, World!'];
$view = new View('welcome', $viewData);
$view->render();
        </code></pre>
      </div>
    </section>
  </main>

  <footer class="bg-white shadow">
    <div class="container mx-auto px-4 py-6 text-center text-gray-600">
      <p>&copy; 2023 Swallow Framework. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/prism.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/components/prism-php.min.js"></script>
</body>

</html>
