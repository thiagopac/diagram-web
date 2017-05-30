<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <!-- Libraries used: chessboardjs and chess.js from GitHub -->
    <link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <script src="../../assets/admin/custom/scripts/chessboard.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery-1.11.1.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/json3.min.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/chess.js" type="text/javascript"></script>
	<script src="../../assets/admin/custom/scripts/i18next-1.11.2.js" type="text/javascript"></script>

    <!-- CSS used: chessboardjs from GitHub -->
    <link href="../../assets/admin/custom/css/chessboard.css" type="text/css" rel="stylesheet"/>

    <!-- My own library -->
    <script src="../../assets/admin/custom/scripts/pgnvjs.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery.timer.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/pgn.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/pgn-parser.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/mousetrap.js"  type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery-ui.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery.multiselect.js" type="text/javascript"></script>
    <link href="../../assets/admin/custom/css/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <link href="../../assets/admin/custom/css/jquery.multiselect.css" type="text/css" rel="stylesheet"/>
    <link href="../../assets/admin/custom/css/pgnvjs.css" type="text/css" rel="stylesheet"/>

</head>
<body>
<div id="board"></div>

<script>
    var pgnv = pgnEdit('board', {locale: 'en', position: "start", theme: 'chesscom', size: "100%", scrollable: true, movesWidth: "100%", movesHeight: "400px"});
</script>
</body>
