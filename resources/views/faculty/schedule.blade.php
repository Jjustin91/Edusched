<x-app-layout>
    @php
        $calendarEvents = $appointments->filter(function($app) {
            return $app->status === 'approved';
        })->map(function($app) {
            return [
                'title' => $app->student->name . ' - ' . $app->purpose,
                // Use strict formatting to ignore browser timezone shifts
                'start' => \Carbon\Carbon::parse($app->appointment_date)->format('Y-m-d\TH:i:s'),
                // Automatically make the calendar block 1 hour long
                'end' => \Carbon\Carbon::parse($app->appointment_date)->addHour()->format('Y-m-d\TH:i:s'),
                'backgroundColor' => '#2BB3C0', 
                'borderColor' => '#2BB3C0',
                'textColor' => '#ffffff'
            ];
        })->values()->toJson();
    @endphp
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Faculty Dashboard') }}
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
                    <p class="text-sm text-gray-400">Manage your student consultations and view your upcoming schedule.</p>
                </div>
            </div>

            <div x-data="{ activeTab: 'appointments' }" class="bg-[#1B263B] overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="border-b border-gray-700 bg-gray-800/20 flex">
                    <button @click="activeTab = 'appointments'" 
                            :class="{ 'border-b-2 border-[#F0B429] text-white font-bold bg-white/5': activeTab === 'appointments', 'text-gray-400 hover:text-white hover:bg-white/5': activeTab !== 'appointments' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/2 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Appointments List
                    </button>
                    <button @click="activeTab = 'calendar'" 
                            :class="{ 'border-b-2 border-[#F0B429] text-white font-bold bg-white/5': activeTab === 'calendar', 'text-gray-400 hover:text-white hover:bg-white/5': activeTab !== 'calendar' }"
                            class="py-4 px-6 text-sm font-medium focus:outline-none transition-colors duration-150 w-1/2 text-center">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Calendar View
                    </button>
                </div>

                <div class="p-6 text-gray-200">
                    
                    <div x-show="activeTab === 'appointments'" x-cloak>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-200">Pending & Upcoming Consultations</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-[#0D1B2A] border border-gray-700 rounded-lg">
                                <thead class="bg-gray-800/30">
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Date & Time</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Student Name</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-left text-sm font-bold text-white">Purpose</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-center text-sm font-bold text-white">Status</th>
                                        <th class="py-3 px-4 border-b border-gray-700 text-center text-sm font-bold text-white">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                        <tr class="hover:bg-white/5 transition duration-150">
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-gray-200 font-medium">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y - h:i A') }}
                                            </td>
                                            
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-gray-400">{{ $appointment->student->name }}</td>
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
                                            
                                            <td class="py-3 px-4 border-b border-gray-700 text-sm text-center">
                                                @if($appointment->status === 'pending')
                                                    <form action="{{ route('faculty.appointments.status', $appointment->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="text-green-400 hover:text-green-300 font-bold mr-3 transition">Approve</button>
                                                    </form>
                                                    
                                                    <form action="{{ route('faculty.appointments.status', $appointment->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to decline this consultation?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="declined">
                                                        <button type="submit" class="text-red-500 hover:text-red-400 font-bold transition">Decline</button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-500 italic text-xs">No pending actions</span>
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

                    <div x-show="activeTab === 'calendar'" 
                         x-init="$watch('activeTab', value => { if(value === 'calendar') { setTimeout(() => window.dispatchEvent(new Event('resize')), 50); } })"
                         x-cloak style="display: none;">
                        
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-200">My Schedule</h3>
                        </div>
                        
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