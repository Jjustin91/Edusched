<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight tracking-wide">
            {{ __('Create New Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 overflow-hidden shadow-2xl sm:rounded-lg p-8 border-t-4 border-amber-500">
                
                <div class="mb-8 border-b border-slate-700 pb-4">
                    <h3 class="text-xl font-black text-white">Account Details</h3>
                    <p class="text-sm text-slate-300 mt-1">Enter the information below to register a new student or faculty member to the system.</p>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Full Name')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                        <x-text-input id="name" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="email" :value="__('Email Address')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                        <x-text-input id="email" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="department" :value="__('Department (For Faculty Only)')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                        <select id="department" name="department" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200">
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
                    
                    <div class="mt-5">
                        <x-input-label for="role" :value="__('Account Role')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                        <select id="role" name="role" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200" required>
                            <option value="" disabled selected>Select a role...</option>
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="faculty" {{ old('role') == 'faculty' ? 'selected' : '' }}>Faculty / Teacher</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                            <x-text-input id="password" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200" type="password" name="password_confirmation" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-5 border-t border-slate-700">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-slate-400 hover:text-white mr-5 transition-colors duration-150 uppercase tracking-wide">
                            Cancel
                        </a>
                        
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-amber-500 border border-transparent rounded-md font-extrabold text-xs text-slate-900 uppercase tracking-widest hover:bg-amber-400 focus:bg-amber-400 active:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition ease-in-out duration-150 shadow-md">
                            Create Account
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>