@props(['type'])
<span {{ $attributes->merge(['class' => 'text-gray-400 text-sm']) }}>
  {{ $type->getLabel() }}
</span>
