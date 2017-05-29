<?

$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN THEME STYLES -->
<link href="<?=$absolutepath?>assets/global/css/components.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css" />
<link id="style_color" href="<?=$absolutepath?>assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/admin/pages/css/todo.css" rel="stylesheet" type="text/css" />
<!-- END THEME STYLES -->
