<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#16324F] overflow-hidden shadow-xl sm:rounded-lg border border-white/10 p-6 text-[#BCCCDC]">
                
                <h3 class="text-xl font-bold mb-4 text-white">Upcoming Appointments</h3>
                
                @if($appointments->isEmpty())
                    <p>You have no appointments scheduled at this time.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($appointments as $appointment)
                            <li class="bg-[#102A43] p-3 rounded-md border border-white/5">
                                Appointment ID: {{ $appointment->id }}
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>

</x-app-layout>