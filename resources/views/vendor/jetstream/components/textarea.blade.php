@props(['value'])

<textarea {{ $attributes->merge(['class' => 'border rounded-md focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block font-medium text-sm text-gray-700', 'style' => 'height: auto; max-height: none;']) }}>
    {!! nl2br(e($value ?? $slot)) !!}
</textarea>