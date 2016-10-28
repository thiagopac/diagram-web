<?
$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN CORE PLUGINS -->
<script src=" <?=$absolutepath?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src=" <?=$absolutepath?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src=" <?=$absolutepath?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src=" <?=$absolutepath?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src=" <?=$absolutepath?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src=" <?=$absolutepath?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src=" <?=$absolutepath?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src=" <?=$absolutepath?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src=" <?=$absolutepath?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src=" <?=$absolutepath?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
