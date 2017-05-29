<?
$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN OPENING SOUNDS -->
<audio id="soundMove" src=" <?=$absolutepath?>assets/admin/custom/sounds/move.wav" type="audio/wav"></audio>
<audio id="soundMove" src=" <?=$absolutepath?>assets/admin/custom/sounds/take.wav" type="audio/wav"></audio>
<audio id="soundMove" src=" <?=$absolutepath?>assets/admin/custom/sounds/check.wav" type="audio/wav"></audio>
<audio id="soundMove" src=" <?=$absolutepath?>assets/admin/custom/sounds/success.wav" type="audio/wav"></audio>
<!-- END OPENING SOUNDS -->
