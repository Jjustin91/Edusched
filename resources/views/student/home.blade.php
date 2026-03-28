<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Student Home') }}
        </h2>
    </x-slot>

    <div class="relative bg-[#0D1B2A] py-16">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4 drop-shadow-lg">
                WELCOME TO EDUSCHED
            </h1>
            <p class="text-xl text-[#9FB3C8] font-medium max-w-2xl mx-auto drop-shadow-md">
                Select a Department to view available faculty and book a consultation.
            </p>
        </div>
    </div>

    <div class="py-12 bg-[#0D1B2A] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                
                @php
                    // Array of departments matching your mockup and database
                    $departments = [
                        ['code' => 'CEA', 'name' => 'College of Engineering & Architecture'],
                        ['code' => 'CITC', 'name' => 'College of Information Technology & Computing'],
                        ['code' => 'CSM', 'name' => 'College of Science & Mathematics'],
                        ['code' => 'COT', 'name' => 'College of Technology'],
                        ['code' => 'SHS', 'name' => 'Senior High School'],
                        ['code' => 'CSTE', 'name' => 'College of Science and Technology Ed.'],
                        ['code' => 'MED', 'name' => 'Medical Department'],
                    ];
                @endphp

                @foreach($departments as $dept)
                    <a href="{{ route('student.department', $dept['code']) }}" class="group relative bg-[#1B263B] backdrop-blur-sm border-t-4 border-transparent hover:border-[#F0B429] shadow-md hover:shadow-xl rounded-lg p-8 flex flex-col items-center justify-center min-h-[160px] transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                        
                        <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-gray-100 group-hover:text-[#F0B429] transition-colors duration-300 z-0" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
                        
                        <div class="relative z-10 text-center">
                            <h2 class="text-3xl font-black text-white group-hover:text-[#F0B429] mb-2 transition-colors duration-200">
                                {{ $dept['code'] }}
                            </h2>
                            <p class="text-xs font-medium text-[#9FB3C8] group-hover:text-white transition-colors duration-200">
                                {{ $dept['name'] }}
                            </p>
                        </div>
                    </a>
                @endforeach

            </div>

        </div>
    </div>
</x-app-layout>