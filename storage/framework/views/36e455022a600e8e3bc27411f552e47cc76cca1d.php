<head>

  <meta charset="UTF-8" />

  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

  <link rel="icon" href="<?php echo e(asset('img/logo-icon.png')); ?>" />



  <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('app.name', 'Payvantage')); ?></title>

  <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />



  <?php echo \Livewire\Livewire::styles(); ?>




</head>

<?php /**PATH C:\xampp8.0\htdocs\plaid\resources\views/templates/header.blade.php ENDPATH**/ ?>