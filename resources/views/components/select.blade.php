<div class="mt-4 mb-4">
  <label for="{{ $name }}" class="block text-sm"> {{ $label }} </label>
  <select id="{{ $name }}" wire:model="{{ $name }}" name="{{ $name }}" class="focus:border-blue-400 focus:ring-blue-600 w-full rounded-md border px-4 py-2 text-sm focus:outline-none focus:ring-1">
    <option selected>Choose an option</option>
    @foreach ($items as $item)
      <option value="{{ $item["name"] }}" wire:key="{{ $name }}-{{ $item["name"] }}">{{ $item["name"] }}</option> 
    @endforeach
  </select>

  @if ($errors->has($name))
    <span class="text-primary">{{ $errors->first($name) }}</span>
  @endif
</div>
