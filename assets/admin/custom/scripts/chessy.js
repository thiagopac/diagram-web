function Chessy(cfg) {
	this.board = new ChessBoard('board', cfg);
	this.game = new Chess();
}

Chessy.prototype.orientation = function() {
	return this.board.orientation();
};

Chessy.prototype.move = function(nextMove) {
	var move_obj = this.game.move(nextMove);

	// $('.square-55d63.highlightLastMove').removeClass('highlightLastMove');
	// $('.square-' + move_obj.from).addClass('highlightLastMove');
	// $('.square-' + move_obj.to).addClass('highlightLastMove');

	console.log("chessy.js 17: "+nextMove);

	if (move_obj == null) {
		console.log("20: "+move_obj);
		return null;
	}

	var move_string = move_obj.from + "-" + move_obj.to;

	if (move_obj.san == 'O-O' || move_obj.san == 'O-O-O' || move_obj.san[2] == '=' || move_obj.san[1] == 'x') {
		this.board.position(this.game.fen());
	} else {
		this.board.move(move_string);
	}
	return move_obj;
};

Chessy.prototype.moves = function(moveArray) {
	var move_obj;
	for (var i = 0; i < moveArray.length; ++i) {
		move_obj = this.game.move(moveArray[i]);
	}
	// $('.square-55d63.highlightLastMove').removeClass('highlightLastMove');
	// $('.square-' + move_obj.from).addClass('highlightLastMove');
	// $('.square-' + move_obj.to).addClass('highlightLastMove');

	this.board.position(this.game.fen());
	return move_obj;
};

Chessy.prototype.flip = function() {
	this.board.flip();
	if (this.game.history().length != 0) {
		var move_obj = this.game.undo();
		// $('.square-' + move_obj.from).addClass('highlightLastMove');
		// $('.square-' + move_obj.to).addClass('highlightLastMove');
		this.game.move(move_obj);
	}
};

Chessy.prototype.undoPlayerMove = function() {
	this.game.undo();
	if (!this.isPlayersTurn() && this.game.history().length != 0)
		this.game.undo();
	this.board.position(this.game.fen());
	// $('.square-55d63.highlightLastMove').removeClass('highlightLastMove');
	// $('.square-55d63.highlightHint').removeClass('highlightHint');
	$("#board").removeClass("transparentBoard");
	this.highlightLastMove();
};

Chessy.prototype.undoOneMove = function() {
	this.game.undo();
	this.board.position(this.game.fen());
	// $('.square-55d63.highlightLastMove').removeClass('highlightLastMove');
	// $('.square-55d63.highlightHint').removeClass('highlightHint');
	$("#board").removeClass("transparentBoard");
	this.highlightLastMove();
};

Chessy.prototype.resize = function() {
	this.board.resize();
	this.highlightLastMove();
};

Chessy.prototype.highlightLastMove = function() {
	if (this.game.history().length != 0) {
		var move_obj = this.game.undo();
		// $('.square-' + move_obj.from).addClass('highlightLastMove');
		// $('.square-' + move_obj.to).addClass('highlightLastMove');
		this.game.move(move_obj);
	}
}

Chessy.prototype.setPosition = function(fen) {
	this.board.position(fen);
};

Chessy.prototype.gameIsOver = function() {
	//não deixar o tabuleiro ficar transparente
	// $("#board").addClass("transparentBoard");
};

Chessy.prototype.reset = function() {
	this.board.start();
	this.game.reset();
	// $('.square-55d63.highlightLastMove').removeClass('highlightLastMove');
	// $('.square-55d63.highlightHint').removeClass('highlightHint');
	$("#board").removeClass("transparentBoard");
};

Chessy.prototype.history = function() {
	return this.game.history();
};

Chessy.prototype.isPlayersTurn = function() {
	if (this.board.orientation() == 'white' && this.game.turn() == 'b') return false;
	if (this.board.orientation() == 'black' && this.game.turn() == 'w') return false;
	return true;
};

Chessy.prototype.hintSmall = function(move) {
	var move_obj = this.game.san_to_obj(move);
	$(".square-"+move_obj.from + " > img").effect("highlight", {}, 1000);
};

Chessy.prototype.hintBig = function(move) {
	var move_obj = this.game.san_to_obj(move);
	$(".square-"+move_obj.from + " > img").effect("highlight", {}, 1000);

	//após a primeira dica, é possível colocar marcado a casa inicial e final da peça, dando dica do movimento completo
	// $('.square-' + move_obj.from).addClass('highlightHint');
	// $('.square-' + move_obj.to).addClass('highlightHint');
};

Chessy.prototype.isGameOver = function() {
	return this.game.game_over();
};

Chessy.prototype.greySquare = function(square) {
	var squareEl = $('#board .square-' + square);

	// var background = 'url("../../assets/admin/custom/img/assets/select.png")';
	var background = '#e3e7a8';

	var backgroundsize = 'contain';
	if (squareEl.hasClass('black-3c85d') === true) {
		// var background = 'url("../../assets/admin/custom/img/assets/select2.png")';
		background = '#f8fbc1';
	}

	squareEl.css('background', background);
	squareEl.css('background-size', backgroundsize);
	squareEl.addClass('taphover');
}

Chessy.prototype.removeGreySquares = function() {
	$('#board .square-55d63').css('background', '');
};
