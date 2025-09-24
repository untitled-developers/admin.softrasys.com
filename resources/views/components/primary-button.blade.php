<button {{ $attributes->merge(['type' => 'submit', 'class' => 'cursor-pointer inline-flex items-center px-4 py-2 text-sm bg-[#502376] border border-transparent rounded-md font-semibold text-white uppercase tracking-widest active:bg-[#9754D1] focus:outline-none focus:ring-2 focus:ring-[#7A37B3] focus:ring-offset-2 transition ease-in-out duration-150']) }}>

    {{ $slot }}

</button>
