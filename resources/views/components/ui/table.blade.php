<div {{ $attributes->merge(['class' => 'table-responsive']) }}>
    <table class="table">
        {{ $slot }}
    </table>
</div>
