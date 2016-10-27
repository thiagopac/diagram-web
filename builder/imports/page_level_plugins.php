<?

$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
