<?
$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN OPENING CORE -->
<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/opening_names.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/books.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/lines.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/memchess.js"></script>
<script type="text/javascript" src=" <?=$absolutepath?>assets/admin/custom/scripts/stockfish.js"></script>
<!-- END OPENING CORE -->
