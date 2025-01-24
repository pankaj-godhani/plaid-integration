<div class="flex min-h-screen items-center bg-gray">
  <div
    class="mx-6 h-full max-w-4xl flex-1 rounded-lg bg-white shadow-xl lg:mx-auto"
  >
    <div class="flex flex-col md:flex-row">
      <div class="h-32 md:h-auto md:w-1/2">
        <img
          class="h-full w-full rounded-t-lg object-cover md:rounded-l-lg md:rounded-r-none lg:w-auto lg:object-cover"
          src="img/logo.jpg"
          alt="Payvantage"
        />
      </div>
      <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
        <div class="w-full">
          <h3 class="mb-4 text-center text-xl font-bold">
              Welcome to Payvantage Lease Application
          </h3>
          

          @include('components.stepper', [
            'stepCount' => 6,
            'currentStep' => $step,
          ])
          <!--<div>-->
          <!--      <div style="display: flex; justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index: 9999; width: 100%; height: 100%; opacity: .75;">-->
          <!--          <div style="color: #edb948" class="la-ball-spin-clockwise la-2x">-->
          <!--              <div></div>-->
          <!--              <div></div>-->
          <!--              <div></div>-->
          <!--              <div></div>-->
          <!--              <div></div>-->
          <!--              <div></div>-->
          <!--              <div></div>-->
          <!--              <div></div>-->
          <!--          </div>-->
          <!--      </div>-->
          <!--  </div>-->
          
          <!--<div class="h-96">-->
          <!--    <div class="{{ $step != 1 ? "hidden" : "" }}">-->
                <!--<p>We will need some information from you in order to approve your request.</p><br>-->
          <!--      <p><b>Already approved for a lease? Look it up!</b></p>-->
          <!--      <p>Enter your approval ID below to look up your lease.</p>-->
          <!--      @include('components.basic-input', ['name' => 'approvalID', 'label' => "Enter your Approval ID"])-->
          <!--      <button-->
          <!--        class="border-black mt-4 rounded-lg border px-6 py-2 text-center text-sm font-medium transition-colors duration-150 focus:outline-none"-->
          <!--        style="float: right; cursor: pointer;"-->
          <!--        wire:click="submitApprovalID"-->
          <!--        id="submitButton"-->
          <!--      >-->
          <!--          <span wire:loading.remove>Look Up My Lease</span>-->
          <!--          <span wire:loading>Loading...</span>-->
          <!--      </button>-->
          <!--      @if($showMessage == True)-->
          <!--        <div id="messageDiv">-->
          <!--          <p style="color:red">Your lease does not exists, please continue by clicking 'Apply Now' with rest of your application.</P>-->
          <!--        </div>-->
          <!--      @endif-->
          <!--    </div>-->
          <!--    <div class="{{ $step != 1 ? "hidden" : "" }}">-->
          <!--        <hr style="border: 1px solid black;"><br>-->
          <!--        <p>If you do not have a lease with PayVantage.</p><br>-->
          <!--        <p>Click apply now to continue with your application.</p>-->
          <!--    </div>-->
          <!--</div>-->
          
          <!--<div class="{{ $step != 1 ? "hidden" : "" }}">-->
          <!--  <p>Welcome to Payvantage! We will need some information from you in order to approve your request.</p><br>-->
          <!--  <p>If you already have an approval, please enter your approval ID below or click next to submit an application.</p>-->
          <!--  @include('components.basic-input', ['name' => 'approvalID', 'label' => "Enter your Approval ID"])-->
          <!--  <button-->
          <!--    style="float: right; border: 1px solid black; border-radius: 0.5rem; padding: 0.5rem 1.5rem; text-align: center; font-size: 0.875rem; font-weight: 500; line-height: 1.25; transition: color 150ms; outline: none;"-->
          <!--    wire:click="submitApprovalID"-->
          <!--  >-->
          <!--    Submit-->
          <!--  </button>-->
          <!--  @if($showMessage == True)-->
          <!--    <div id="messageDiv">-->
          <!--      <p style="color:red">Your approval ID does not exists, please continue by clicking 'next' with the rest of the application.</P>-->
          <!--    </div>-->
          <!--  @endif-->
          <!--  <hr style="border: 1px solid black;"><br>-->
          <!--  <p>Test line</p>-->
          <!--</div>-->
          <div class="{{ $step != 1 ? "hidden" : "" }}">
            <!--<p>Welcome to Payvantage! We will need some information from you in order to approve your request.</p><br>-->
            <p><b>Already approved for a lease? Look it up!</b></p>
            <p>Enter your approval ID below to look up your lease.</p>
            @include('components.basic-input', ['name' => 'approvalID', 'label' => "Enter your Approval ID"])
            <button
              style="border: 1px solid black; border-radius: 0.5rem; padding: 0.5rem 1.5rem; text-align: center; font-size: 0.875rem; font-weight: 500; line-height: 1.25; transition: color 150ms; outline: none;"
              wire:click="submitApprovalID"
            >
              Look Up My Lease
            </button>
            <br><br>
            @if($showMessage == True)
              <div id="messageDiv">
                <p style="color:red">Looks like your lease does not exist, continue by clicking 'Apply Now' with rest of your application.</P>
              </div>
            @endif
            
            <hr style="border: 1px solid black; "><br>
            <p><b>Not approved for a Lease?</b></p>
            <p>Click <b>Apply Now</b> to apply for a lease with PayVantage.</p>
          </div>

          <div class="{{ $step != 2 ? "hidden" : "" }}">
            @include('components.basic-input', ['name' => 'firstName', 'label' => "First Name"])
            @include('components.basic-input', ['name' => 'lastName', 'label' => "Last Name"])
            @include('components.basic-input', ['name' => 'email', 'label' => "Email", 'isEmail' => true])
            @include('components.basic-input', ['name' => 'phone', 'label' => "Cell Phone Number"])
            @include('components.datepicker.datepicker', ['name' => 'dob', 'label' => "Date of Birth"])
          </div>

          <div class="{{ $step != 3 ? "hidden" : "" }} h-96">
            @include('components.basic-input', ['name' => 'street', 'label' => "Street"])
            @include('components.basic-input', ['name' => 'city', 'label' => "City"])
            @include('components.select', ['name' => 'state', 'label' => "State", 'items' => $states])
            @include('components.basic-input', ['name' => 'zipcode', 'label' => "Zipcode"])
          </div>

          <div class="{{ $step != 4 ? "hidden" : "" }} h-96">
            @include('components.basic-input', ['name' => 'ssn', 'label' => "Social Security Number"])
            @include('components.select', ['name' => 'sourceOfIncome', 'label' => "Source of Income", "items" => $incomeSources])
          </div>

          <div class="{{ $step != 5 ? "hidden" : "" }}">
            @include('components.basic-input', ['name' => 'employerName', 'label' => "Employer Name"])
            @include('components.basic-input', ['name' => 'employerStreet', 'label' => "Employer's street"])
            @include('components.basic-input', ['name' => 'employerCity', 'label' => "Employer's city"])
            @include('components.select', ['name' => 'employerState', 'label' => "Employer's state", 'items' => $states])
            @include('components.basic-input', ['name' => 'employerZipcode', 'label' => "Employer's zipcode"])
            @include('components.basic-input', ['name' => 'employerPhone', 'label' => "Employer's phone"])
          </div>

          <div class="{{ $step != 6 ? "hidden" : "" }} h-96">
            @include('components.select', ['name' => 'paidFrequency', 'label' => "How often do you get paid?", "items" => $paymentFrequencies])
            @include('components.datepicker.datepicker', ['name' => 'nextPayday', 'label' => "Next Payday"])
            @include('components.yes-no-select', ['name' => 'directDeposit', 'label' => "Is your Paycheck direct deposited into your bank account?"])
            @include('components.basic-input', ['name' => 'bankName', 'label' => "What Bank is you Paycheck direct deposited into?"])
          </div>

          <div class="flex {{ $step > 1 ? "justify-between" : "justify-end" }}">
            @if($step > 1)
              <div class="flex justify-start">
                <button
                  class="border-black border-transparent mt-4 rounded-lg border px-6 py-2 text-center text-sm font-medium leading-5  duration-150 focus:outline-none"
                  wire:click.prevent="previousStep"
                >
                  Back
                </button>
              </div>  
            @endif
            
            @if($step == 1)
              <div class="flex justify-end">
                <button
                  class="border-black mt-4 rounded-lg border px-6 py-2 text-center text-sm font-medium leading-5 transition-colors duration-150 focus:outline-none"
                  wire:click.prevent="nextStep({{ $step }})"
                >
                  Apply Now
                </button>
              </div>
            @elseif($step < 6 && $step > 1)
              <div class="flex justify-end">
                <button
                  class="border-black mt-4 rounded-lg border px-6 py-2 text-center text-sm font-medium leading-5 transition-colors duration-150 focus:outline-none"
                  wire:click.prevent="nextStep({{ $step }})"
                >
                  Next
                </button>
              </div>
            @else
            <div class="flex justify-end">
              <button
                class="border-black mt-4 rounded-lg border px-6 py-2 text-center text-sm font-medium leading-5 transition-colors duration-150 focus:outline-none"
                wire:click.prevent="submitForm"
                >
                Submit
              </button>
            </div>
            @endif
            <!--@if($step < 6)-->
            <!--  <div class="flex justify-end">-->
            <!--    <button-->
            <!--      class="border-black mt-4 rounded-lg border px-6 py-2 text-center text-sm font-medium leading-5 transition-colors duration-150 focus:outline-none"-->
            <!--      wire:click.prevent="nextStep({{ $step }})"-->
            <!--    >-->
            <!--      Next-->
            <!--    </button>-->
            <!--  </div>-->
            <!--@endif-->
            <!--@if($step == 6)-->
            <!--<div class="flex justify-end">-->
            <!--  <button-->
            <!--    class="border-black mt-4 rounded-lg border px-6 py-2 text-center text-sm font-medium leading-5 transition-colors duration-150 focus:outline-none"-->
            <!--    wire:click.prevent="submitForm"-->
            <!--    >-->
            <!--    Submit-->
            <!--  </button>-->
            <!--</div>-->
            <!--@endif-->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include(
  'components.datepicker.datepicker-scripts',
  [
    'names' => [
      'dob',
      'nextPayday'
    ]
  ]
)

@push('additional-scripts')
<script src="{{ url('/vendor/jquery.mask.min.js') }}"></script>
<script>
$(document).ready(() => {
  $('input[name="ssn"]').mask('999-99-9999');
});

if($showMessage) {
  document.getElementById('messageDiv').style.visibility = "visible";
}

$("submitButton").on("click", function(e) {
    console.log("inside submit button function");
});
</script>
<!--<style>-->
    /*!
     * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
     * Copyright 2015 Daniel Cardoso <@DanielCardoso>
     * Licensed under MIT
     */
<!--    .la-ball-spin-clockwise,-->
<!--    .la-ball-spin-clockwise > div {-->
<!--        position: relative;-->
<!--        -webkit-box-sizing: border-box;-->
<!--           -moz-box-sizing: border-box;-->
<!--                box-sizing: border-box;-->
<!--    }-->
<!--    .la-ball-spin-clockwise {-->
<!--        display: block;-->
<!--        font-size: 0;-->
<!--        color: #fff;-->
<!--    }-->
<!--    .la-ball-spin-clockwise.la-dark {-->
<!--        color: #333;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div {-->
<!--        display: inline-block;-->
<!--        float: none;-->
<!--        background-color: currentColor;-->
<!--        border: 0 solid currentColor;-->
<!--    }-->
<!--    .la-ball-spin-clockwise {-->
<!--        width: 32px;-->
<!--        height: 32px;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div {-->
<!--        position: absolute;-->
<!--        top: 50%;-->
<!--        left: 50%;-->
<!--        width: 8px;-->
<!--        height: 8px;-->
<!--        margin-top: -4px;-->
<!--        margin-left: -4px;-->
<!--        border-radius: 100%;-->
<!--        -webkit-animation: ball-spin-clockwise 1s infinite ease-in-out;-->
<!--           -moz-animation: ball-spin-clockwise 1s infinite ease-in-out;-->
<!--             -o-animation: ball-spin-clockwise 1s infinite ease-in-out;-->
<!--                animation: ball-spin-clockwise 1s infinite ease-in-out;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div:nth-child(1) {-->
<!--        top: 5%;-->
<!--        left: 50%;-->
<!--        -webkit-animation-delay: -.875s;-->
<!--           -moz-animation-delay: -.875s;-->
<!--             -o-animation-delay: -.875s;-->
<!--                animation-delay: -.875s;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div:nth-child(2) {-->
<!--        top: 18.1801948466%;-->
<!--        left: 81.8198051534%;-->
<!--        -webkit-animation-delay: -.75s;-->
<!--           -moz-animation-delay: -.75s;-->
<!--             -o-animation-delay: -.75s;-->
<!--                animation-delay: -.75s;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div:nth-child(3) {-->
<!--        top: 50%;-->
<!--        left: 95%;-->
<!--        -webkit-animation-delay: -.625s;-->
<!--           -moz-animation-delay: -.625s;-->
<!--             -o-animation-delay: -.625s;-->
<!--                animation-delay: -.625s;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div:nth-child(4) {-->
<!--        top: 81.8198051534%;-->
<!--        left: 81.8198051534%;-->
<!--        -webkit-animation-delay: -.5s;-->
<!--           -moz-animation-delay: -.5s;-->
<!--             -o-animation-delay: -.5s;-->
<!--                animation-delay: -.5s;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div:nth-child(5) {-->
<!--        top: 94.9999999966%;-->
<!--        left: 50.0000000005%;-->
<!--        -webkit-animation-delay: -.375s;-->
<!--           -moz-animation-delay: -.375s;-->
<!--             -o-animation-delay: -.375s;-->
<!--                animation-delay: -.375s;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div:nth-child(6) {-->
<!--        top: 81.8198046966%;-->
<!--        left: 18.1801949248%;-->
<!--        -webkit-animation-delay: -.25s;-->
<!--           -moz-animation-delay: -.25s;-->
<!--             -o-animation-delay: -.25s;-->
<!--                animation-delay: -.25s;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div:nth-child(7) {-->
<!--        top: 49.9999750815%;-->
<!--        left: 5.0000051215%;-->
<!--        -webkit-animation-delay: -.125s;-->
<!--           -moz-animation-delay: -.125s;-->
<!--             -o-animation-delay: -.125s;-->
<!--                animation-delay: -.125s;-->
<!--    }-->
<!--    .la-ball-spin-clockwise > div:nth-child(8) {-->
<!--        top: 18.179464974%;-->
<!--        left: 18.1803700518%;-->
<!--        -webkit-animation-delay: 0s;-->
<!--           -moz-animation-delay: 0s;-->
<!--             -o-animation-delay: 0s;-->
<!--                animation-delay: 0s;-->
<!--    }-->
<!--    .la-ball-spin-clockwise.la-sm {-->
<!--        width: 16px;-->
<!--        height: 16px;-->
<!--    }-->
<!--    .la-ball-spin-clockwise.la-sm > div {-->
<!--        width: 4px;-->
<!--        height: 4px;-->
<!--        margin-top: -2px;-->
<!--        margin-left: -2px;-->
<!--    }-->
<!--    .la-ball-spin-clockwise.la-2x {-->
<!--        width: 64px;-->
<!--        height: 64px;-->
<!--    }-->
<!--    .la-ball-spin-clockwise.la-2x > div {-->
<!--        width: 16px;-->
<!--        height: 16px;-->
<!--        margin-top: -8px;-->
<!--        margin-left: -8px;-->
<!--    }-->
<!--    .la-ball-spin-clockwise.la-3x {-->
<!--        width: 96px;-->
<!--        height: 96px;-->
<!--    }-->
<!--    .la-ball-spin-clockwise.la-3x > div {-->
<!--        width: 24px;-->
<!--        height: 24px;-->
<!--        margin-top: -12px;-->
<!--        margin-left: -12px;-->
<!--    }-->
    /*
     * Animation
     */
<!--    @-webkit-keyframes ball-spin-clockwise {-->
<!--        0%,-->
<!--        100% {-->
<!--            opacity: 1;-->
<!--            -webkit-transform: scale(1);-->
<!--                    transform: scale(1);-->
<!--        }-->
<!--        20% {-->
<!--            opacity: 1;-->
<!--        }-->
<!--        80% {-->
<!--            opacity: 0;-->
<!--            -webkit-transform: scale(0);-->
<!--                    transform: scale(0);-->
<!--        }-->
<!--    }-->
<!--    @-moz-keyframes ball-spin-clockwise {-->
<!--        0%,-->
<!--        100% {-->
<!--            opacity: 1;-->
<!--            -moz-transform: scale(1);-->
<!--                 transform: scale(1);-->
<!--        }-->
<!--        20% {-->
<!--            opacity: 1;-->
<!--        }-->
<!--        80% {-->
<!--            opacity: 0;-->
<!--            -moz-transform: scale(0);-->
<!--                 transform: scale(0);-->
<!--        }-->
<!--    }-->
<!--    @-o-keyframes ball-spin-clockwise {-->
<!--        0%,-->
<!--        100% {-->
<!--            opacity: 1;-->
<!--            -o-transform: scale(1);-->
<!--               transform: scale(1);-->
<!--        }-->
<!--        20% {-->
<!--            opacity: 1;-->
<!--        }-->
<!--        80% {-->
<!--            opacity: 0;-->
<!--            -o-transform: scale(0);-->
<!--               transform: scale(0);-->
<!--        }-->
<!--    }-->
<!--    @keyframes ball-spin-clockwise {-->
<!--        0%,-->
<!--        100% {-->
<!--            opacity: 1;-->
<!--            -webkit-transform: scale(1);-->
<!--               -moz-transform: scale(1);-->
<!--                 -o-transform: scale(1);-->
<!--                    transform: scale(1);-->
<!--        }-->
<!--        20% {-->
<!--            opacity: 1;-->
<!--        }-->
<!--        80% {-->
<!--            opacity: 0;-->
<!--            -webkit-transform: scale(0);-->
<!--               -moz-transform: scale(0);-->
<!--                 -o-transform: scale(0);-->
<!--                    transform: scale(0);-->
<!--        }-->
<!--    }-->
<!--</style>-->
@endpush