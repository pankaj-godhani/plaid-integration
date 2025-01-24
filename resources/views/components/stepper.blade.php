<div>
  <ul class="flex flex-row justify-between">
    @for ($i = 1; $i < $stepCount + 1; $i++)
      <li wire:click="gotoStep({{ $i }})" class="text-center {{ $currentStep >= $i ? "bg-red-400" : "bg-gray-200"}} rounded-2xl w-7 h-7 my-2 cursor-pointer font-bold border-2 border-black border-solid">
        {{ $i }}
      </li>
    @endfor
  </ul>
  <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
    <div class="bg-primary h-2.5 rounded-full dark:bg-gray-300" style="width: {{ (($currentStep - 1) / $stepCount * 100) + 4 * $currentStep }}%"></div>
  </div>
</div>