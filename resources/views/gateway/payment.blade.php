@extends('layouts.master') @section('title', 'Checkout')

@section('content')
<div class="flex justify-center">
  <div class="m-8">
    <div class="m-8">
      <img
        alt="Logo"
        class="w-96"
        src="https://pay.mypayvantage.com/assets/images/company_logo.png"
        title="Logo" />
    </div>

    <div class="bg-gray-200 p-8 rounded-lg shadow-lg max-w-md flex flex-col justify-center items-center">
      <p class="mb-7 text-lg">Initial payment amount: ${{ $amount }}</p>
      <!-- device info -->
      <p class="mb-7 text-lg">for </p>
      <p class="mb-8 text-lg" id="product_details"></p>
      <form id="payment-form" class="max-w-xs justify-center">
        <div id="card-element" class="flex flex-col">
          <div class="flex flex-col">
            <label for="number">Credit card number</label>
            <input required class="rounded" name="number" type="text" placeholder="1234 1234 1234 1234">
            <p class="error mt-0 mb-3 text-red-600"></p>
          </div>
          <div class="flex flex-col">
            <label for="exp">Expiration</label>
            <input required class="rounded" name="exp" type="text" placeholder="MM / YYYY">
            <p class="error mt-0 mb-3 text-red-600"></p>
          </div>
          <div class="flex flex-col">
            <label for="cvc">CVC</label>
            <input required class="rounded" name="cvc" type="text" placeholder="CVC">
            <p class="error mt-0 mb-3 text-red-600"></p>
          </div>
        </div>
        <button class=" mt-8 p-3 text-lg text-white rounded-xl bg-purple-600 shadow-lg w-72 hover:bg-purple-500 flex items-center justify-center" id="submit">
          <div class="hidden" id="loader">
            @include('components.loader')
          </div>
          <span class="submit-text">Submit</span>
        </button>
        <p class="text-center text-red-600 mt-4" id="error-message"></p>
      </form>
    </div>
  </div>
</div>

@endsection

@push('additional-scripts')
<script src="{{ url('/vendor/jquery.mask.min.js') }}"></script>
<script>
  window.onload = function() {
    const params = new Proxy(new URLSearchParams(window.location.search), {
      get: (searchParams, prop) => searchParams.get(prop),
    });
    let product = params.products.slice(2, -2).replace(/_/g, ' ').split("/");
    document.getElementById('product_details').innerHTML = product[0] + " - " + product[1];
  }
    $(document).ready(() => {
      const number = $('input[name="number"]');
      const exp = $('input[name="exp"]');
      const cvc = $('input[name="cvc"]');
      
      // Masking format for the form.
      number.mask('9999 9999 9999 9999');
      exp.mask('99/9999');
      cvc.mask('9999');

      $('#payment-form').on('submit', async (event) => {
        event.preventDefault();

        $('#loader').show();
        $('.submit-text').hide();
        $('#submit').prop('disabled', true);

        // Remove error validation styles.
        $('#error-message').text("");
        $('input').removeClass("border-red-500");
        $('.error').text("");

        const expiration = exp.val().split('/');

        $.post("{{ route('charge_card') }}", {
          number: (number.val()).replace(/\s/g, ''),
          expMonth: expiration[0], 
          expYear: expiration[1], 
          cvc: cvc.val(),
          deal_id: "{{ $deal_id }}",
          total: "{{ $total }}",
        })
        // onSuccess
        .done(() => {
          // Redirect to success page.
          window.open(
            "{{ route('success', ['deal_id' => $deal_id, 'total' => $total, 'products' => $products]) }}".replace(/&amp;/g, "&"),
            "_self"
          );
        })
        // onError
        .fail((xhr, status, error) => {
          const validationErrors = xhr.responseJSON?.errors;

          if (validationErrors) {
            for (const entry of Object.entries(validationErrors)) {
              let input = $(`input[name="${entry[0]}"]`);
              if (entry[0] === 'expMonth' | entry[0] === 'expYear') {
                input = $(`input[name="exp"]`);
              }
              input.addClass("border-red-500");
              input.next().text(entry[1]);
            }
          } else {
            $('#error-message').text(xhr.responseJSON?.message);
          }
        })
        // onDefault
        .always(() => {
          $('#loader').hide();
          $('.submit-text').show();
          $('#submit').prop('disabled', false)
        });
      });
    });
  </script>
@endpush
