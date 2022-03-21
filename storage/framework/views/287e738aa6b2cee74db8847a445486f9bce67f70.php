<!DOCTYPE html >
<html lang="<?php echo e(str_replace('_','-', app()->getLocale())); ?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Nepza Cooperative</title>
<!-- Tell the browser to be responsive to screen width -->
    <!-- CSRF Token -->
<meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?php echo e(asset('custom2')); ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo e(asset('custom2')); ?>/bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="<?php echo e(asset('custom2')); ?>/bower_components/Ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="<?php echo e(asset('custom2')); ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- jvectormap -->
<link rel="stylesheet" href="<?php echo e(asset('custom2')); ?>/bower_components/jvectormap/jquery-jvectormap.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo e(asset('custom2')); ?>/dist/css/AdminLTE.min.css">
    <!-- daterangepicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Pace style -->
<link rel="stylesheet" href="<?php echo e(asset('custom2')); ?>/plugins/pace/pace.min.css">

<!-- Select2 -->
<link rel="stylesheet" href="<?php echo e(asset('custom2')); ?>/bower_components/select2/dist/css/select2.min.css">


<link rel="stylesheet" href="<?php echo e(asset('custom2')); ?>/toastr.js/toastr.min.css">
<script src="<?php echo e(asset('custom2')); ?>/toastr.js/toastr.min.js"></script>

<!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->



<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

<![endif]-->

<!-- Google Font -->

<?php echo \Livewire\Livewire::styles(); ?>

<?php echo \Livewire\Livewire::scripts(); ?>

<script>
    $(document).bind("contextmenu",function(e){
        return false;
    });
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini a" style="zoom:90% ! important">

<div class="wrapper">
<?php echo $__env->yieldContent('header'); ?>
<!-- Left side column. contains the logo and sidebar -->
<?php echo $__env->yieldContent('sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
<?php echo $__env->yieldContent('main-content'); ?>
    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- /.control-sidebar -->

<div class="control-sidebar-bg"></div>

</div>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('custom2')); ?>/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="<?php echo e(asset('custom2')); ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo e(asset('custom2')); ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- DataTables -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo e(asset('custom2')); ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/fastclick/lib/fastclick.js"></script>

<!-- Select2 -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- CK Editor -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/ckeditor/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo e(asset('custom2')); ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="<?php echo e(asset('custom2')); ?>/dist/js/demo.js"></script>
<!-- Toastr Lib -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<!-- PACE -->
<script src="<?php echo e(asset('custom2')); ?>/bower_components/PACE/pace.min.js"></script>
<script type="text/javascript">
    // To make Pace works on Ajax calls
    $(document).ajaxStart(function () {Pace.restart()});$('.ajax').click(function () {$.ajax({url: '#', success: function (result) {$('.ajax-content').html('<hr>Ajax Request Completed !')}})})
</script>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/dashboard/master.blade.php ENDPATH**/ ?>