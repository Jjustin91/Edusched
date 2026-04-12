<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 bg-green-500/10 border-l-4 border-green-500 text-green-300 p-4 rounded-md shadow-sm flex justify-between items-start">
                    <div>
                        <p class="font-bold text-sm uppercase tracking-wider mb-1">Success</p>

                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-300 hover:text-white text-xl font-bold leading-none focus:outline-none">
                        &times;
                    </button>
                </div>
            @endif
            
            <div class="mb-6 bg-[#1B263B] overflow-hidden shadow-sm sm:rounded-lg p-6 flex justify-between items-center border-l-4 border-[#F0B429]">
                
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center space-x-4 w-2/3">
                    <div class="flex-grow">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search users by name or email..." 
                            class="w-full bg-[#0D1B2A] border-gray-700 focus:border-[#F0B429] focus:ring-[#F0B429] rounded-md shadow-sm text-white">
                    </div>
                    
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#2BB3C0] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#39C8D7] transition ease-in-out duration-150">
                        Search
                    </button>
                    @if($search)
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-red-400 hover:text-red-300 underline font-medium">Clear</a>
                    @endif
                </form>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.users.pdf') }}" class="inline-flex items-center px-4 py-2 bg-[#2BB3C0] border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-[#39C8D7] shadow-sm transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Export PDF
                    </a>

                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-[#F0B429] border border-transparent rounded-md font-bold text-xs text-[#0D1B2A] uppercase tracking-widest hover:bg-[#FFC74D] shadow-sm transition ease-in-out duration-150">
                        + Create Account
                    </a>
                </div>
            </div>

            <div x-data="{ activeTab: localStorage.getItem('adminTab') || 'students' }" 
                x-init="$watch('activeTab', val => localStorage.setItem('adminTab', val))" 
                class="bg-[#1B263B] overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="border-b border-gray-700 bg-gray-800/20 flex">
                    <button @click="activeTab = 'students'" 
                            :class="{ 'border-b-2 border-[#F0B429] text-white font-bold bg-white/5': activeTab === 'students', 'text-gray-400 hover:text-white hover:bg-white/5': activeTab !== 'students' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/2 text-center">
                        Registered Students
                    </button>
                    <button @click="activeTab = 'teachers'" 
                            :class="{ 'border-b-2 border-[#F0B429] text-white font-bold bg-white/5': activeTab === 'teachers', 'text-gray-400 hover:text-white hover:bg-white/5': activeTab !== 'teachers' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/2 text-center">
                        Faculty & Teachers
                    </button>
                </div>

                <div class="p-6 text-gray-200">
                    
                    <div x-show="activeTab === 'students'" x-cloak>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-[#0D1B2A] border border-gray-700 rounded-lg">
                                <thead class="bg-gray-800/30">
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Name</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Email</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-center text-sm font-bold text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr class="hover:bg-white/5 transition duration-150">
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-gray-200 font-medium">{{ $student->name }}</td>
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-gray-400">{{ $student->email }}</td>
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-center">
                                                <a href="{{ route('admin.users.edit', $student->id) }}" class="text-[#39C8D7] hover:text-[#2BB3C0] font-medium mr-3">Edit</a>
                                                
                                                <form action="{{ route('admin.users.destroy', $student->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to completely delete this student account?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-400 font-medium">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-8 text-center text-sm text-gray-500 italic">No students found in the system.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $students->appends(['search' => $search])->links() }}
                        </div>
                    </div>

                    <div x-show="activeTab === 'teachers'" x-cloak style="display: none;">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-[#0D1B2A] border border-gray-700 rounded-lg">
                                <thead class="bg-gray-800/30">
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Name</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Department</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Email</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-center text-sm font-bold text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($teachers as $teacher)
                                        <tr class="hover:bg-white/5 transition duration-150">
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-gray-200 font-medium">{{ $teacher->name }}</td>
                                            
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm font-bold text-[#F0B429]">
                                                {{ $teacher->department ?? 'N/A' }}
                                            </td>
                                            
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-gray-400">{{ $teacher->email }}</td>
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-center">
                                                <a href="{{ route('admin.users.edit', $teacher->id) }}" class="text-[#39C8D7] hover:text-[#2BB3C0] font-medium mr-3">Edit</a>
                                                
                                                <form action="{{ route('admin.users.destroy', $teacher->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to completely delete this faculty account?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-400 font-medium">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-sm text-gray-500 italic">No faculty members found in the system.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $teachers->appends(['search' => $search])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>