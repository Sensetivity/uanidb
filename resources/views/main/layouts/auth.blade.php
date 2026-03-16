<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'УкрАніме')</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-slate-950 text-gray-100 min-h-screen flex flex-col">
  @include('main.components.navbar-auth')

  <div class="flex-grow flex items-center justify-center px-4 py-12">
    @yield('content')
  </div>

  <footer class="border-t border-slate-800 py-6">
    <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
      <p>&copy; 2025 УкрАніме. Усі права захищені.</p>
    </div>
  </footer>
</body>
</html>
