<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight tracking-wide">
            {{ __('Edit Account: ') }} <span class="text-amber-500">{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 overflow-hidden shadow-2xl sm:rounded-lg p-8 border-t-4 border-amber-500">
                
                <div class="mb-8 border-b border-slate-700 pb-4">
                    <h3 class="text-xl font-black text-white">Update Account Details</h3>
                    <p class="text-sm text-slate-300 mt-1">Modify the information below to update this user's profile and permissions.</p>
                </div>

                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="name" :value="__('Full Name')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                        <x-text-input id="name" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="email" :value="__('Email Address')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                        <x-text-input id="email" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200" type="email" name="email" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="department" :value="__('Department (For Faculty Only)')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                        <select id="department" name="department" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200">
                            <option value="" {{ old('department', $user->department) == '' ? 'selected' : '' }}>Not Applicable (for Students/Admin)</option>
                            <option value="CEA" {{ old('department', $user->department) == 'CEA' ? 'selected' : '' }}>College of Engineering & Architecture (CEA)</option>
                            <option value="CITC" {{ old('department', $user->department) == 'CITC' ? 'selected' : '' }}>College of Information Technology & Computing (CITC)</option>
                            <option value="CSM" {{ old('department', $user->department) == 'CSM' ? 'selected' : '' }}>College of Science & Mathematics (CSM)</option>
                            <option value="COT" {{ old('department', $user->department) == 'COT' ? 'selected' : '' }}>College of Technology (COT)</option>
                            <option value="SHS" {{ old('department', $user->department) == 'SHS' ? 'selected' : '' }}>Senior High School (SHS)</option>
                            <option value="CSTE" {{ old('department', $user->department) == 'CSTE' ? 'selected' : '' }}>College of Science and Technology Education (CSTE)</option>
                            <option value="MED" {{ old('department', $user->department) == 'MED' ? 'selected' : '' }}>Medical Department (MED)</option>
                        </select>
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>
                    
                    <div class="mt-5">
                        <x-input-label for="role" :value="__('Account Role')" class="text-amber-500 font-bold uppercase text-xs tracking-wider" />
                        <select id="role" name="role" class="block mt-1 w-full bg-slate-800 border-slate-700 text-white focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 rounded-md shadow-sm transition-colors duration-200" required>
                            <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="faculty" {{ old('role', $user->role) == 'faculty' ? 'selected' : '' }}>Faculty / Teacher</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-5 border-t border-slate-700">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-slate-400 hover:text-white mr-5 transition-colors duration-150 uppercase tracking-wide">
                            Cancel
                        </a>
                        
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-amber-500 border border-transparent rounded-md font-extrabold text-xs text-slate-900 uppercase tracking-widest hover:bg-amber-400 focus:bg-amber-400 active:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition ease-in-out duration-150 shadow-md">
                            Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>