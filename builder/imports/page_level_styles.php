<?
$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/admin/pages/css/profile-old.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/bootstrap-toastr/toastr.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/admin/pages/css/news.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/admin/pages/css/blog.css"/>

<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css"/>

<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>

<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/admin/pages/css/pricing-table.css"/>

<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/admin/pages/css/profile.css"/>

<link rel="stylesheet" type="text/css" href="<?=$absolutepath?>/assets/admin/custom/css/star-rating.css"/>
<!-- END PAGE LEVEL STYLES -->
