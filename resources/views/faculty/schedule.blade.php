<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faculty Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-medium mb-4">My Schedule</h3>
                    <p class="mb-6 text-gray-600">Welcome! Here you can manage your student appointments and class schedules.</p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Date & Time</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Student Name</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Purpose</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b text-sm text-gray-800">March 30, 2026 - 10:00 AM</td>
                                    <td class="py-3 px-4 border-b text-sm text-gray-800">Jane Doe</td>
                                    <td class="py-3 px-4 border-b text-sm text-gray-800">Project Consultation</td>
                                    <td class="py-3 px-4 border-b text-center">
                                        <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs">Pending</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>