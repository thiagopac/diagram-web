<?
   // #INCLUDES
   require_once ('../lib/config.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'buildpgn' );

   include('../imports/header.php');

   $GLOBALS['absolutepath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
   $absolutepath = substr($absolutepath, 0, strpos($absolutepath, "builder"));
   // echo $absolutepath;

?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">

	 <? include('../imports/alert.php'); ?>

	 <!-- BEGIN PAGE TITLE & BREADCRUMB-->
   <div class="row">
      <div class="col-md-12">
         <h3 class="page-title">
            Build PGN <small>create an opening/defense sequence or a whole game history</small>
         </h3>
      </div>
   </div>
	 <!-- END PAGE TITLE & BREADCRUMB-->

   <div class="row" id="sortable_portlets">
   				<div class="col-md-2 column sortable">
            <div class="portlet portlet-sortable light bordered">
            						<div class="portlet-title">
            							<div class="caption font-green-sharp">
            								<i class="icon-speech font-green-sharp"></i>
            								<span class="caption-subject bold uppercase"> Board State</span>
            							</div>
            						</div>
            						<div class="portlet-body">
            							<div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">

                            <ul class="list-group">
                               <li class="list-group-item">
                                  <a id="startBtn" onclick="startClick();">INITIAL</a>
                               </li>
                               <li class="list-group-item">
                                  <a id="flipBtn" onclick="flipClick();">FLIP</a>
                               </li>
                               <li class="list-group-item">
                                  <a style="font-family: sans-serif;" id="undoBtn" onclick="undoMove();">UNDO MOVE</a>
                               </li>
                            </ul>

            							</div>
            						</div>
            					</div>
          </div>
          <div class="col-md-5 text-center">
             <div id="board" style="width: 100%"></div>
          </div>

          <div class="col-md-2 text-center">
            <div class="portlet portlet-sortable light bordered">
                        <div class="portlet-title">
                          <div class="caption font-green-sharp">
                            <i class="icon-speech font-green-sharp"></i>
                            <span class="caption-subject bold uppercase"> Promote to</span>
                          </div>
                        </div>
                        <div class="portlet-body text-left">
                          <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">

                            <span id="promotionChoiceGroup">
                               <li class="list-group-item">
                                  <label>
                                  <input type="radio" name="promotionChoice" value="q" checked=""> Queen</label>
                               </li>
                               <li class="list-group-item">
                                  <label>
                                  <input type="radio" name="promotionChoice" value="r"> Rook</label>
                               </li>
                               <li class="list-group-item">
                                  <label>
                                  <input type="radio" name="promotionChoice" value="b"> Bishop</label>
                               </li>
                               <li class="list-group-item">
                                  <label>
                                  <input type="radio" name="promotionChoice" value="n"> Knight</label>
                               </li>
                            </span>

                          </div>
                    </div>
                  </div>
          </div>


   </div>



   <div class="row">
      <div class="col-md-12">
         <div class="row">
            <div class="col-md-12">
               <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-3 text-right">

                     <div class="row">
                        <div class="col-md-12 text-right">
                           <h4 id="status"></h4>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-2 text-left">
                     <div class="row">
                        <div class="text-left">
                           <div class="text-center">
                              <label>Promote to</label>
                           </div>
                           <ul class="list-group">

                           </ul>
                        </div>
                     </div>
                     <div class="text-left">
                        <div class="row">
                           <h4>PGN:</h4>
                        </div>
                        <div class="row"><textarea class="form-control" rows="3" id="pgn" readonly=""></textarea></div>
                        <input type="checkbox" id="checkCustomPGN"> <label>Custom PGN</label> <a class="btn btn-info" style="display: none" id="updateBtn" onclick="updatePosition();">UPDATE POSITION</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <div class="container">
         <div class="row top-buffer">
            <div class="col-md-12">
               <div class="col-md-3"></div>
               <div class="col-md-6 text-center">
                  <div id="QRandButton" style="display: none;">
                     <div class="row">
                        <div id="containerQrCode">
                           <canvas class="img-responsive" style="display: initial" width="300" height="300"></canvas>
                        </div>
                     </div>
                     <div class="row top-buffer text-center">
                        <a class="linked" style="word-wrap:break-word;" id="pgnLink" href="" target="_blank"></a>
                     </div>
                     <div class="row top-buffer text-center">
                        <span class="label label-danger">Important</span> If you have a valid position but your QR-Code is unreadable, generate a new QR-Code with more error correction by clicking <a class="linked" onclick="unreadableClick();">here</a>.
                     </div>
                  </div>
               </div>
               <div class="col-md-3"></div>
            </div>
         </div>
      </div>
    </div>
  </div>
   <img id="img-buffer" src="chessboard-dependencies/name_qrcode.png">


<!-- END CONTENT -->
</div>
<? include('../imports/footer.php'); ?>
<? include('../imports/metronic_core.php'); ?>
<? include('../imports/chessboard_scripts.php'); ?>
<script>
   jQuery(document).ready(function() {
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layou
   PortletDraggable.init();
   });

   var board,
      game = new Chess(),
      statusEl = $('#status'),
      fenEl = $('#fen'),
      pgnEl = $('#pgn'),
      pgnLink = $('#pgnLink'),
      imgPgn = $('#imgPgn')
      promotionChoice = "q",
      isEditablePGN = $('#checkCustomPGN'),
      updateBtn = $('#updateBtn'),
      undoBtn = $('#undoBtn');

      isEditablePGN.change(function(){
           if(this.checked){
             pgnEl.removeAttr('readonly');
             updateBtn.removeAttr('style');
           }else{
             pgnEl.attr('readonly', 'readonly');
             updateBtn.attr('style','display: none');
           }
       });

      $("input[name=promotionChoice]").click(function(){
          promotionChoice = $('input[name=promotionChoice]:checked', '#promotionChoiceGroup').val();
      });

      var removeGreySquares = function() {
        $('#board .square-55d63').css('background', '');
      };

      var greySquare = function(square) {

         var squareEl = $('#board .square-' + square);

         // var background = 'rgba(241, 218, 14, 0.52)';
         // if (squareEl.hasClass('black-3c85d') === true) {
         //   background = 'rgba(241, 218, 14, 0.39)';
         // }

         var background = 'url("chessboard-dependencies/select.png")';
         var backgroundsize = 'contain';
         if (squareEl.hasClass('black-3c85d') === true) {
           var background = 'url("chessboard-dependencies/select2.png")';
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

        statusEl.html(status);
        fenEl.attr('value',game.fen());
        pgnEl.val(game.pgn());
        pgnLink.text("http://diagramchess.com/api/?v="+encodeURIComponent(game.pgn()));
        pgnLink.attr("href", "http://diagramchess.com/api/?v="+encodeURIComponent(game.pgn()));
        if(pgnEl.length)
          pgnEl.scrollTop(pgnEl[0].scrollHeight - pgnEl.height());

        if (game.pgn()){
           $('#QRandButton').removeAttr('style');
           createQR(game.pgn());
         }

        if ($.trim(pgnEl.val()).length < 1){
            undoBtn.attr("disabled", "disabled");
        }else{
            undoBtn.removeAttr("disabled");
        }

      };

      var unreadableClick = function() {
          $('#containerQrCode').empty().qrcode({
              // https://larsjung.de/jquery-qrcode/
              render: 'image',
              ecLevel: 'H',
              size: 300,
              fill: '#2d3e4e',
              mode: 4,
              mSize: 0.1,
              radius: 0.5,
              quiet: 0,
              text: game.pgn(),
              image: $('#img-buffer')[0]
              });
      };

      var createQR = function(string){
          $('#containerQrCode').empty().qrcode({
              // https://larsjung.de/jquery-qrcode/
              render: 'image',
              ecLevel: 'Q',
              size: 300,
              fill: '#2d3e4e',
              mode: 4,
              mSize: 0.1,
              radius: 0.5,
              quiet: 0,
              text: string,
              image: $('#img-buffer')[0]
              });
      };

      var startClick = function(){
        board.start();
        game.reset();
        updateStatus(null);
        $('#QRandButton').attr('style','display: none;');
      };

      var flipClick = function(){
        board.flip();
        updateStatus(null);
      };

      var undoMove = function(){
        game.undo();
        board.position(game.fen());
        updateStatus(null);
        if (game.fen() == "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1") {
          $('#QRandButton').attr('style','display: none;');
        }
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
        createQR(game.pgn());
        $('#QRandButton').removeAttr('style');
        undoBtn.removeAttr("disabled");

        var strPgnClean = game.pgn();
        var strPgnClean = $.trim(strPgnClean.replace(/\[.*\]/g,''));

        pgnLink.text("http://diagramchess.com/api/?v="+encodeURIComponent(strPgnClean));
        pgnLink.attr("href", "http://diagramchess.com/api/?v="+encodeURIComponent(strPgnClean));
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
