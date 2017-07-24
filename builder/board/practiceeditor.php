<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?=$absolutepath?>../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<?

$pgn = $_GET['pgn'];

?>

<style media="screen">
  .button {
    font-size: 16px;
    line-height: 1.4em;
    color: #656565;
    margin: 5px;
    padding: 4px;
    width:55px;
    height: 26px;
    text-align: center;
    border: solid lightgrey 1px;
    border-radius: 2px;
  }

  .moves {
    font-size: 15px;
    font-family: "Courier New", Courier, monospace;
    color: black;
    font-weight: 700;
    line-height: 24px;
    outline: none;
    border:1px solid #f5f5f5;
}
</style>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">
  <div class="row">
    <div class="col-md-5 col-sm-5">
      <div id="board" style="width:100%"></div>
      <a href="#" class="btn btn-default button" id="flipBtn" onclick="flipClick();"><i class="fa fa-retweet"></i></a>
      <a href="#" class="btn btn-default button" id="startBtn" onclick="startClick();"><i class="fa fa-fast-backward"></i></a>
      <a href="#" class="btn btn-default button" id="undoBtn" onclick="undoMove();"><i class="fa fa-step-backward"></i></a>
      <a class="btn btn-default button" id="updateBtn" onclick="updatePosition();"><i class="fa fa-pencil-square-o"></i></a>
    </div>
    <div class="col-md-7 col-sm-7">
      <textarea class="form-control moves" rows="15" id="pgn"></textarea>
    </div>
  </div>

  <!-- END CONTENT -->
</div>
<? include('../imports/metronic_core.php'); ?>
<? include('../imports/chessboard_scripts.php'); ?>
<script>
  jQuery(document).ready(function() {
    // initiate layout and plugins
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layou

    setIncomingPgn('<?=$pgn?>');
  });

  var board,
     game = new Chess(),
     statusEl = $('#status'),
     pgnEl = $('#pgn'),
     promotionChoice = "q",
     updateBtn = $('#updateBtn'),
     startBtn = $('#startBtn');
     undoBtn = $('#undoBtn');

     var removeGreySquares = function() {
       $('#board .square-55d63').css('background', '');
     };

     var greySquare = function(square) {

        var squareEl = $('#board .square-' + square);

        // var background = 'rgba(241, 218, 14, 0.52)';
        // if (squareEl.hasClass('black-3c85d') === true) {
        //   background = 'rgba(241, 218, 14, 0.39)';
        // }

        var background = '#e3e7a8';
        // var background = 'url("chessboard-dependencies/select.png")';
        var backgroundsize = 'contain';
        if (squareEl.hasClass('black-3c85d') === true) {
          // var background = 'url("chessboard-dependencies/select2.png")';
          background = '#f8fbc1';
        }


        squareEl.css('background', background);
        squareEl.css('background-size', backgroundsize);
        squareEl.addClass('taphover');
      };

     var onMouseoverSquare = function(square, piece) {
       // get list of possible moves for this square
       var moves = game.moves({
         square: square,
         verbose: true
       });

       // exit if there are no moves available for this square
       if (moves.length === 0) return;

       // highlight the square they moused over
      //  greySquare(square);

       // highlight the possible squares for this piece
       for (var i = 0; i < moves.length; i++) {
         greySquare(moves[i].to);
       }
     };

     var onMouseoutSquare = function(square, piece) {
        removeGreySquares();
     };

     // do not pick up pieces if the game is over
     // only pick up pieces for the side to move
     var onDragStart = function(source, piece, position, orientation) {
       if (game.game_over() === true ||
       (game.turn() === 'w' && piece.search(/^b/) !== -1) ||
       (game.turn() === 'b' && piece.search(/^w/) !== -1)) {
         return false;
       }
     };

     var onDrop = function(source, target) {

       removeGreySquares();
       // see if the move is legal
       var move = game.move({
         from: source,
         to: target,
         promotion: promotionChoice
       });

       // illegal move
       if (move === null) return 'snapback';

       updateStatus();
     };

     // update the board position after the piece snap
     // for castling, en passant, pawn promotion
     var onSnapEnd = function() {
       board.position(game.fen());
     };

     var updateStatus = function() {
       var status = '';

       var moveColor = 'White';
       if (game.turn() === 'b') {
         moveColor = 'Black';
       }

       // checkmate?
       if (game.in_checkmate() === true) {
         status = 'Game over, ' + moveColor + ' is in checkmate.';
       }

       // draw?
       else if (game.in_draw() === true) {
         status = 'Game over, drawn position';
       }

       // game still on
       else {
         status = moveColor + ' to move';

         // check?
         if (game.in_check() === true) {
           status += ', ' + moveColor + ' is in check';
         }
       }

       pgnEl.val(game.pgn());

       if(pgnEl.length)
         pgnEl.scrollTop(pgnEl[0].scrollHeight - pgnEl.height());

       if ($.trim(pgnEl.val()).length < 1){
           startBtn.attr("disabled", "disabled");
           undoBtn.attr("disabled", "disabled");
       }else{
           startBtn.removeAttr("disabled");
           undoBtn.removeAttr("disabled");
       }
     };

     var startClick = function(){
       board.start();
       game.reset();
       updateStatus(null);
     };

     var flipClick = function(){
       board.flip();
       updateStatus(null);
     };

     var undoMove = function(){
       game.undo();
       board.position(game.fen());
       updateStatus(null);
     };

     var setIncomingPgn = function(pgn){
       startBtn.removeAttr("disabled");
       pgnEl.val(pgn);
       updatePosition();
     };

     var updatePosition = function(){

       var language = "en-us";

       if (pgnEl.val().indexOf('C') > - 1){
            language = "pt-br";
       }else if(pgnEl.val().indexOf('N') > - 1){
            language = "en-us";
       }else if(pgnEl.val().indexOf('♘') > - 1){
            language = "unicode-1";
       }else if(pgnEl.val().indexOf('¤') > - 1){
            language = "unicode-2";
       }

       game.load_pgn(translatePieces(pgnEl.val(),language));

       board.position(game.fen());
       undoBtn.removeAttr("disabled");

       var strPgnClean = game.pgn();
       var strPgnClean = $.trim(strPgnClean.replace(/\[.*\]/g,''));

     };

     var translatePieces = function(pgn, language){

       if (language == "pt-br") {
        //  console.log("é português");
        //  console.log("Antes: "+pgn);
         //P de Peão para P de Pawn - em português e inglês, as iniciais são as mesmas,
         //mas estou criando essa condição para ser replicada para outros idiomas onde as
         //iniciais da peça do Peão não coincidirem sendo a mesma letra ;-)
         pgn = pgn.replace(/P/g, 'P');

         //C de Cavalo para N de kNight
         pgn = pgn.replace(/C/g, 'N');

         //B de Bispo para B de Bishop - em português e inglês, as iniciais são as mesmas,
         //mas estou criando essa condição para ser replicada para outros idiomas onde as
         //iniciais da peça do Bispo não coincidirem sendo a mesma letra ;-)
         pgn = pgn.replace(/B/g, 'B');

         //R de Rei para K de King
         pgn = pgn.replace(/R/g, 'K');

         //T de Torre para R de Rook
         pgn = pgn.replace(/T/g, 'R');

         //D de Dama para Q de Queen
         pgn = pgn.replace(/D/g, 'Q');

        //  console.log("Depois: "+pgn);

         return pgn;
       }else if (language == "en-us"){

         //nenhuma alteração se for inglês
         return pgn;
       }else if (language == "unicode-1") {
        //  console.log("é unicode-1");
        //  console.log("Antes: "+pgn);

         //exemplo: 1. e4 e5 2. ♘f3 ♞c6 3. ♗b5 ♝b4

         pgn = pgn.replace(/♙/g, 'P');
         pgn = pgn.replace(/♟/g, 'P');


         pgn = pgn.replace(/♘/g, 'N');
         pgn = pgn.replace(/♞/g, 'N');

         pgn = pgn.replace(/♗/g, 'B');
         pgn = pgn.replace(/♝/g, 'B');

         pgn = pgn.replace(/♔/g, 'K');
         pgn = pgn.replace(/♚/g, 'K');

         pgn = pgn.replace(/♖/g, 'R');
         pgn = pgn.replace(/♜/g, 'R');

         pgn = pgn.replace(/♕/g, 'Q');
         pgn = pgn.replace(/♛/g, 'Q');

        //  console.log("Depois: "+pgn);

         return pgn;
       }else if (language == "unicode-2") {
        //  console.log("é unicode-2");
        //  console.log("Antes: "+pgn);

         //exemplo: 1. e4 e5 2. ¤f3 ¤c6 3. ¥b5 ¥b4

        //  pgn = pgn.replace(/P/g, 'P');

         pgn = pgn.replace(/¤/g, 'N');

         pgn = pgn.replace(/¥/g, 'B');

         pgn = pgn.replace(/¢/g, 'K');

         pgn = pgn.replace(/¦/g, 'R');

         pgn = pgn.replace(/£/g, 'Q');

        //  console.log("Depois: "+pgn);

         return pgn;
       }

     };

     var cfg = {
       pieceTheme: 'chessboard-dependencies/chesspieces/alpha/{piece}.png',
       draggable: true,
       position: 'start',
       onDragStart: onDragStart,
       onDrop: onDrop,
       onSnapEnd: onSnapEnd,
       onMouseoutSquare: onMouseoutSquare,
       onMouseoverSquare: onMouseoverSquare
     };
     board = ChessBoard('board', cfg);
     $(window).resize(board.resize);
     updateStatus();
</script>
</body>
</html>
