@props(['status'])

@php($definition = \App\Support\DemoData::statuses()[$status] ?? ['label' => $status, 'color' => 'slate'])

<x-badge :color="$definition['color']" dot {{ $attributes }}>{{ $definition['label'] }}</x-badge>
