<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nepza Cooperative</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo e(asset ('landing')); ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?php echo e(asset ('landing')); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?php echo e(asset ('landing')); ?>/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="<?php echo e(asset ('landing')); ?>/css/landing-page.min.css" rel="stylesheet">

</head>

    <body>
<!-- Navigation -->
<nav class="navbar navbar-light bg-light static-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(url('/')); ?>"></a>
        <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links" style="width: 200px">
                    <?php if(auth()->guard()->check()): ?>

                    <?php else: ?>
                        <a type="button" href="<?php echo e(route('login')); ?>" class="btn btn-outline-info" style="">Login</a>

                        <?php if(Route::has('register')): ?>
                            <a type="button" href="<?php echo e(route('register')); ?>" class="btn btn-primary" style="background-color: #3C8DBC ! important">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
<!-- Testimonials -->
<section class="testimonials text-center bg-light">
    <div class="container">
        <h2 class="mb-5">We are Nepza Cooperative...</h2>
        <div class="row">
            <div class="col-lg-4">
                <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                    <img class="img-fluid rounded-circle mb-3" src="<?php echo e(asset ('landing')); ?>/img/testimonials-1.jpg" alt="">
                    <h5>Margaret E.</h5>
                    <p class="font-weight-light mb-0">"Vice Chairman"</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                    <img class="img-fluid rounded-circle mb-3" src="<?php echo e(asset ('landing')); ?>/img/testimonials-2.jpg" alt="">
                    <h5>Fred S.</h5>
                    <p class="font-weight-light mb-0">"Cooperative Chairman"</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                    <img class="img-fluid rounded-circle mb-3" src="<?php echo e(asset ('landing')); ?>/img/testimonials-3.jpg" alt="">
                    <h5>Sarah W.</h5>
                    <p class="font-weight-light mb-0">"Cooperative Secretary"</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer bg-light">
    <div class="container">
        <div class="row">



        </div>
    </div>
</footer>
<style>
    .btn-outline-info:hover,
    .btn-outline-info:hover{
        background-color: #3C8DBC ! important;
    }
</style>

<!-- Bootstrap core JavaScript -->
<script src="<?php echo e(asset ('landing')); ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo e(asset ('landing')); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/welcome.blade.php ENDPATH**/ ?>