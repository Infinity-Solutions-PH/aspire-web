<!DOCTYPE html>
<html class="dark" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>Enrollment Pipeline | TNTS ASPIRE</title>
        
        <!-- Tailwind for rapid prototyping, consider production build later -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;display=swap" rel="stylesheet"/>
        
        <script id="tailwind-config">
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "primary": "#800000",
                            "accent-red": "#d41111",
                        },
                        fontFamily: {
                            "sans": ["Lexend", "sans-serif"]
                        },
                    },
                },
            }
        </script>
        
        @livewireStyles
        
        <style type="text/tailwindcss">
            body {
                font-family: 'Lexend', sans-serif;
            }
        </style>
    </head>
    <body class="bg-gray-950 min-h-screen text-gray-200 antialiased flex flex-col items-center justify-center p-4">
        
        <main class="w-full">
            {{ $slot }}
        </main>

        <footer class="mt-8 text-center">
            <p class="text-[10px] text-gray-600 uppercase tracking-widest font-medium">
                © 2026 Tanza National Trade School | ASPIRE v1.0
            </p>
        </footer>

        @livewireScripts
    </body>
</html>
