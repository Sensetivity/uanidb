<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="@yield('description', 'УкрАніме — найбільша українська база даних аніме, манґи, персонажів та сейю. Понад 20,000 тайтлів.')">
  <title>@yield('title', 'УкрАніме - Українська База Аніме')</title>
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
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .gradient-border { background: linear-gradient(135deg, #06b6d4, #8b5cf6); padding: 2px; }
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 30px rgba(6,182,212,0.08); }
    @media (prefers-reduced-motion: reduce) {
      .card-hover, .card-hover:hover { transition: none; transform: none; }
      *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
    }
    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeSlideUp 0.5s ease-out both; }
    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
    .animate-delay-4 { animation-delay: 0.4s; }
    .animate-delay-5 { animation-delay: 0.5s; }
  </style>
  @stack('styles')
</head>
<body class="bg-slate-950 text-gray-100 leading-relaxed">
  <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-cyan-500 focus:text-white focus:rounded-lg">
    Перейти до контенту
  </a>

  @include('main.components.navbar')

  <main id="main-content">
    @yield('content')
  </main>

  @section('footer')
    @include('main.components.footer')
  @show

  @stack('scripts')
</body>
</html>
