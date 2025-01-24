@php
    $email = $isEmail ?? false
@endphp

<div class="mt-4 mb-4">
  <label class="block text-sm"> {{ $label }} </label>
  <input
    type="{{$email ? "email" : "text"}}"
    class="focus:border-blue-400 focus:ring-blue-600 w-full rounded-md border px-4 py-2 text-sm focus:outline-none focus:ring-1"
    wire:model.defer="{{ $name }}"
    name="{{ $name }}"
    placeholder="{{ $label }}"
  />
  @if ($errors->has($name))
    <span class="text-primary">{{ $errors->first($name) }}</span>
  @endif
</div>
