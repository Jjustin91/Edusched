<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ $department }} Department Faculty
            </h2>
            <a href="{{ route('student.home') }}" class="text-sm font-medium text-gray-400 hover:text-white transition flex items-center">
                &larr; Back to Departments
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#0D1B2A] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($faculties->isEmpty())
                <div class="bg-[#1B263B] rounded-lg shadow-sm p-12 text-center border-t-4 border-[#F0B429]">
                    <svg class="mx-auto h-12 w-12 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <h3 class="text-lg font-bold text-white">No Faculty Found</h3>
                    <p class="text-gray-400 mt-2">There are currently no faculty members registered in the {{ $department }} department.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($faculties as $faculty)
                        <div class="bg-[#1B263B] rounded-xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-gray-700 flex flex-col">
                            <div class="p-6 flex-grow flex flex-col items-center text-center">
                                <div class="w-24 h-24 rounded-full bg-[#0D1B2A] text-white flex items-center justify-center text-3xl font-bold mb-4 shadow-inner border-4 border-[#1B263B] ring-2 ring-gray-700">
                                    @if($faculty->avatar)
                                        <img class="h-full w-full rounded-full object-cover" src="{{ asset('storage/' . $faculty->avatar) }}" alt="{{ $faculty->name }}">
                                    @else
                                        {{ substr($faculty->name, 0, 1) }}
                                    @endif
                                </div>
                                
                                <h3 class="text-xl font-bold text-white mb-1">{{ $faculty->name }}</h3>
                                <p class="text-sm text-[#F0B429] font-medium mb-3">{{ $department }} Faculty</p>
                                <p class="text-sm text-gray-400 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $faculty->email }}
                                 </p>
                            </div>
                            
                            <div class="bg-gray-800/20 p-4 border-t border-gray-700">
                                <a href="{{ route('appointments', ['faculty_id' => $faculty->id]) }}" class="w-full flex justify-center items-center px-4 py-2 bg-[#2BB3C0] border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-[#39C8D7] transition ease-in-out duration-150">
                                    Book Consultation
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>