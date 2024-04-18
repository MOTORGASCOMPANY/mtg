@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 font-semibold font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 border-l-4  border-indigo-500 transition select-none'
            : 'block pl-3 pr-4 py-2 hover:border-l-4  font-semibold bg-gray-400 font-medium hover:text-gray-500 hover:bg-gray-200 hover:border-gray-600 outline-none transition select-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
