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
                'backgroundColor' => '#F0B429', // EduSched Amber
                'borderColor' => '#F0B429',
                'textColor' => '#0D1B2A'
            ];
        })->values()->toJson();
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Student Dashboard') }}
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

            <div class="mb-6 bg-[#1B263B] overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-[#F0B429] flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-white">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="text-sm text-gray-400">Book consultations with your faculty and manage your upcoming schedule.</p>
                </div>
            </div>

            <div x-data="{ activeTab: 'book' }" class="bg-[#1B263B] overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="border-b border-gray-700 bg-gray-800/20 flex">
                    <button @click="activeTab = 'book'" 
                            :class="{ 'border-b-2 border-[#F0B429] text-white font-bold bg-white/5': activeTab === 'book', 'text-gray-400 hover:text-white hover:bg-white/5': activeTab !== 'book' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/3 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Book Consultation
                    </button>
                    
                    <button @click="activeTab = 'list'" 
                            :class="{ 'border-b-2 border-[#F0B429] text-white font-bold bg-white/5': activeTab === 'list', 'text-gray-400 hover:text-white hover:bg-white/5': activeTab !== 'list' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/3 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        My Appointments
                    </button>
                    
                    <button @click="activeTab = 'calendar'" 
                            :class="{ 'border-b-2 border-[#F0B429] text-white font-bold bg-white/5': activeTab === 'calendar', 'text-gray-400 hover:text-white hover:bg-white/5': activeTab !== 'calendar' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/3 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Calendar View
                    </button>
                </div>

                <div class="p-6 text-gray-200">
                    
                    <div x-show="activeTab === 'book'" x-cloak>
                        <h3 class="text-lg font-bold text-gray-200 mb-4">Request a New Appointment</h3>
                        
                        <form method="POST" action="{{ route('student.appointments.store') }}" class="max-w-2xl">
                            @csrf
                            
                            <div class="mb-4">
                                <x-input-label for="faculty_id" :value="__('Select Faculty Member')" class="text-white font-bold" />
                                <select id="faculty_id" name="faculty_id" class="block mt-1 w-full bg-[#0D1B2A] border-gray-700 focus:border-[#F0B429] focus:ring-[#F0B429] rounded-md shadow-sm text-white" required>
                                    <option value="" disabled selected>Choose a teacher...</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" {{ (old('faculty_id') == $faculty->id || request('faculty_id') == $faculty->id) ? 'selected' : '' }}>
                                            {{ $faculty->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('faculty_id')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="appointment_date" :value="__('Preferred Date & Time')" class="text-white font-bold" />
                                <x-text-input id="appointment_date" class="block mt-1 w-full bg-[#0D1B2A] border-gray-700 focus:border-[#F0B429] focus:ring-[#F0B429] rounded-md shadow-sm text-white" type="datetime-local" name="appointment_date" :value="old('appointment_date')" required />
                                <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                            </div>

                            <div class="mb-6">
                                <x-input-label for="purpose" :value="__('Purpose of Consultation')" class="text-white font-bold" />
                                <x-text-input id="purpose" class="block mt-1 w-full bg-[#0D1B2A] border-gray-700 focus:border-[#F0B429] focus:ring-[#F0B429] rounded-md shadow-sm text-white" type="text" name="purpose" :value="old('purpose')" placeholder="e.g., Thesis Chapter 1 Review, Project Setup" required />
                                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#2BB3C0] border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-[#39C8D7] focus:bg-[#39C8D7] active:bg-[#2BB3C0] transition ease-in-out duration-150">
                                    Submit Request
                                </button>
                            </div>
                        </form>
                    </div>

                    <div x-show="activeTab === 'list'" x-cloak style="display: none;">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-[#0D1B2A] border border-gray-700 rounded-lg">
                                <thead class="bg-gray-800/30">
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Date & Time</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Faculty</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Purpose</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-center text-sm font-bold text-white">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                        <tr class="hover:bg-white/5 transition duration-150">
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-gray-200 font-medium">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y - h:i A') }}
                                            </td>
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-gray-400">{{ $appointment->faculty->name }}</td>
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-gray-400">{{ $appointment->purpose }}</td>
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-center">
                                                @if($appointment->status === 'pending')
                                                    <span class="bg-yellow-400/10 text-yellow-300 py-1 px-3 rounded-full text-xs font-semibold uppercase tracking-wider">Pending</span>
                                                @elseif($appointment->status === 'approved')
                                                    <span class="bg-green-400/10 text-green-300 py-1 px-3 rounded-full text-xs font-semibold uppercase tracking-wider">Approved</span>
                                                @else
                                                    <span class="bg-red-400/10 text-red-300 py-1 px-3 rounded-full text-xs font-semibold uppercase tracking-wider">Declined</span>
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
                        
                        <div class="bg-[#0D1B2A] border border-gray-700 rounded-lg p-6 shadow-sm">
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
                // Theme related properties
                dayHeaderClassNames: 'bg-gray-800/30 text-white font-bold',
                viewClassNames: 'bg-transparent',
                eventClassNames: 'hover:opacity-80',
                nowIndicatorClassNames: 'bg-red-500',
                slotLabelClassNames: 'text-gray-400',
                dayCellClassNames: 'border-gray-700',
                dayHeaderContent: function(arg) {
                    return { html: `<span class="text-white">${arg.text}</span>` };
                },
                slotLabelContent: function(arg) {
                    return { html: `<span class="text-gray-400">${arg.text}</span>` };
                },
                viewDidMount: function(view) {
                    calendarEl.querySelectorAll('.fc-col-header-cell-cushion').forEach(el => el.style.color = 'white');
                    calendarEl.querySelectorAll('.fc-toolbar-title').forEach(el => el.style.color = 'white');
                    calendarEl.querySelectorAll('.fc-button').forEach(el => { 
                        el.style.backgroundColor = '#2BB3C0';
                        el.style.color = 'white';
                        el.style.border = 'none';
                    });
                }
            });

            calendar.render();
        });
    </script>
</x-app-layout>