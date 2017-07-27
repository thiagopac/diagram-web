<?php

$study = addslashes($_REQUEST['pgn']);

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <script src="../../assets/admin/custom/scripts/chessboard.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery-1.11.1.js" type="text/javascript"></script>
    <link href="../../assets/admin/custom/css/chessboard.css" type="text/css" rel="stylesheet"/>

    <script src="../../assets/admin/custom/scripts/pgnvjs2.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery.timer.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/mousetrap.js"  type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery-ui.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery.multiselect.js" type="text/javascript"></script>
    <link href="../../assets/admin/custom/css/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <link href="../../assets/admin/custom/css/jquery.multiselect.css" type="text/css" rel="stylesheet"/>
    <link href="../../assets/admin/custom/css/pgnvjs.css" type="text/css" rel="stylesheet"/>

</head>

<body>
    <div id="board"></div>
</body>

<script>
  var pgn ="<?=$study?>";
  pgnv = pgnView("board", {locale: 'en', pgn: pgn, position: "start", theme: 'chesscom', size: "100%", scrollable: true, movesWidth: "100%", movesHeight: "400px"});
</script>
