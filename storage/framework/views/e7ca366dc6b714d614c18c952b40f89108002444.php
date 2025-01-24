<!DOCTYPE html>

<html lang="en">

  <?php echo $__env->make('templates.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  

    <head>

        <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(config('services.ga4.measurementId')); ?>"></script>

        <script>

            window.dataLayer = window.dataLayer || [];

            function gtag(){dataLayer.push(arguments);}

            gtag('js', new Date());

            gtag('config', '<?php echo e(config('services.ga4.measurementId')); ?>');

        </script> -->

    </head>



  <body class="h-screen">

    

    <div id="app"><?php echo $__env->yieldContent('content'); ?></div>

    

    <?php echo $__env->make('templates.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- <?php echo $__env->yieldPushContent('additional-scripts'); ?> -->

  </body>

</html>

<?php /**PATH C:\xampp8.0\htdocs\plaid\resources\views/layouts/master.blade.php ENDPATH**/ ?>