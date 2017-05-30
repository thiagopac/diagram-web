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
    var pgn ="[Event \"Rosenwald Memorial Tournament\"]" +
            "[Site \"New York, New York USA\"]" +
            "[Date \"1956.10.17\"]" +
            "[White \"Byrne, Donald\"]" +
            "[Black \"Fischer, Bobby\"]" +
            "[Result \"0-1\"]" +
            "[ECO \"D97\"]" +
            "1. Nf3 {This is the Reti opening,  a noncomittal move that can easily transpose into a number of other different openings.} Nf6 2. c4 g6 3. Nc3 Bg7 4. d4 O-O 5. Bf4 d5 6. Qb3 dxc4 7. Qxc4 c6 8. e4 Nbd7 9. Rd1 Nb6 10. Qc5 Bg4 11. Bg5$2 ( 11. {For example, the game Flear-Morris, Dubling 1991, continued in this way:} Be2 Nfd7 12. Qa3 Bxf3 13. Bxf3 e5 14. dxe5 Qe8 15. Be2 Nxe5 16. O-O$16 ) Na4!! {Here Fischer cleverly offers up his Knight, but if Byrne takes it with Nxa4 Fischer will play Nxe4, and Byrne then suddenly has some terrible choices:} 12. Qa3 ( 12. Nxa4 Nxe4 13. Qxe7 ( 13. Bxe7 Nxc5 14. Bxd8 Nxa4 15. Bg5 Bxf3 16. gxf3 Nxb2 {gives Fischer an extra pawn and ruin's Byrne's pawn structure.} ) ( 13. Qc1 Qa5+ 14. Nc3 Bxf3 15. gxf3 Nxg5 {gives Fischer back his piece and a better position.} ) Qa5+ 14. b4 Qxa4 15. Qxe4 Rfe8 16. Be7 Bxf3 17. gxf3 Bf8 {produces a terrible pin.} ) Nxc3 13. bxc3 Nxe4! {Byrne declined to take the knight on move 12, so Fischer tries again by offering material to Byrne, in exchange for a much better position that is especially dangerous to white: an open e-file, with white's king poorly protected.} 14. Bxe7 {Byrne wisely decides to decline the offered material.} Qb6 15. Bc4 Nxc3! 16. Bc5 Rfe8+ 17. Kf1 Be6!! {This is a very clever move by Fischer; this is the move that made this game famous. Instead of trying to protect his queen, Fischer viciously counter-attacks using his bishop and sacrifices his queen. Byrne cannot simply take the bishop, because that will lead to checkmate.} 18. Bxb6 {Byrne takes Fischer's queen, as Fischer offered.} ( 18. Bxe6 Qb5+ 19. Kg1 Ne2+ 20. Kf1 Ng3+ 21. Kg1 Qf1+ 22. Rxf1 Ne2# ) Bxc4+ {Fischer now begins a series of discovered checks, picking up material.} 19. Kg1 Ne2+ 20. Kf1 Nxd4+ 21. Kg1 Ne2+ 22. Kf1 Nc3+ 23. Kg1 axb6 {This move by Fischer takes time out to capture a piece, but it doesn't waste time because it also threatens Byrne's queen. Byrne's queen cannot take the knight on c3, because it's protected by Fischer's bishop on g7.} 24. Qb4 Ra4 {Fischer uses his pieces together nicely in concert; the knight on c3 protects the rook on a4, which in turn protects the bishop on c4. This forces Byrne's queen away.} 25. Qxb6 {Byrne's queen picks up a pawn, but it's now poorly placed.} Nxd1 {Fischer has taken a rook, 2 bishops, and a pawn as compensation for his queen; in short, Fischer has gained significantly more material than he's lost. In addition, Byrne's remaining rook is stuck on h1 and it will take precious time to free it, giving Fischer opportunity to set up another offensive. Byrne has the only remaining queen, but this will not be enough.} 26. h3 Rxa2 27. Kh2 Nxf2 28. Re1 Rxe1 29. Qd8+ Bf8 30. Nxe1 Bd5 31. Nf3 Ne4 32. Qb8 b5 33. h4 h5 34. Ne5 Kg7 {Fischer breaks the pin, allowing the bishop to attack as well.} 35. Kg1 Bc5+ {Now Fischer peels away the white king from his last defender, and begins a series of checks that culminate in checkmate. This series of moves is extremely interesting in the way Fischer shows how to use various pieces together to force a checkmate.} 36. Kf1 Ng3+ {Adjacent bishops can, without opposition, simply move next to each other to force the king along. However, Fischer can't do this here by simply moving his light-square bishop to c4, because Byrne's knight protects c4. However, the knight does the job, forcing Byrne's king along.} 37. Ke1 Bb4+ 38. Kd1 Bb3+ 39. Kc1 Ne2+ 40. Kb1 Nc3+ 41. Kc1 Rc2# 0-1";

      pgnv = pgnView("board", {locale: 'en', pgn: pgn, position: "start", theme: 'chesscom', size: "100%", scrollable: true, movesWidth: "100%", movesHeight: "400px"});

</script>
</body>
