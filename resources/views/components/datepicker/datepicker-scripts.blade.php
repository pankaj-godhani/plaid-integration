{{-- Scripts for datepickers
  Since the @include feature from Blade doesn't push to this 
  section for each time we invoke the component, we need
  to loop for each instance and render its own script.

  Loops for each "name" of each datepicker instance on
  the form.
  --}}
@push('additional-scripts')
  <script src="{{ mix('/js/flowbite/datepicker.js') }}"></script>
  <script>
    $(document).ready(() => {
      @foreach ($names as $name)
        $('input[name="{{ $name }}"]').on('changeDate', (e) => {
          @this.set("{{ $name }}", e.target.value);
        });
      @endforeach
    });
  </script>
@endpush