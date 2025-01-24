@extends('layouts.master') @section('title', "Deal Denied")
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
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
                <p class="text-lg mt-2">Your cart totat is greater than your approval amount or you have an existing deal.</p>
                <p class="text-lg mt-2">Please close this window and select a device that is less than your approval amount or contact PayVantage for adding another device.</p><br>
                <button 
                class="p-3 text-xl text-white rounded-xl bg-purple-600 shadow-lg w-72 hover:bg-purple-500 items-center justify-center"
                onclick="window.location.href = 'https://smartimobile.com/cart' ;"
                >
                Close</button>
            </div>
        </div>
    </div>
</body>
</html>
@endsection