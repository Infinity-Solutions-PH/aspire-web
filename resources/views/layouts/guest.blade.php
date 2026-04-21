<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Enrollment Gateway | TNTS ASPIRE' }}</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: {
                "primary": "#d41111",
                "background-light": "#f8f6f6",
                "background-dark": "#221010",
                "maroon-accent": "#800000",
              },
              fontFamily: {
                "display": ["Lexend", "sans-serif"]
              },
              borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            },
          },
        }
    </script>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Lexend', sans-serif;
        }
        [x-cloak] { display: none !important; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .dark .glass-card {
            background: rgba(34, 16, 16, 0.7);
        }
    </style>
    
    @livewireStyles
</head>
<body class="bg-background-light dark:bg-background-dark text-[#1b0d0d] dark:text-[#fcf8f8] min-h-screen">
    
    <!-- Header -->
    <header class="flex items-center justify-between px-8 py-6 bg-white/50 dark:bg-black/20 backdrop-blur-md border-b border-[#e7cfcf] dark:border-white/10 sticky top-0 z-50">
        <div class="flex items-center gap-4 mx-auto max-w-7xl w-full">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center rounded-lg size-12 text-white">
                    <x-app-logo-image class="size-full" />
                </div>
                <div class="flex flex-col">
                    <h1 class="text-[#1b0d0d] dark:text-white text-2xl font-bold leading-none tracking-tighter">TNTS ASPIRE</h1>
                    <p class="text-primary text-[10px] font-bold uppercase tracking-widest">Public Enrollment Gateway</p>
                </div>
            </div>
            <div class="ml-auto">
                <a href="{{ route('home') }}" class="text-sm font-bold text-gray-500 hover:text-primary transition-colors">Cancel & Return</a>
            </div>
        </div>
    </header>

    <main class="py-12 px-4 min-h-[calc(100vh-80px)] flex flex-col">
        <div class="max-w-4xl w-full mx-auto flex-1 flex flex-col">
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
</body>
</html>
