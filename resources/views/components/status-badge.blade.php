@props(['status'])

@php
    $labels = [
        'available' => 'Disponible',
        'reserved' => 'Reserve',
        'sold' => 'Vendu',
    ];

    $classes = [
        'available' => 'border border-emerald-200 bg-emerald-50 text-emerald-700',
        'reserved' => 'border border-amber-200 bg-amber-50 text-amber-700',
        'sold' => 'border border-stone-300 bg-stone-100 text-stone-700',
    ];

    $label = $labels[$status] ?? ucfirst((string) $status);
    $className = $classes[$status] ?? 'bg-stone-100 text-stone-700 border border-stone-200';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-3 py-1.5 text-[11px] font-semibold uppercase tracking-[0.18em] $className"]) }}>
    {{ $label }}
</span>
