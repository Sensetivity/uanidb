@props(['title' => 'УкрАніме - Українська База Аніме', 'description' => 'УкрАніме — найбільша українська база даних аніме, манґи, персонажів та сейю. Понад 20,000 тайтлів.', 'activeNav' => ''])
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ $description }}">
  <title>{{ $title }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;500;600;700;800&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-gray-100 leading-relaxed">
  <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-cyan-500 focus:text-white focus:rounded-lg">
    Перейти до контенту
  </a>

  <x-navbar :activeNav="$activeNav" />

  <main id="main-content">
    {{ $slot }}
  </main>

  <x-footer />
</body>
</html>
