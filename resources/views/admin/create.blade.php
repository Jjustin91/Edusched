<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="department" :value="__('Department (For Faculty Only)')" class="text-blue-900 font-bold" />
                        <select id="department" name="department" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring-blue-900 rounded-md shadow-sm">
                            <option value="" selected>Not Applicable (for Students/Admin)</option>
                            <option value="CEA" {{ old('department') == 'CEA' ? 'selected' : '' }}>College of Engineering & Architecture (CEA)</option>
                            <option value="CITC" {{ old('department') == 'CITC' ? 'selected' : '' }}>College of Information Technology & Computing (CITC)</option>
                            <option value="CSM" {{ old('department') == 'CSM' ? 'selected' : '' }}>College of Science & Mathematics (CSM)</option>
                            <option value="COT" {{ old('department') == 'COT' ? 'selected' : '' }}>College of Technology (COT)</option>
                            <option value="SHS" {{ old('department') == 'SHS' ? 'selected' : '' }}>Senior High School (SHS)</option>
                            <option value="CSTE" {{ old('department') == 'CSTE' ? 'selected' : '' }}>College of Science and Technology Education (CSTE)</option>
                            <option value="MED" {{ old('department') == 'MED' ? 'selected' : '' }}>Medical Department (MED)</option>
                        </select>
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>
                    
                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Account Role')" />
                        <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="" disabled selected>Select a role...</option>
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="faculty" {{ old('role') == 'faculty' ? 'selected' : '' }}>Faculty / Teacher</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                            Cancel
                        </a>
                        <x-primary-button>
                            {{ __('Create Account') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>