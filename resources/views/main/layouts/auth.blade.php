<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'УкрАніме')</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;500;600;700;800&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --font-display: 'Unbounded', sans-serif;
      --font-body: 'Source Sans 3', sans-serif;
    }
    body { font-family: var(--font-body); }
    h1, h2, h3, h4, h5, h6, .font-display { font-family: var(--font-display); letter-spacing: -0.02em; }
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
    }
  </style>
</head>
<body class="bg-slate-950 text-gray-100 min-h-screen flex flex-col leading-relaxed">
  @include('main.components.navbar-auth')

  <main class="flex-grow flex items-center justify-center px-4 py-12">
    @yield('content')
  </main>

  <footer class="border-t border-slate-800 py-6">
    <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
      <p>&copy; 2025 УкрАніме. Усі права захищені.</p>
    </div>
  </footer>
</body>
</html>
