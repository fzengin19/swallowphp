
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Swallow Framework</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gray-100 text-gray-50">

  <header class="bg-white shadow">
    <div class="container mx-auto px-4 py-6 flex justify-between items-center">
      <div>
        <h1 class="text-3xl text-sky-700 font-bold">Welcome to Swallow Framework</h1>
        <p class="text-lg text-gray-800 mt-2">A fast and lightweight PHP framework for building web applications.</p>
      </div>
    </div>
  </header>

  <main class="container mx-auto px-4 py-6">
    <h2 class="text-2xl text-sky-700 font-bold mb-4">Features</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-white rounded-xs shadow p-6">
        <h3 class="text-xl text-sky-700 font-bold">Routing</h3>
        <p class="mt-2 text-gray-800">Swallow Framework provides a simple and elegant routing system that makes it easy to define your application's endpoints.</p>
      </div>
      <div class="bg-white rounded-xs shadow p-6">
        <h3 class="text-xl text-sky-700 font-bold">Middleware</h3>
        <p class="mt-2 text-gray-800">Middleware allows you to intercept and modify requests and responses before they are processed by your application's endpoints.</p>
      </div>
      <div class="bg-white rounded-xs shadow p-6">
        <h3 class="text-xl text-sky-700  font-bold">Database</h3>
        <p class="mt-2 text-gray-800">Swallow Framework's database module provides a convenient and efficient way to interact with your database using a fluent query builder.</p>
      </div>
      <div class="bg-white rounded-xs shadow p-6">
        <h3 class="text-xl text-sky-700 font-bold">Views</h3>
        <p class="mt-2 text-gray-800">The framework's view system allows you to easily render dynamic content using simple and intuitive syntax.</p>
      </div>
    </div>
  </main>

  <div class="h-[50px] w-full"></div>


  <?php
  $startTime = $_SERVER['REQUEST_TIME_FLOAT'];
  // $startTime = SWALLOW_START;
  $endTime = microtime(true);
  $executionTime = ($endTime - $startTime) * 1000;
  $executionTime = number_format($executionTime, 2);
  ?>
  <span class="fixed bottom-2 left-4 bg-white text-black px-4 py-2 rounded-xs shadow">
  <i class="fa-regular fa-clock"></i> <?= $executionTime . ' ms' ?>
  </span>


  <a href="/docs" class="fixed bottom-2 right-4 bg-white text-black px-4 py-2 rounded-xs shadow">
    Documentation
  </a>
</body>

</html>
