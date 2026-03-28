<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-900 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-md shadow-sm flex justify-between items-start">
                    <div>
                        <p class="font-bold text-sm uppercase tracking-wider mb-1">Success</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-900 text-xl font-bold leading-none focus:outline-none">
                        &times;
                    </button>
                </div>
            @endif
            
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex justify-between items-center border-l-4 border-amber-500">
                
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center space-x-4 w-2/3">
                    <div class="flex-grow">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search users by name or email..." 
                            class="w-full border-gray-300 focus:border-blue-900 focus:ring-blue-900 rounded-md shadow-sm">
                    </div>
                    
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 transition ease-in-out duration-150">
                        Search
                    </button>
                    @if($search)
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-red-600 hover:text-red-900 underline font-medium">Clear</a>
                    @endif
                </form>

                <div>
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-600 shadow-sm transition ease-in-out duration-150">
                        + Create Account
                    </a>
                </div>
            </div>

            <div x-data="{ activeTab: 'students' }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="border-b border-gray-200 bg-gray-50 flex">
                    <button @click="activeTab = 'students'" 
                            :class="{ 'border-b-2 border-amber-500 text-blue-900 font-bold bg-white': activeTab === 'students', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'students' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/2 text-center">
                        Registered Students
                    </button>
                    <button @click="activeTab = 'teachers'" 
                            :class="{ 'border-b-2 border-amber-500 text-blue-900 font-bold bg-white': activeTab === 'teachers', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'teachers' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/2 text-center">
                        Faculty & Teachers
                    </button>
                </div>

                <div class="p-6 text-gray-900">
                    
                    <div x-show="activeTab === 'students'" x-cloak>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Name</th>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Email</th>
                                        <th class="py-3 px-4 border-b text-center text-sm font-bold text-blue-900">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-4 border-b text-sm text-gray-800 font-medium">{{ $student->name }}</td>
                                            <td class="py-3 px-4 border-b text-sm text-gray-600">{{ $student->email }}</td>
                                            <td class="py-3 px-4 border-b text-sm text-center">
                                                <a href="{{ route('admin.users.edit', $student->id) }}" class="text-blue-600 hover:text-blue-900 font-medium mr-3">Edit</a>
                                                
                                                <form action="{{ route('admin.users.destroy', $student->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to completely delete this student account?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
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
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Name</th>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Email</th>
                                        <th class="py-3 px-4 border-b text-center text-sm font-bold text-blue-900">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($teachers as $teacher)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-4 border-b text-sm text-gray-800 font-medium">{{ $teacher->name }}</td>
                                            <td class="py-3 px-4 border-b text-sm text-gray-600">{{ $teacher->email }}</td>
                                            <td class="py-3 px-4 border-b text-sm text-center">
                                                <a href="{{ route('admin.users.edit', $teacher->id) }}" class="text-blue-600 hover:text-blue-900 font-medium mr-3">Edit</a>
                                                
                                                <form action="{{ route('admin.users.destroy', $teacher->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to completely delete this faculty account?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-8 text-center text-sm text-gray-500 italic">No faculty members found in the system.</td>
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