<?php

$study = addslashes($_REQUEST['pgn']);

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <!-- Libraries used: chessboardjs and chess.js from GitHub -->
    <link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <script src="../../assets/admin/custom/scripts/chessboard.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery-1.11.1.js" type="text/javascript"></script>
    <!-- <script src="../../assets/admin/custom/scripts/json3.min.js" type="text/javascript"></script> -->
    <!-- <script src="../../assets/admin/custom/scripts/chess.js" type="text/javascript"></script> -->
	<!-- <script src="../../assets/admin/custom/scripts/i18next-1.11.2.js" type="text/javascript"></script> -->

    <!-- CSS used: chessboardjs from GitHub -->
    <link href="../../assets/admin/custom/css/chessboard.css" type="text/css" rel="stylesheet"/>

    <!-- My own library -->
    <script src="../../assets/admin/custom/scripts/pgnvjs2.js" type="text/javascript"></script>
    <script src="../../assets/admin/custom/scripts/jquery.timer.js" type="text/javascript"></script>
    <!-- <script src="../../assets/admin/custom/scripts/pgn.js" type="text/javascript"></script> -->
    <!-- <script src="../../assets/admin/custom/scripts/pgn-parser.js" type="text/javascript"></script> -->
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

    // var pgn ="[Event \"Rosenwald Memorial Tournament\"]" +
    //         "[Site \"New York, New York USA\"]" +
    //         "[Date \"1956.10.17\"]" +
    //         "[White \"Byrne, Donald\"]" +
    //         "[Black \"Fischer, Bobby\"]" +
    //         "[Result \"0-1\"]" +
    //         "[ECO \"D97\"]" +
    //         "<?=$study?>";
    var pgn ="<?=$study?>";

      pgnv = pgnView("board", {locale: 'en', pgn: pgn, position: "start", theme: 'chesscom', size: "100%", scrollable: true, movesWidth: "100%", movesHeight: "400px"});

</script>
</body>
<!--  { Esta é a variante clássica da Caro-Kann, onde as negras perdem vários tempos com o bispo, optando pela solidez da defesa. A estrutura de peões das pretas se manterá até o final, onde a Caro-Kann é considerada muito forte. } 1. e4 c6 2. d4 d5 3. Nc3 dxe4 4. Nxe4 Bf5 5. Ng3 Bg6 6. h4 h6 7. Nf3 Nd7 8. h5 Bh7 9. Bd3 Bxd3 10. Qxd3 e6 11. Bf4 Qa5+ 12. Bd2 Bb4 13. c3 Be7 14. Ne4 Qc7 { Com este movimento, fechamos esta linha. } -->
