@extends('layouts.master') @section('title', "Sorry, we can't approve you")
@section('content')
<div class="flex flex-col items-center justify-center bg-background-primary mt-12">
  <div class="mt-8">
    <img
      alt="Logo"
      class="w-96"
      src="https://pay.mypayvantage.com/assets/images/company_logo.png"
      title="Logo" />
  </div>
  <div class="bg-gray-200 p-8 rounded-lg shadow-lg max-w-md m-8 flex flex-col items-center justify-center">
    <img class="object-contain h-44 w-44" src="{{ asset('img/denied.png') }}" />
    <div class="text-center mt-2">
      <p class="text-xl font-bold">Sorry!</p>
      <p class="text-lg mt-2">We can't approve you</p>
    </div>
  </div>
</div>
@endsection


@push('additional-scripts')
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    $(document).ready(() => {
      if (window.opener) {
        window.opener.postMessage("checkout", '*');
      }
    });
  </script>
@endpush
