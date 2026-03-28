<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EduSched - Scheduling Simplified</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{ asset('images/Edsched.png') }}">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-[#0D1B2A] text-white flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col font-sans">
        
        <header class="w-full lg:max-w-5xl max-w-[335px] text-sm mb-6">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        {{-- Dynamically route the user to their specific dashboard based on role --}}
                        @php
                            $dashboardRoute = route('student.home'); // Default fallback
                            if(Auth::user()->role === 'admin') {
                                $dashboardRoute = route('admin.dashboard');
                            } elseif(Auth::user()->role === 'faculty') {
                                $dashboardRoute = route('faculty.schedule');
                            }
                        @endphp
                        
                        <a href="{{ $dashboardRoute }}" class="px-5 py-2 text-[#2BB3C0] font-semibold hover:text-white transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 text-[#BCCCDC] font-semibold hover:text-white transition">Log in</a>
                        {{-- Register link removed because admin handles account creation --}}
                    @endauth
                </nav>
            @endif
        </header>

        <div class="flex items-center justify-center w-full lg:grow">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-5xl lg:flex-row overflow-hidden rounded-2xl shadow-2xl border border-white/5 bg-[#1B263B]">
                
                <div class="flex-1 p-8 lg:p-20 flex flex-col justify-center">
                    <div class="mb-4">
                        <span class="px-3 py-1 text-[10px] uppercase tracking-widest font-bold bg-[#F0B429] text-[#0D1B2A] rounded-full shadow-sm">Coming Soon</span>
                    </div>
                    
                    <h1 class="mb-3 font-bold text-4xl tracking-tight text-white italic">EduSched</h1>
                    <p class="mb-8 text-lg text-[#9FB3C8] leading-relaxed">
                        Simplifying Education Scheduling.<br>
                        A smart platform designed for the modern academic environment.
                    </p>
                    
                    <ul class="flex flex-col mb-10 space-y-4">
                        <li class="flex items-center gap-3 text-sm font-medium text-[#BCCCDC]">
                            <svg class="w-5 h-5 text-[#2BB3C0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            <span>Automated Timetable Generation</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium text-[#BCCCDC]">
                            <svg class="w-5 h-5 text-[#2BB3C0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            <span>Teacher & Room Conflict Alerts</span>
                        </li>
                    </ul>

                    <div>
                        {{-- Changed from Register to Login --}}
                        <a href="{{ route('login') }}" class="inline-block px-10 py-3 bg-gradient-to-r from-[#2BB3C0] to-[#0B4F6C] text-white rounded-xl font-bold shadow-lg hover:shadow-[#2BB3C0]/20 hover:-translate-y-1 transition-all duration-300">
                            Login to EduSched
                        </a>
                    </div>
                </div>

                <div class="relative bg-[#BCCCDC] lg:w-[480px] shrink-0 overflow-hidden flex items-center justify-center border-l border-gray-100 dark:border-gray-800">
                    <div class="relative w-full h-full overflow-hidden flex items-center justify-center">
                        <img 
                            src="{{ asset('images/EduSched5.gif') }}" 
                            alt="EduSched Animation" 
                            class="w-full h-full object-contain scale-[1.03] translate-y-[-1px]"
                        >
                    </div>
                </div>
            </main>
        </div>

        <footer class="py-10 text-center text-xs text-[#5D6D7E]">
            &copy; {{ date('Y') }} EduSched. Built for USTP IT Students.
        </footer>
    </body>
</html>