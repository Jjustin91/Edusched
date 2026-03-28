<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-900 leading-tight">
            {{ __('Faculty Dashboard') }}
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
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-amber-500 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-blue-900">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="text-sm text-gray-600">Manage your student consultations and view your upcoming schedule.</p>
                </div>
            </div>

            <div x-data="{ activeTab: 'appointments' }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="border-b border-gray-200 bg-gray-50 flex">
                    <button @click="activeTab = 'appointments'" 
                            :class="{ 'border-b-2 border-amber-500 text-blue-900 font-bold bg-white': activeTab === 'appointments', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'appointments' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/2 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Appointments List
                    </button>
                    <button @click="activeTab = 'calendar'" 
                            :class="{ 'border-b-2 border-amber-500 text-blue-900 font-bold bg-white': activeTab === 'calendar', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'calendar' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/2 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Calendar View
                    </button>
                </div>

                <div class="p-6 text-gray-900">
                    
                    <div x-show="activeTab === 'appointments'" x-cloak>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Pending & Upcoming Consultations</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Date & Time</th>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Student Name</th>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Purpose</th>
                                        <th class="py-3 px-4 border-b text-center text-sm font-bold text-blue-900">Status</th>
                                        <th class="py-3 px-4 border-b text-center text-sm font-bold text-blue-900">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-4 border-b text-sm text-gray-800 font-medium">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y - h:i A') }}
                                            </td>
                                            
                                            <td class="py-3 px-4 border-b text-sm text-gray-600">{{ $appointment->student->name }}</td>
                                            <td class="py-3 px-4 border-b text-sm text-gray-600">{{ $appointment->purpose }}</td>
                                            
                                            <td class="py-3 px-4 border-b text-sm text-center">
                                                @if($appointment->status === 'pending')
                                                    <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-semibold uppercase tracking-wider">Pending</span>
                                                @elseif($appointment->status === 'approved')
                                                    <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-semibold uppercase tracking-wider">Approved</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-semibold uppercase tracking-wider">Declined</span>
                                                @endif
                                            </td>
                                            
                                            <td class="py-3 px-4 border-b text-sm text-center">
                                                @if($appointment->status === 'pending')
                                                    <form action="{{ route('faculty.appointments.status', $appointment->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="text-green-600 hover:text-green-900 font-bold mr-3 transition">Approve</button>
                                                    </form>
                                                    
                                                    <form action="{{ route('faculty.appointments.status', $appointment->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to decline this consultation?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="declined">
                                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold transition">Decline</button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 italic text-xs">No pending actions</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-sm text-gray-500 italic">No appointments scheduled yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="activeTab === 'calendar'" x-cloak style="display: none;">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">My Schedule</h3>
                            <button class="px-4 py-2 bg-blue-900 text-white rounded-md text-sm font-semibold hover:bg-blue-800 transition">Add Block-out Time</button>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-8 text-center bg-gray-50">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h4 class="text-lg font-medium text-gray-900">Interactive Calendar Ready</h4>
                            <p class="text-gray-500 mt-1 max-w-sm mx-auto">Once we set up the database, your approved appointments will automatically populate in a grid or list view here.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>