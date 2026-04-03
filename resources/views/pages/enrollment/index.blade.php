<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TNTS Online Enrollment - Step 2</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
<style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-card {
            background: rgba(34, 16, 16, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-[#1b0d0d] dark:text-[#f8f6f6] min-h-screen">
<div class="layout-container flex h-full grow flex-col">
<!-- Top Navigation Bar -->
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-[#e7cfcf] dark:border-white/10 bg-white/50 dark:bg-black/20 backdrop-blur-md px-10 py-3 sticky top-0 z-50">
<div class="flex items-center gap-4 text-primary">
<div class="size-8">
<svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
<path clip-rule="evenodd" d="M10.4485 13.8519C10.4749 13.9271 10.6203 14.246 11.379 14.7361C12.298 15.3298 13.7492 15.9145 15.6717 16.3735C18.0007 16.9296 20.8712 17.2655 24 17.2655C27.1288 17.2655 29.9993 16.9296 32.3283 16.3735C34.2508 15.9145 35.702 15.3298 36.621 14.7361C37.3796 14.246 37.5251 13.9271 37.5515 13.8519C37.5287 13.7876 37.4333 13.5973 37.0635 13.2931C36.5266 12.8516 35.6288 12.3647 34.343 11.9175C31.79 11.0295 28.1333 10.4437 24 10.4437C19.8667 10.4437 16.2099 11.0295 13.657 11.9175C12.3712 12.3647 11.4734 12.8516 10.9365 13.2931C10.5667 13.5973 10.4713 13.7876 10.4485 13.8519ZM37.5563 18.7877C36.3176 19.3925 34.8502 19.8839 33.2571 20.2642C30.5836 20.9025 27.3973 21.2655 24 21.2655C20.6027 21.2655 17.4164 20.9025 14.7429 20.2642C13.1498 19.8839 11.6824 19.3925 10.4436 18.7877V34.1275C10.4515 34.1545 10.5427 34.4867 11.379 35.027C12.298 35.6207 13.7492 36.2054 15.6717 36.6644C18.0007 37.2205 20.8712 37.5564 24 37.5564C27.1288 37.5564 29.9993 37.2205 32.3283 36.6644C34.2508 36.2054 35.702 35.6207 36.621 35.027C37.4573 34.4867 37.5485 34.1546 37.5563 34.1275V18.7877ZM41.5563 13.8546V34.1455C41.5563 36.1078 40.158 37.5042 38.7915 38.3869C37.3498 39.3182 35.4192 40.0389 33.2571 40.5551C30.5836 41.1934 27.3973 41.5564 24 41.5564C20.6027 41.5564 17.4164 41.1934 14.7429 40.5551C12.5808 40.0389 10.6502 39.3182 9.20848 38.3869C7.84205 37.5042 6.44365 36.1078 6.44365 34.1455L6.44365 13.8546C6.44365 12.2684 7.37223 11.0454 8.39581 10.2036C9.43325 9.3505 10.8137 8.67141 12.343 8.13948C15.4203 7.06909 19.5418 6.44366 24 6.44366C28.4582 6.44366 32.5797 7.06909 35.657 8.13948C37.1863 8.67141 38.5667 9.3505 39.6042 10.2036C40.6278 11.0454 41.5563 12.2684 41.5563 13.8546Z" fill="currentColor" fill-rule="evenodd"></path>
</svg>
</div>
<h2 class="text-lg font-bold leading-tight tracking-[-0.015em] text-[#1b0d0d] dark:text-[#fcf8f8]">TNTS Online Enrollment</h2>
</div>
<div class="flex flex-1 justify-end gap-8 items-center">
<nav class="hidden md:flex items-center gap-9">
<a class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-medium leading-normal hover:text-primary transition-colors" href="#">Home</a>
<a class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-medium leading-normal hover:text-primary transition-colors" href="#">Announcements</a>
<a class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-medium leading-normal hover:text-primary transition-colors" href="#">Help Center</a>
</nav>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary/20" data-alt="Student profile avatar placeholder" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC61O-gETsLCZRhNSxDFvcUsQdI5kIzXXgMjoRIWmqP2vUqGHujNjYBcUIejT17I5SJRLtMMiAzQ43g1lEFIZnPzDG41XIy1CPJfhMTbO2hS1ykqBh0IRVu2szmlIr7IlhY9SYFc3SdNdYN5aMv28MogmQtRGwR1jNCY-clOn-NbUS0Rb5ypVO-0XdzTycR97mGi831A4b5NAlOIOkVuI-r_orffRh6H-X-B8BJXecCNX6z1tzXTJJN4pmk_S1pzCRd92PGIdgjOrY");'></div>
</div>
</header>
<main class="flex-1 flex flex-col items-center py-10 px-4">
<div class="max-w-[960px] w-full flex flex-col gap-6">
<!-- Progress Tracker -->
<div class="glass-card rounded-xl p-6 shadow-sm border border-[#e7cfcf] dark:border-white/10">
<div class="flex flex-col gap-3">
<div class="flex gap-6 justify-between items-center">
<p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-lg font-bold leading-normal">Step 2: Details &amp; Upload</p>
<p class="text-primary text-sm font-semibold leading-normal">66% Complete</p>
</div>
<div class="rounded-full bg-[#e7cfcf] dark:bg-white/10 overflow-hidden h-2.5">
<div class="h-full rounded-full bg-primary" style="width: 66%;"></div>
</div>
<div class="flex justify-between items-center pt-2">
<p class="text-[#9a4c4c] dark:text-[#e7cfcf] text-sm font-medium">Schedule <span class="mx-2 text-primary font-bold">✓</span> Details <span class="mx-2 font-bold text-primary">&gt;</span> Upload</p>
<div class="flex items-center gap-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 px-3 py-1 rounded-full text-xs font-semibold">
<span class="material-symbols-outlined text-sm">cloud_done</span>
<span>Draft Saved</span>
</div>
</div>
</div>
</div>
<!-- Form Section: Student Information -->
<section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
<div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
<h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Student Information</h2>
<p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Please provide accurate personal information as it appears on your official records.</p>
</div>
<div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
<label class="flex flex-col gap-2">
<span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">First Name</span>
<input class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Juan" type="text"/>
</label>
<label class="flex flex-col gap-2">
<span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Last Name</span>
<input class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="e.g. Dela Cruz" type="text"/>
</label>
<label class="flex flex-col gap-2">
<span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Learner Reference Number (LRN)</span>
<input class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="12-digit number" type="text"/>
</label>
<label class="flex flex-col gap-2">
<span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Date of Birth</span>
<input class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" type="date"/>
</label>
<label class="flex flex-col gap-2 md:col-span-2">
<span class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Full Address</span>
<input class="form-input rounded-lg border-[#e7cfcf] dark:border-white/20 bg-white/50 dark:bg-black/20 focus:border-primary focus:ring-primary h-12 text-sm" placeholder="House No., Street, Barangay, City/Municipality" type="text"/>
</label>
</div>
</section>
<!-- Form Section: Document Upload -->
<section class="glass-card rounded-xl shadow-sm border border-[#e7cfcf] dark:border-white/10 overflow-hidden">
<div class="border-b border-[#e7cfcf] dark:border-white/10 px-8 py-5 bg-primary/5">
<h2 class="text-[#1b0d0d] dark:text-[#fcf8f8] text-xl font-bold leading-tight tracking-tight">Document Upload</h2>
<p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Upload scanned copies or clear photos of required documents (Max 5MB each, PDF/JPG/PNG).</p>
</div>
<div class="p-8 flex flex-col gap-6">
<!-- PSA Birth Certificate -->
<div class="flex flex-col gap-2">
<p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">PSA Birth Certificate</p>
<div class="border-2 border-dashed border-[#e7cfcf] dark:border-white/20 rounded-xl p-8 flex flex-col items-center justify-center gap-3 bg-white/20 dark:bg-black/10 hover:border-primary/50 transition-colors cursor-pointer group">
<span class="material-symbols-outlined text-primary text-4xl group-hover:scale-110 transition-transform">upload_file</span>
<div class="text-center">
<p class="text-sm font-medium text-[#1b0d0d] dark:text-[#fcf8f8]">Drag and drop your file here or <span class="text-primary font-bold">browse</span></p>
<p class="text-xs text-[#9a4c4c] dark:text-[#e7cfcf] mt-1">Accepts PDF, JPG, PNG</p>
</div>
</div>
</div>
<!-- Grid for smaller uploads -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="flex flex-col gap-2">
<p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Form 138 (Report Card)</p>
<div class="border-2 border-dashed border-[#e7cfcf] dark:border-white/20 rounded-xl p-6 flex flex-col items-center justify-center gap-2 bg-white/20 dark:bg-black/10 hover:border-primary/50 transition-colors cursor-pointer group">
<span class="material-symbols-outlined text-primary text-2xl">add_a_photo</span>
<p class="text-xs font-medium text-[#1b0d0d] dark:text-[#fcf8f8]">Select File</p>
</div>
</div>
<div class="flex flex-col gap-2">
<p class="text-[#1b0d0d] dark:text-[#fcf8f8] text-sm font-semibold">Certificate of Good Moral</p>
<div class="border-2 border-dashed border-[#e7cfcf] dark:border-white/20 rounded-xl p-6 flex flex-col items-center justify-center gap-2 bg-white/20 dark:bg-black/10 hover:border-primary/50 transition-colors cursor-pointer group">
<span class="material-symbols-outlined text-primary text-2xl">add_a_photo</span>
<p class="text-xs font-medium text-[#1b0d0d] dark:text-[#fcf8f8]">Select File</p>
</div>
</div>
</div>
</div>
</section>
<!-- Navigation Buttons -->
<div class="flex justify-between items-center py-6 px-4">
<button class="flex items-center gap-2 px-6 py-3 rounded-lg font-bold text-[#1b0d0d] dark:text-[#fcf8f8] border border-[#e7cfcf] dark:border-white/20 hover:bg-white/50 dark:hover:bg-white/10 transition-all">
<span class="material-symbols-outlined">arrow_back</span>
                        Back to Schedule
                    </button>
<div class="flex gap-4">
<button class="px-6 py-3 rounded-lg font-bold text-[#1b0d0d] dark:text-[#fcf8f8] hover:bg-white/50 dark:hover:bg-white/10 transition-all">
                            Save Draft
                        </button>
<button class="bg-primary text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center gap-2">
                            Review &amp; Submit
                            <span class="material-symbols-outlined">arrow_forward</span>
</button>
</div>
</div>
</div>
</main>
<!-- Footer -->
<footer class="mt-auto py-8 border-t border-[#e7cfcf] dark:border-white/10 px-10 text-center">
<p class="text-sm text-[#9a4c4c] dark:text-[#e7cfcf]">© 2024 Tanza National Trade School. All Rights Reserved.</p>
<div class="flex justify-center gap-6 mt-4">
<a class="text-xs font-medium text-primary hover:underline" href="#">Privacy Policy</a>
<a class="text-xs font-medium text-primary hover:underline" href="#">Terms of Service</a>
<a class="text-xs font-medium text-primary hover:underline" href="#">Contact Support</a>
</div>
</footer>
</div>
</body></html>