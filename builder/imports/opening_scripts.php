<?
$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN OPENING SCRIPTS -->

<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/jquery.layout-latest.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/chessboard-0.3.0.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/chess.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/chessy.js"></script>

<!-- END OPENING SCRIPTS -->
