<?

$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN OPENING STYLES -->
<link href="<?=$absolutepath?>assets/admin/custom/css/memchess.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/admin/custom/css/chessy.css" rel="stylesheet" type="text/css" />
<!-- END OPENING STYLES -->

<link href="<?=$absolutepath?>assets/admin/custom/css/pgnvjs.css" rel="stylesheet" type="text/css" />
