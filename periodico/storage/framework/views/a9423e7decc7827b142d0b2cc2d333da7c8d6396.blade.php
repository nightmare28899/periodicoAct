<?php extract(collect($attributes->getAttributes())->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['href','xOn:click.prevent'])
<x-jet-responsive-nav-link :href="$href" :x-on:click.prevent="$xOnClickPrevent" >

{{ $slot ?? "" }}
</x-jet-responsive-nav-link>