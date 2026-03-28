<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#415A77] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#5A7A9A] focus:bg-[#5A7A9A] active:bg-[#1B263B] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
