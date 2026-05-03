<!DOCTYPE html>
<html class="light" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>@yield('title', 'Tanza National Trade School · ASPIRE')</title>
        <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Inter:ital,wght@0,100..900;1,100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script id="tailwind-config">
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        "colors": {
                            "primary": "#800000",
                            "primary-container": "#570000",
                            "on-primary": "#ffffff",
                            "on-primary-container": "#ffb4a8",
                            "surface": "#fff8f6",
                            "on-surface": "#261816",
                            "secondary": "#4c616c",
                            "surface-container-low": "#fff0ee",
                            "surface-container-highest": "#f7ddd8",
                            "outline-variant": "#e2bfb9",
                            "on-surface-variant": "#5a413d",
                        },
                        "borderRadius": {
                            "DEFAULT": "0.125rem",
                            "lg": "0.375rem",
                            "xl": "0.75rem",
                            "full": "9999px"
                        },
                        "fontFamily": {
                            "headline": ["Public Sans", "sans-serif"],
                            "body": ["Inter", "sans-serif"],
                            "lexend": ["Lexend", "sans-serif"]
                        }
                    },
                },
            }
        </script>
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
            @stack('styles')
        </style>
    </head>
    <body class="bg-surface text-on-surface font-body selection:bg-primary-container selection:text-on-primary-container">
        
        @include('pages.landing.partials.header')

        @yield('content')

        @include('pages.landing.partials.footer')
        
        @stack('scripts')
    </body>
</html>