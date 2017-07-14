<?
$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootbox/bootbox.min.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/jquery.pulsate.min.js"></script>

<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/jquery.repeater.min.js"></script>

<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js"></script>

<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>

<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
