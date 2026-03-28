<x-app-layout>
    @php
        $calendarEvents = $appointments->filter(function($app) {
            return $app->status === 'approved';
        })->map(function($app) {
            return [
                'title' => 'Meeting with ' . $app->faculty->name,
                // Use strict formatting to ignore browser timezone shifts
                'start' => \Carbon\Carbon::parse($app->appointment_date)->format('Y-m-d\TH:i:s'),
                // Automatically make the calendar block 1 hour long
                'end' => \Carbon\Carbon::parse($app->appointment_date)->addHour()->format('Y-m-d\TH:i:s'),
                'backgroundColor' => '#f59e0b', // EduSched Amber
                'borderColor' => '#f59e0b',
                'textColor' => '#ffffff'
            ];
        })->values()->toJson();
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-900 leading-tight">
            {{ __('Student Dashboard') }}
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
                    <p class="text-sm text-gray-600">Book consultations with your faculty and manage your upcoming schedule.</p>
                </div>
            </div>

            <div x-data="{ activeTab: 'book' }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="border-b border-gray-200 bg-gray-50 flex">
                    <button @click="activeTab = 'book'" 
                            :class="{ 'border-b-2 border-amber-500 text-blue-900 font-bold bg-white': activeTab === 'book', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'book' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/3 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Book Consultation
                    </button>
                    
                    <button @click="activeTab = 'list'" 
                            :class="{ 'border-b-2 border-amber-500 text-blue-900 font-bold bg-white': activeTab === 'list', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'list' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/3 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        My Appointments
                    </button>
                    
                    <button @click="activeTab = 'calendar'" 
                            :class="{ 'border-b-2 border-amber-500 text-blue-900 font-bold bg-white': activeTab === 'calendar', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'calendar' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/3 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Calendar View
                    </button>
                </div>

                <div class="p-6 text-gray-900">
                    
                    <div x-show="activeTab === 'book'" x-cloak>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Request a New Appointment</h3>
                        
                        <form method="POST" action="{{ route('student.appointments.store') }}" class="max-w-2xl">
                            @csrf
                            
                            <div class="mb-4">
                                <x-input-label for="faculty_id" :value="__('Select Faculty Member')" class="text-blue-900 font-bold" />
                                <select id="faculty_id" name="faculty_id" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring-blue-900 rounded-md shadow-sm" required>
                                    <option value="" disabled selected>Choose a teacher...</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                            {{ $faculty->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('faculty_id')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="appointment_date" :value="__('Preferred Date & Time')" class="text-blue-900 font-bold" />
                                <x-text-input id="appointment_date" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring-blue-900" type="datetime-local" name="appointment_date" :value="old('appointment_date')" required />
                                <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                            </div>

                            <div class="mb-6">
                                <x-input-label for="purpose" :value="__('Purpose of Consultation')" class="text-blue-900 font-bold" />
                                <x-text-input id="purpose" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring-blue-900" type="text" name="purpose" :value="old('purpose')" placeholder="e.g., Thesis Chapter 1 Review, Project Setup" required />
                                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 transition ease-in-out duration-150">
                                    Submit Request
                                </button>
                            </div>
                        </form>
                    </div>

                    <div x-show="activeTab === 'list'" x-cloak style="display: none;">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Date & Time</th>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Faculty</th>
                                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-blue-900">Purpose</th>
                                        <th class="py-3 px-4 border-b text-center text-sm font-bold text-blue-900">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-4 border-b text-sm text-gray-800 font-medium">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y - h:i A') }}
                                            </td>
                                            <td class="py-3 px-4 border-b text-sm text-gray-600">{{ $appointment->faculty->name }}</td>
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
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-sm text-gray-500 italic">You have no upcoming appointments.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div x-show="activeTab === 'calendar'" 
                         x-init="$watch('activeTab', value => { if(value === 'calendar') { setTimeout(() => window.dispatchEvent(new Event('resize')), 50); } })"
                         x-cloak style="display: none;">
                        
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <div id="calendar"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            // Get the JSON data from PHP
            var eventsData = {!! $calendarEvents !!};

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek', 
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                slotMinTime: '07:00:00', 
                slotMaxTime: '19:00:00', 
                allDaySlot: false,       
                events: eventsData,      
                height: 'auto',
            });

            calendar.render();
        });
    </script>
</x-app-layout>