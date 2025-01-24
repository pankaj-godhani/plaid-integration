@extends('layouts.master') @section('title', 'Thank you!')
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
    <img class="object-contain h-24 w-24" src="{{ asset('img/success.png') }}" />
    <p class="text-center text-xl my-4">Success!</p>
    <div class="text-center">
      <p>Click the button below to continue your purchase.</p>
      <p>Thank you for choosing Payvantage!</p>
    </div>
    <button class="p-3 text-lg text-white rounded-xl bg-purple-600 shadow-lg w-72 hover:bg-purple-500 flex items-center justify-center" 
      onclick="window.location.href = 'https://smartimobile.com/cart?checkout=true' ;">Click Here</button>
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
