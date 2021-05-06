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
        <title>Pochinim.online</title>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

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
        <div class="head-wrapper">
            <nav class="navbar navbar-expand-md navbar-dark">
                <div class="container">
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                        <?php
                            if (isset($_REQUEST['rand'])) {
                                $rand = $_REQUEST['rand'];
                            } else {
                                $rand = rand(1, 3);
                            }

                            $logo = $rand == 1 ? 'src="/img/logo1.png" style="margin-left: -85px;"' : 'src="/img/logo' . $rand . '.png" style="margin-top: 20px;margin-left: -18px;"';

                        ?>
                        <img <?php echo $logo; ?>>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            <?php if(auth()->guard()->guest()): ?>
                                <?php if(Route::has('login')): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo e(route('login')); ?>">Вход</a>
                                    </li>
                                <?php endif; ?>
                                <?php if(Route::has('register')): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo e(route('register')); ?>">Регистрация</a>
                                    </li>
                                <?php endif; ?>
                            <?php else: ?>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <?php echo e(Auth::user()->title()); ?>

                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/profile">
                                            Профиль
                                        </a>
                                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Выход
                                        </a>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="head-descr text-left" style="margin-top: 27px">
                    <img src="/img/description.png">
                </div>
                <div class="head-texts">
                    <div class="head-text-block head-text1">
                        <div class="head-text-icon"><img src="/img/icon-1.png"></div>
                        <div class="head-text">Указываете марку и модель машины, своими словами описываете неисправность, ставите точку на карте.</div>
                    </div>
                    <div class="head-text-block head-text2">
                        <div class="head-text-icon"><img src="/img/icon-2.png"></div>
                        <div class="head-text">Получаете отклики от Мастеров, выбираете подходящего по дальности, рейтингу и озывам</div>
                    </div>
                    <div class="head-text-block head-text3">
                        <div class="head-text-icon"><img src="/img/icon-3.png"></div>
                        <div class="head-text">Выбранный Мастер согласует с Вами время, детали, приезжает и проводит ремонт на месте. На типовые работы цены фиксированы по <a href="#price"> прайс-листу</a></div>
                    </div>
                </div>
                <?php if($rand == 0): ?>
                    <div class="text-center" style="margin-top: 14px">
                        <img src="/img/robot2.png">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (! empty(trim($__env->yieldContent('header')))): ?>
            <header class="">
                <div class="container">
                    <?php echo $__env->yieldContent('header'); ?>
                </div>
            </header>
        <?php endif; ?>

        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <footer class="footer d-flex justify-content-center w-100 align-items-center">
            <img <?php echo $logo; ?> width="220" class="mr-4 mb-2">
            <div class="">
                &copy; 2021, <span style="color:white;">pochinim</span><span style="color:sandybrown;">.online</span>
            </div>
        </footer>
    </div>
</body>

</html>
<?php /**PATH /home/admin/web/pochinim.online/public_html/app/resources/views/layouts/app.blade.php ENDPATH**/ ?>