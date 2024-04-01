<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-gradient-danger']) }}>
    {{ $slot }}
</button>
