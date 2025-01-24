@extends('layouts.master') @section('title', 'Plaid Check')
@section('content')
<div class="flex justify-center">
  <div class="m-4" x-data>
    <div class="m-4 flex justify-center">
      <img width="300" alt="Logo" src="https://pay.mypayvantage.com/assets/images/company_logo.png" title="Logo" />
    </div>
    <div class="bg-gray-200 p-8 rounded-lg shadow-lg max-w-md">
      <div id="plaid_title">
        <div id="description" class="text-lg">
          <p class="mb-4">Looks like we need some more info.</p>
          <p class="mb-4">In order to further analyze your application we would like to confirm a few things with your bank. </p>
          <p>Please click the button below to get started!</p>
        </div>
        <p id="loadingText" class="text-lg hidden">Just a moment!</p>
        <p id="error" class="text-lg hidden">We were unable to instantly approve you. Please contact us directly to request a manual review.</p>
        <p id="smallerThanInvoice" class="text-lg hidden">The amount we automatically approved for your deal was $<span id="insufficientApproval"></span>
          <br>Unfortunately this does not cover the cost of the device you selected.
          <br> You can submit a request for a manual approval below or submit a new application for a device covered by your approval!
        </p>
      </div>
      <div id="success" class="text-lg hidden">
        <p class="mb-4">Thank you for linking your Account!</p>
        <p>You're approved <span id="firstName"></span>!</p>
        <div>
          <p class="mb-4">You have been approved for the amount of $<span id="approvalAmount"></span></p>
          <p>Today’s Payment: $<span id="today"></span></p>
          <p class="mb-4">Recurring Rent Payments: $<span id="recurring"></span></p>
        </div>
      </div>
      <div class="flex flex-col text-center items-center mt-8">
        <button type="button" id="bank_connect" class="p-3 text-lg text-white rounded-xl bg-purple-600 shadow-lg w-72 hover:bg-purple-500 flex items-center justify-center">
          <div class="hidden" id="loader">
            @include('components.loader')
          </div>
          <span>Connect your bank</span>
        </button>
        <a id="manualApproval" href="" class="p-3 text-lg text-white rounded-xl bg-purple-600 shadow-lg w-72 hover:bg-purple-500 flex items-center justify-center hidden">
          <button type="button">Request Manual Approval</button>
        </a>
        <a id="continue" href="{{ url('/initial-payment?deal_id=' . $deal_id . '&total=' . $total . '&products=' . $products) }}">
          <button id="initial_payment" class="p-3 text-lg text-white rounded-xl bg-purple-600 shadow-lg w-72 hover:bg-purple-500 flex items-center justify-center hidden" type="button">Continue to initial payment</button>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
@push('additional-scripts')
<script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>
<script>
  $(document).ready(() => {
    const dealId = "{{ $deal_id }}";
    const total = "{{ $total }}";
    const products = "{{ $products }}";
    const plaidOptions = {
      apiVersion: "{{ env('PLAID_API_VERSION') }}",
      clientName: "{{ env('PLAID_CLIENT_NAME') }}",
      env: "{{ env('PLAID_ENV') }}",
      webhook: "{{ env('PLAID_WEBHOOK') }}",
      product: ["assets", "transactions", "auth"],
      key: "{{ env('PLAID_API_KEY') }}",
      countryCodes: "{{ env('PLAID_COUNTRY_CODES') }}".split(','),
    };



    const handler = Plaid.create({

      ...plaidOptions,

      onSuccess: (public_token) => {

        $('#description').hide();

        $('#loadingText').show();

        $('#bank_connect span').html("Connecting...");

        $('#loader').show();

        $.post('/api/check-plaid-token', {

          public_token,

          dealId,

          total,

          products,

          action: "access_token"

        }).done((data) => {

          $('#loader').hide();

          $('#loadingText').hide();



          const amount = data.approvalAmount.toLocaleString(undefined, {

            minimumFractionDigits: 2,

            maximumFractionDigits: 2

          });

          const today = data.today.toLocaleString(undefined, {

            minimumFractionDigits: 2,

            maximumFractionDigits: 2

          });

          const recurring = data.recurring.toLocaleString(undefined, {

            minimumFractionDigits: 2,

            maximumFractionDigits: 2

          });



          console.log(data);



          // Send to shopify window

          if (window.opener) {

            window.opener.postMessage(dealId, '*');

          }



          if (data.approved) {

            $('#success').show();



            $('#firstName').html(data.firstName);

            $('#approvalAmount').html(amount);

            $('#today').html(today);

            $('#recurring').html(recurring);



            $('#initial_payment').show();

          } else {

            $('#description').hide();



            if (data.smaller_than_invoice) {

              if (amount == 0) {

                $('#error').show();

              } else {

                $('#smallerThanInvoice').show();

                $('#insufficientApproval').html(amount);

              }

            } else {

              $('#error').show();

            }



            $('#manualApproval').attr('href', `https://form.jotform.com/221537414898162?dealid=${dealId}&customerName[first]=${data.firstName}&customerName[last]=${data.lastName}&email=${data.email}`);

            $('#manualApproval').show();

          }

          $('#bank_connect').hide();

        }).fail(() => {

          alert("error");

        });

      },

    });



    $('#bank_connect').on('click', () => {

      handler.open();

    })

  });
</script>

@endpush