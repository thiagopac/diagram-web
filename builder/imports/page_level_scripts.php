<?
$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=$absolutepath?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?=$absolutepath?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?=$absolutepath?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?=$absolutepath?>assets/admin/pages/scripts/components-pickers.js"></script>
<script src="<?=$absolutepath?>assets/admin/pages/scripts/table-managed.js"></script>
<script src="<?=$absolutepath?>assets/admin/pages/scripts/portlet-draggable.js"></script>
<script src="<?=$absolutepath?>assets/admin/custom/scripts/rating.js"></script>
<script src="<?=$absolutepath?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="<?=$absolutepath?>assets/admin/pages/scripts/ui-toastr.js"></script>
<script src="<?=$absolutepath?>assets/admin/pages/scripts/ui-alert-dialog-api.js"></script>
<script src="<?=$absolutepath?>assets/admin/pages/scripts/components-pickers.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
