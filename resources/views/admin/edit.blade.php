<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-900 leading-tight">
            {{ __('Edit Account: ') }} <span class="text-gray-600">{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-amber-500">
                
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PATCH') <div>
                        <x-input-label for="name" :value="__('Name')" class="text-blue-900 font-bold" />
                        <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring-blue-900" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" class="text-blue-900 font-bold" />
                        <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring-blue-900" type="email" name="email" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Account Role')" class="text-blue-900 font-bold" />
                        <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-blue-900 focus:ring-blue-900 rounded-md shadow-sm" required>
                            <option value="student" {{ (old('role', $user->role) == 'student') ? 'selected' : '' }}>Student</option>
                            <option value="faculty" {{ (old('role', $user->role) == 'faculty') ? 'selected' : '' }}>Faculty / Teacher</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-red-600 mr-4 font-medium transition duration-150">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-900 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Update Account') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>