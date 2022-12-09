<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php if (! empty(trim($__env->yieldContent('title')))): ?>
        <title><?php echo $__env->yieldContent('title'); ?></title>
    <?php else: ?>
        <title>WeProfi</title>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">


    <?php if (! empty(trim($__env->yieldContent('head')))): ?>
        <?php echo $__env->yieldContent('head'); ?>
    <?php endif; ?>



    <!-- Styles -->
    <link href="<?php echo e(asset('css/app-boot.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/app-mobile.css')); ?>" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="top-logo">
            <a href="<?php echo e(url('/')); ?>">
                <img src="/img/logo-simple.svg">
            </a>
        </div>
        

        <?php if (! empty(trim($__env->yieldContent('header')))): ?>
            <header class="">
                <div class="container">
                    <?php echo $__env->yieldContent('header'); ?>
                </div>
            </header>
        <?php endif; ?>

        <main class="py-4">
            <div class="container d-block text-center">
                <?php echo $__env->yieldContent('content'); ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>



            </div>

            <?php if(!Auth::user()): ?>
                <div class="container p-4 pt-5">
                    <div class="d-flex justify-content-center bg-light-blue align-items-center">
                        Регистрация
                    </div>
                </div>
            <?php endif; ?>

        </main>

        <footer class="footer d-flex justify-content-center w-100 align-items-center">

            <div class="">
                &copy; 2022 <img src="/img/logo.svg" width="220" class="mr-4 mb-2">
            </div>
        </footer>
    </div>
</body>

</html>
<?php /**PATH /var/www/msnus/data/www/weprofi.co.il/resources/views/layouts/app.blade.php ENDPATH**/ ?>