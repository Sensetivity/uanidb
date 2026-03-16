<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'УкрАніме - Українська База Аніме')</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .gradient-border { background: linear-gradient(135deg, #06b6d4, #8b5cf6); padding: 2px; }
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
  </style>
  @stack('styles')
</head>
<body class="bg-slate-950 text-gray-100">
  @include('main.components.navbar')

  @yield('content')

  @section('footer')
    @include('main.components.footer')
  @show

  @stack('scripts')
</body>
</html>
