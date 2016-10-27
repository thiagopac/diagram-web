<?

$GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
// echo $absolutepath;
?>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
