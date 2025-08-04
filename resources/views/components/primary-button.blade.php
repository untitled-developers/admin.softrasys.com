<button {{ $attributes->merge(['type' => 'submit', 'class' => 'cursor-pointer inline-flex items-center px-4 py-2 text-sm bg-pink-700 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest active:bg-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>

    {{ $slot }}

</button>
