<head>

  <meta charset="UTF-8" />

  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="icon" href="{{ asset('img/logo-icon.png') }}" />



  <title>@yield('title') | {{ config('app.name', 'Payvantage') }}</title>

  <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />



  @livewireStyles



</head>

