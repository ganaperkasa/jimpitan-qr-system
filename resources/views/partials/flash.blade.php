@if (session('sukses'))
    <div role="status" class="flex items-start gap-3 rounded-2xl border border-mint/40 bg-mint/10 p-3.5 text-sm font-semibold text-mint">
        <x-icon name="check" class="mt-0.5 size-5 shrink-0" />
        <span>{{ session('sukses') }}</span>
    </div>
@endif

@if (session('galat'))
    <div role="alert" class="flex items-start gap-3 rounded-2xl border border-blush/40 bg-blush/10 p-3.5 text-sm font-semibold text-blush">
        <x-icon name="alert" class="mt-0.5 size-5 shrink-0" />
        <span>{{ session('galat') }}</span>
    </div>
@endif
