<?php extract(collect($attributes->getAttributes())->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>

<x-student-layout  {{ $attributes }}>
<x-slot name="title" >{{ $title }}</x-slot>
{{ $slot ?? "" }}
</x-student-layout>