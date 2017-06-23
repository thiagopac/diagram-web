var selectedOpeningBook = [];
var cfg = {
	pieceTheme: '../../assets/admin/custom/img/chesspieces/alpha/{piece}.png',
	showNotation: false,
	draggable: true,
	position: 'start',
	onDragStart: onDragStart,
	onDrop: onDrop,
	onSnapEnd: onSnapEnd,
	onMouseoverSquare: onMouseoverSquare,
	onMouseoutSquare: onMouseoutSquare
};

var chessy = new Chessy(cfg);
var gameover = false;
var timesHintAsked = 0;
var perfectLine = true;
var updatedHistory = false;
var currentLine = "";
var nextMove = "";
var moveBlock = false;
var currentOpening = '';
var doRepeat = false;
var mistakesCount = 0;
var perfectLineCount = 0;

function Line(moves, timeDue, nextBox) {
	this.moves = moves;
	this.timeDue = timeDue;
	this.nextBox = nextBox;
}

function openingClass() {

	//fazer a inserção no array da abertura selecionada
	selectedOpeningBook.push(ecoPracticeLine);

	console.log(ecoPracticeLine);

	this.whiteOpeningLines = [];
	this.blackOpeningLines = [];
	this.timeToNextShowing = [25000, 120000, 600000, 3600000, 18000000, 86400000, 432000000, 2160000000, 10800000000, 54000000000, 270000000000];
	this.candidateLines = [];
	this.unseenLineTime = 0;
	this.whiteLinesReverse = {};
	this.blackLinesReverse = {};
	this.updateTimer = '';

	var openingObj = this;
	// Load the Opening chockablock with lines
	var d = new Date();
	this.unseenLineTime = d.getTime() + 315360000000;

	console.log(diagramLines);

	$.each(diagramLines, function(parentLine) {
		$.each(diagramLines[parentLine], function(innerLineIndex, childLine) {
			var newline = new Line(childLine, openingObj.unseenLineTime, 0);
			openingObj.whiteOpeningLines.push(newline);

			if (!(childLine in openingObj.whiteLinesReverse)) openingObj.whiteLinesReverse[childLine] = [];
			openingObj.whiteLinesReverse[childLine].push(parentLine);
		});
	});
	$.each(diagramLines, function(parentLine) {
		$.each(diagramLines[parentLine], function(innerLineIndex, childLine) {
			var newline = new Line(childLine, openingObj.unseenLineTime, 0);
			openingObj.blackOpeningLines.push(newline);

			if (!(childLine in openingObj.blackLinesReverse)) openingObj.blackLinesReverse[childLine] = [];
			openingObj.blackLinesReverse[childLine].push(parentLine);
		});
	});

	// Remove duplicate lines
	this.whiteOpeningLines = unique_array(this.whiteOpeningLines);
	this.blackOpeningLines = unique_array(this.blackOpeningLines);

	// A shuffle both randomizes lines shown to the player, and makes it much more likely to find possible lines
	// faster - a performance boost
	shuffle(this.whiteOpeningLines);
	shuffle(this.blackOpeningLines);

	//flip and start quando o usuário tiver escolhido uma defesa para jogar de pretas

	if(side == "B"){
		this.flipAndStart();
	}

	this.loadCandidateLines(selectedOpeningBook);

	this.updateDueLines();

	var self = this;
	this.updateTimer = setInterval(function() { self.updateDueLines(); },8000);
}

	openingClass.prototype.destroy = function() {
	clearInterval(this.updateTimer);

	delete this.whiteOpeningLines;
	delete this.blackOpeningLines;
	delete this.timeToNextShowing;
	delete this.candidateLines;
	this.unseenLineTime = 0;
	delete this.whiteLinesReverse;
	delete this.blackLinesReverse;
	this.updateTimer = '';
};

openingClass.prototype.loadCandidateLines = function(openings) {

	this.candidateLines = [];
	var openingObj = this;
	$.each(openings, function(openingindex, openingdata) {
		if (chessy.orientation() == 'white') {
			if (!(openingdata in diagramLines)) return true; // continue
			$.each(diagramLines[openingdata], function(lineindex, linedata) {
				openingObj.candidateLines.push(linedata);
			});
		} else if (chessy.orientation() == 'black') {
			if (!(openingdata in diagramLines)) return true; // continue
			$.each(diagramLines[openingdata], function(lineindex, linedata) {
				openingObj.candidateLines.push(linedata);
			});
		}
	});
	shuffle(this.candidateLines);
};

openingClass.prototype.getNextLine = function() {
	var openingObj = this;
	var ret = null;
	var OpeningLines;
	if (chessy.orientation() == 'white') OpeningLines = this.whiteOpeningLines;
	if (chessy.orientation() == 'black') OpeningLines = this.blackOpeningLines;
	$.each(OpeningLines, function(lineindex, linedata) {
		// if line is due before this time and is also in the candidate lines, return it
		var d = new Date();
		var thetime = d.getTime();

		$.each(openingObj.candidateLines, function(candidatelineindex, candidatelinedata) {
			if (linedata.moves == candidatelinedata) {
				if (linedata.timeDue < thetime || linedata.timeDue == openingObj.unseenLineTime) {
					ret = candidatelinedata;
					return false; // break
				}
			}
		});

		if (ret != null) return false; // break
	});
	if (ret != null) return ret;

	// If there's no line waiting to be made, return a random one from the candidate lines
	if (this.candidateLines.length == 0) return null;
	var anyAvailable = this.candidateLines[Math.floor(Math.random()*this.candidateLines.length)];
	return anyAvailable;
};

openingClass.prototype.getAllDoneLines = function() {
	var whitelines = [];
	var blacklines = [];
	var openingObj = this;
	var d = new Date();
	$.each(this.whiteOpeningLines, function(lineindex, linedata) {
		if (linedata.timeDue < d.getTime() + 31536000000) {
			whitelines.push(linedata);
		}
	});
	$.each(this.blackOpeningLines, function(lineindex, linedata) {
		if (linedata.timeDue < d.getTime() + 31536000000) {
			blacklines.push(linedata);
		}
	});
	return [whitelines, blacklines];
}

openingClass.prototype.hasMoreLinesDue = function(openings) {
	if (openings == null) return false;
	if (openings.length == 0) return false;

	var openingObj = this;
	var moreLinesDue = false;
	var OpeningLines;
	if (chessy.orientation() == 'white') OpeningLines = this.whiteOpeningLines;
	if (chessy.orientation() == 'black') OpeningLines = this.blackOpeningLines;
	$.each(OpeningLines, function(lineindex, linedata) {
		// if line is due before this time and is also in the candidate lines, return it
		var d = new Date();
		var thetime = d.getTime();

		$.each(openingObj.candidateLines, function(candidatelineindex, candidatelinedata) {
			if (linedata.moves == candidatelinedata) {
				if (linedata.timeDue < thetime || linedata.timeDue == openingObj.unseenLineTime) {
					moreLinesDue = true;
					return false; // break
				}
			}
		});

		if (moreLinesDue == true) return false; // break
	});
	return moreLinesDue;
};

openingClass.prototype.doneLine = function(line, wasPerfect) {
	var OpeningLines;
	if (chessy.orientation() == 'white') OpeningLines = this.whiteOpeningLines;
	if (chessy.orientation() == 'black') OpeningLines = this.blackOpeningLines;

	var lineIndex = -1;
	for (var i = 0; i < OpeningLines.length; i++) {
		if (OpeningLines[i].moves == line ) {
			lineIndex = i;
			break;
		}
	}

	var d = new Date();
	var theTime = d.getTime();
	var wasKnownBefore = (OpeningLines[lineIndex].nextBox > 0);
	if ((OpeningLines[lineIndex].timeDue < theTime || OpeningLines[lineIndex].timeDue == this.unseenLineTime) && wasPerfect) {
		OpeningLines[lineIndex].nextBox++;
		OpeningLines[lineIndex].timeDue = theTime + this.timeToNextShowing[OpeningLines[lineIndex].nextBox];
	} else if (OpeningLines[lineIndex].timeDue >= theTime && wasPerfect) {
		// Do nothing
	} else if (!wasPerfect) {
		OpeningLines[lineIndex].nextBox = 0;
		OpeningLines[lineIndex].timeDue = theTime + this.timeToNextShowing[OpeningLines[lineIndex].nextBox];
	}

	$("#timeTillShown").text(millisecondsToString(OpeningLines[lineIndex].timeDue - theTime));
	if (wasPerfect) {

		perfectLineCount++;
		$("#badge-linhas-perfeitas").text(perfectLineCount);
		pulsateElement("#badge-linhas-perfeitas");
		showToast("success", "Esta linha será apresentada novamente em "+ millisecondsToString(OpeningLines[lineIndex].timeDue - theTime), "Sucesso");

	} else {
		// $("#warning").text("Not yet perfect. Line will be shown again in " + millisecondsToString(this.timeToNextShowing[OpeningLines[lineIndex].nextBox]));
	}

	var lineObject = jQuery.extend({}, OpeningLines[lineIndex]);
	// insert the lineObject into the correct place by its timeDue
	OpeningLines.splice(lineIndex, 1);
	if (lineObject.timeDue < OpeningLines[0].timeDue) {
		OpeningLines.splice(0, 0, lineObject);
	} else if (lineObject.timeDue > OpeningLines[OpeningLines.length-1].timeDue) {
		OpeningLines.splice(OpeningLines.length-1, 0, lineObject);
	} else {
		for (var i = 0; i < OpeningLines.length-1; ++i) {
			if (lineObject.timeDue < OpeningLines[i+1].timeDue && lineObject.timeDue >= OpeningLines[i].timeDue) {
				OpeningLines.splice(i+1, 0, lineObject);
				break;
			}
		}
	}
	if (chessy.orientation() == 'white') this.whiteOpeningLines = OpeningLines;
	if (chessy.orientation() == 'black') this.blackOpeningLines = OpeningLines;


	// Update the number of lines learnt for all openings this line is in
	lineArray = splitStringIntoMoves(line);
	var candidateOpeningLine = '';
	for (var i = 0; i < lineArray.length; ++i) {
		candidateOpeningLine += lineArray[i];
		if (candidateOpeningLine in opening_book) {
			if (chessy.orientation() == 'white') {
				if (!($.inArray(candidateOpeningLine, this.whiteLinesReverse[line]) > -1)) continue;
				if (wasKnownBefore && !wasPerfect) opening_book[candidateOpeningLine][3] -= 1
				if (!wasKnownBefore && wasPerfect) opening_book[candidateOpeningLine][3] += 1
				// also remove 1 due line if it was due
				if (opening_book[candidateOpeningLine][6] >= 1) opening_book[candidateOpeningLine][6]--;
			} else if (chessy.orientation() == 'black') {
				if (!($.inArray(candidateOpeningLine, this.blackLinesReverse[line]) > -1)) continue;
				if (wasKnownBefore && !wasPerfect) opening_book[candidateOpeningLine][4] -= 1
				if (!wasKnownBefore && wasPerfect) opening_book[candidateOpeningLine][4] += 1
				if (opening_book[candidateOpeningLine][6] >= 1) opening_book[candidateOpeningLine][7]--;
			}
		}
	}

	return wasKnownBefore;
};

openingClass.prototype.updateDueLines = function() {
	var openingObj = this;
	var d = new Date();
	var theTime = d.getTime();
	// Set all due lines due to 0
	$.each(opening_book, function(openingindex, openingdata) {
		openingdata[6] = 0;
		openingdata[7] = 0;
	});

	if (chessy.orientation() == 'white') {
		$.each(this.whiteOpeningLines, function(lineindex, linedata) {
			if (openingObj.whiteOpeningLines[lineindex].timeDue > theTime) return false; // break
			$.each(openingObj.whiteLinesReverse[linedata.moves], function(reverseindex, reversedata) {
				opening_book[reversedata][6] += 1;
			});
		});
	} else if (chessy.orientation() == 'black') {
		$.each(this.blackOpeningLines, function(lineindex, linedata) {
			if (openingObj.blackOpeningLines[lineindex].timeDue > theTime) return false; // break
			$.each(openingObj.blackLinesReverse[linedata.moves], function(reverseindex, reversedata) {
				opening_book[reversedata][7] += 1;
			});
		});
	}
};

openingClass.prototype.updateOpening = function(data) {
	var openingObj = this;
	var whiteLines = data[0];
	var blackLines = data[1];

	// Place the downloaded data into the Opening
	$.each(diagramLines, function(dataindex, dataval) {
		var moves = dataval[0];
		var timeDue = dataval[1];
		var nextBox = dataval[2];
		$.each(openingObj.whiteOpeningLines, function(openingIndex, openingVal) {
			if (openingVal.moves == moves) {
				openingVal.timeDue = timeDue;
				openingVal.nextBox = nextBox;
				return false; // break
			}
		});
	});

	openingObj.whiteOpeningLines.sort(function(a, b) {
		return a.timeDue - b.timeDue;
	});
	$.each(diagramLines, function(dataindex, dataval) {
		var moves = dataval[0];
		var timeDue = dataval[1];
		var nextBox = dataval[2];
		$.each(openingObj.blackOpeningLines, function(openingIndex, openingVal) {
			if (openingVal.moves == moves) {
				openingVal.timeDue = timeDue;
				openingVal.nextBox = nextBox;
				return false; // break
			}
		});
	});
	openingObj.blackOpeningLines.sort(function(a, b) {
		return a.timeDue - b.timeDue;
	});

	// Update the history (number learnt)
	$.each(opening_book, function(index) {
		opening_book[index][3] = 0;
		opening_book[index][4] = 0;
	});

	// Write the number of known lines
	$.each(this.whiteOpeningLines, function(lineindex, linedata) {
		if (linedata.nextBox > 0) {
			$.each(openingObj.whiteLinesReverse[linedata.moves], function(reverseindex, reversedata) {
				opening_book[reversedata][3] += 1
			});
		}
	});
	$.each(this.blackOpeningLines, function(lineindex, linedata) {
		if (linedata.nextBox > 0) {
			$.each(openingObj.blackLinesReverse[linedata.moves], function(reverseindex, reversedata) {
				opening_book[reversedata][4] += 1
			});
		}
	});

	this.updateDueLines();
};
openingClass.prototype.print = function() {
	var OpeningLines;
	if (chessy.orientation() == 'white') OpeningLines = this.whiteOpeningLines;
	if (chessy.orientation() == 'black') OpeningLines = this.blackOpeningLines;

	var d = new Date();
	for (var i = 0; i < OpeningLines.length; ++i) {
		var l = OpeningLines[i];
		if (l.timeDue == this.unseenLineTime) break;
		// console.log(l.moves + " " + ((l.timeDue - d.getTime()) / 1000) + " " + l.nextBox);
	}
};

openingClass.prototype.flipAndStart = function() {

	timesHintAsked = 0;
	if (chessy.history().length >= 1) {
		updatedHistory = true; // don't allow the user to win lines after flipping
	}
	chessy.flip();

	this.loadCandidateLines(selectedOpeningBook);
	if (chessy.history().length == 0) {
		currentLine = this.getNextLine(selectedOpeningBook);
		if (currentLine === null) {
			nextMove = '';
		} else {
			nextMove = getNextMove(chessy.history().join(''), currentLine);
		}
	}

	this.updateDueLines();

	if (!isPlayersTurn()) setTimeout(makeOpponentMove, 500);

};
// end Opening

$( window ).resize(function() {
	var viewportWidth = $(window).width();
	var viewportHeight = $(window).height();
	if (viewportWidth < viewportHeight) {
		$("#boardWrap").removeClass("squareByHeight");
		$("#boardWrap").addClass("squareByWidth");
	} else {
		$("#boardWrap").removeClass("squareByWidth");
		$("#boardWrap").addClass("squareByHeight");
	}
	chessy.resize();
});

$("#btnnew").click(function() {
	if( $("img").is(':animated')) return;
	newGame();
});

$("#btnCloseOverlay").click(function() {
	$("#introOverlay").css('display', 'none');
});


$("#btnflip").click(function() {
	if( $("img").is(':animated')) return;
	openingInstance.flipAndStart();
});

$("#btnundo").click(function() {
	if( $("img").is(':animated')) return;
	if (chessy.history().length == 0) return;

	if(gameover == true){
		showAlert("Você chegou ao fim desta linha.");
	}else{
		gameover = false;
		perfectLine = false;
		timesHintAsked = 0;
		$("#btnhint").children('.ui-button-text').removeClass("inProgressBtn");
		chessy.undoPlayerMove();
		updateOpeningText();
		nextMove = getNextMove(chessy.history().join(''), currentLine);
	}
});

function undoMove() {
	if( $("img").is(':animated')) return;
	if (chessy.history().length == 0) return;

	if(gameover == true){
		showAlert("Você chegou ao fim desta linha.");
	}else{
		gameover = false;
		perfectLine = false;
		timesHintAsked = 0;
		$("#btnhint").children('.ui-button-text').removeClass("inProgressBtn");
		chessy.undoPlayerMove();
		updateOpeningText();
		nextMove = getNextMove(chessy.history().join(''), currentLine);
	}
}

$("#btnhint").click(function() {
	if(gameover == true){
		showAlert("Você chegou ao fim desta linha.");
	}else{
		showHint();
	}
});

function newGame() {

	$("#opening").html('&nbsp;');
	if ($("#finishdlg").hasClass('ui-dialog-content'))
		$("#finishdlg").dialog("close");
	if ($("#finishedLine").hasClass('ui-dialog-content'))
		$("#finishedLine").dialog("close");

	chessy.reset();
	mistakesCount = 0;

	if (!updatedHistory && !perfectLine) {
		openingInstance.doneLine(currentLine, false);
		// openingInstance.updateDueLines();
		updatedHistory = true;
	}

	gameover = false;
	perfectLine = true;
	updatedHistory = false;
	timesHintAsked = 0;
	if (!doRepeat) {
		currentLine = openingInstance.getNextLine(selectedOpeningBook);
	}
	doRepeat = false;
	if (currentLine === null) {
		nextMove = '';
	} else {
		nextMove = getNextMove(chessy.history().join(''), currentLine);
	}

	if (!chessy.isPlayersTurn()) setTimeout(makeOpponentMove, 500);
}

function countMoves(s) {
	var countdigits = 0, countos = 0;
	for (var j = 0; j < s.length; ++j) {
		if (s[j] >= '0' && s[j] <= '9') {
			countdigits++;
		} else if (s[j] == 'O') {
			countos++;
		}
	}
	var nummoves = countdigits;
	if (countos == 2 || countos == 3) nummoves++;
	if (countos == 4 || countos == 5 || countos == 6) nummoves++;
	return nummoves;
}

function showHint() {
	if( $("img").is(':animated')) return;

	if (chessy.history().length >= 2) perfectLine = false;
	timesHintAsked += 1;

//atualizar o badge da contagem de dicas
	$("#badge-dicas-recebidas").text(timesHintAsked);
	pulsateElement("#badge-dicas-recebidas");

	if (timesHintAsked == 1) {
		chessy.hintSmall(nextMove);
	} else if (timesHintAsked >= 2) {
		chessy.hintBig(nextMove);
	}
}

function pulsateElement(element){

	if (jQuery().pulsate) {

		$(element).pulsate({
				color: "#399bc3",
				repeat: false
		});
	}
}

function onMouseoverSquare(square, piece) {

	var moves = chessy.game.moves({
		square: square,
		verbose: true
	});

	// exit if there are no moves available for this square
	if (moves.length === 0) return;


	for (var i = 0; i < moves.length; i++) {
		chessy.greySquare(moves[i].to);
	}
}

function onMouseoutSquare(square, piece) {
	 chessy.removeGreySquares();
}

function onDragStart(source, piece) {

	if (gameover) return false;
	if( $("img").is(':animated')) return false;
	if (moveBlock) return false;

	if (nextMove == '') {
		return false;
	}

	var moves = chessy.game.moves({
		square: source,
		verbose: true
	});

	if (moves.length === 0) return false;
	if (chessy.isGameOver()) return false;
	if (!chessy.isPlayersTurn()) return false;


//a função abaixo faz highlight na casa com a peça que será movida
	// chessy.greySquare(source);

	for (var i = 0; i < moves.length; i++) {
		chessy.greySquare(moves[i].to);
	}
}

function sumMoveFreq(a) {
	var c = 0;
	for (var i = 0; i < a.length; ++i) {
		c += a[i][1];
	}
	return c;
}

function onDrop(source, target) {
	// remove grey squares

	$('#board .square-55d63').css('background', '');

	// engineGame.prepareMove();
	chessy.removeGreySquares();

	// see if the move is legal
	var move = chessy.game.move({
		from: source,
		to: target,
		promotion: 'q'
	});

	// illegal move
	if (move === null) return 'snapback';

	// if not most suggested move
	if (nextMove != move['san']) {
		// Perhaps it is from a different selected opening?
		var isFromOtherOpening = false;
		var allMoves = chessy.game.history().join('');
		var candidateOpenings = [];
		for (var i = 0; i < selectedOpeningBook.length; ++i) {
			if (allMoves.length > selectedOpeningBook[i].length) continue;
			var maxLength = Math.min(allMoves.length, selectedOpeningBook[i].length);
			if (allMoves.substring(0, maxLength) == selectedOpeningBook[i].substring(0, maxLength)) {
				// Line can be from selectedOpeningBook[i]
				isFromOtherOpening = true;
				candidateOpenings.push(selectedOpeningBook[i]);
			}
		}

		// is a bad move
		mistakesCount++;
		setTimeout(undoBadMove, 500);

		showToast("warning", "Este não é o movimento correto.", "Atenção");
		$("#badge-erros").text(mistakesCount);
		pulsateElement("#badge-erros");

		//sempre que o usuário errar o movimento, é dado uma dica à ele, e aumenta a contagem
		$("#badge-dicas-recebidas").text(timesHintAsked+1);
		pulsateElement("#badge-dicas-recebidas");

		perfectLine = false;
		return;
	}

	var move_obj = move;

	playSounds(move);
	timesHintAsked = timesHintAsked;
	nextMove = getNextMove(chessy.history().join(''), currentLine);
	updateOpeningText();

	setTimeout(makeOpponentMove, 500);
}

function showToast(type,msg,title) {
	var $toast = toastr[type](msg, title);
}

function onSnapEnd() {
	chessy.setPosition(chessy.game.fen());
}

function playSounds(move) {
	if (move.captured) {
		$('#soundTake').get(0).play();
	} else if (chessy.game.in_check()) {
		$('#soundCheck').get(0).play();
	} else {
		$('#soundMove').get(0).play();
	}
}

function undoBadMove() {
	moveBlock = true;
	setTimeout(function(){ moveBlock = false; }, 800);
	chessy.undoPlayerMove();
	timesHintAsked += 1;
	if (timesHintAsked < 3) {
		setTimeout(function(){chessy.hintSmall(nextMove);}, 400);
	} else {
		setTimeout(function(){chessy.hintBig(nextMove);}, 400);
	}
}

function showMessage(id, title, message) {
	var modal = $('#'+ id);
	modal.find('.modal-title').text(title);
	modal.find('.modal-body').text(message);
	modal.modal('show');
}

function showMessageWithCallback(id, title, message) {

	bootbox.dialog({
			message: message,
			title: title,
			buttons: {
				success: {
					label: "Repetir",
					className: "green",
					callback: function() {
						doRepeat = true;
						setTimeout(newGame, 200);
					}
				},
				main: {
					label: "Próximo",
					className: "blue",
					callback: function() {
						doRepeat = false;
						setTimeout(newGame, 200);
					}
				}
			}
 });
}

function showAlert(message, title){

	bootbox.alert(message);
}

function showFinishLineMessage() {
	if (mistakesCount == 0) {
		$("#numMistakes").text("no mistakes");
	} else if (mistakesCount == 1) {
		$("#numMistakes").text(mistakesCount + " mistake");
	} else {
		$("#numMistakes").text(mistakesCount + " mistakes");
	}

	$('#finishdlg').dialog({
		// dialogClass: "no-close",
		title: "Done!",
		zIndex: 10000,
		width: '220px', resizable: false,
		buttons: {
			"Repeat": function () {
				doRepeat = true;
				setTimeout(newGame, 200);
				$(this).dialog("close");
			},
			"Next": function () {
				doRepeat = false;
				setTimeout(newGame, 200);
				$(this).dialog("close");
			}
		},
		show: {
			effect: "fade",
			duration: 500
		},
		hide: {
			effect: "fade",
			duration: 500,
		}
	});
	$(".ui-button.ui-widget.ui-state-default.ui-corner-all.ui-button-icon-only.ui-dialog-titlebar-close").children(".ui-button-text").remove();
	$(".ui-button.ui-widget.ui-state-default.ui-corner-all.ui-button-icon-only.ui-dialog-titlebar-close").prop('title' ,'');
}

function makeOpponentMove() {
	if (isPlayersTurn()) return;
	if (nextMove === null) return;
	if ($("img").is(':animated')) {
		setTimeout(makeOpponentMove, 500);
		return;
	}

	if (currentLine === null) {
		nextMove = '';
		return;
	}

	var move_obj = chessy.move(nextMove);
	if (move_obj == null) {
		// console.log("1555: "+move_obj);
		showMessage('lineinexistent', 'Attention', '200px');
		undoMove();
	}
	playSounds(move_obj);

	updateOpeningText();

	nextMove = getNextMove(chessy.history().join(''), currentLine);
}

function updateOpeningText() {
	if (chessy.history().join('') in opening_book) {
		currentOpening = opening_book[chessy.history().join('')][0];
		$('#opening').text("ECO Name: "+currentOpening);
	} else if (chessy.history().join('') == '') {
		currentOpening = '';
		$('#opening').text('');
	}
}

function updateSelectedOpeningBook() {
	selectedOpeningBook = [];
	$('.selected > .openingLineName').each(function(i, obj) {
		var text = $(this).text();
		selectedOpeningBook.push(opening_book_moves[text]);
	});
}

// Helper functions

function splitStringIntoMoves(history) {
	moveArray = [];

	while (history.length > 0) {
		if (history.indexOf('O-O-O') == 0) {
			moveArray.push('O-O-O');
			history = history.substring(5);
			continue;
		} else if (history.indexOf('O-O') == 0) {
			moveArray.push('O-O');
			history = history.substring(3);
			continue;
		}

		digitIndex = 0;
		for (var i = 0; i < history.length; ++i) {
			if (history[i] >= '0' && history[i] <= '9') {
				if ((i > 0 && history[i-1] == 'N') || (i > 0 && history[i-1] == 'R')) continue;
				digitIndex = i;
				break;
			}
		}

		if (history.length > digitIndex + 1) {
			if (history[digitIndex+1] == '+' || history[digitIndex+1] == '#') {
				digitIndex += 1;
			}
		}

		// Check for promotions
		if (history.length > digitIndex + 1) {
			if (history[digitIndex+1] == '=') {
				digitIndex += 2;
			}
		}

		moveArray.push(history.substring(0, digitIndex+1));
		history = history.substring(digitIndex+1);
	}
	return moveArray;
}

function getNextMove(history, line) {
	var futureline = line.substring(history.length);
	var splitMoves = splitStringIntoMoves(futureline);

	if (splitMoves.length == 0) {
		// Game over
		chessy.gameIsOver();
		gameover = true;
		$('#soundSuccess').get(0).play();
		if (!updatedHistory) {
			openingInstance.doneLine(chessy.history().join(''), perfectLine);
			updatedHistory = true;
		}
		if (openingInstance.hasMoreLinesDue(selectedOpeningBook)) {
			setTimeout(showMessageWithCallback('finishedLine', 'Atenção', defineFinishedMessage()), 200);
		} else {
			setTimeout(showMessageWithCallback('finishedLine', 'Atenção', defineFinishedMessage()), 200);
		}
		return null;
	}

	return splitMoves[0];
}

function defineFinishedMessage(){

	strFinished = "";

	switch(mistakesCount) {
    case 0:
				strFinished = " sem erros";
        break;
    case 1:
        strFinished = " com 1 erro"
        break;

    default:
        strFinished = " com "+ mistakesCount +" erros";
			}

		strFinished = "Você terminou esta linha" + strFinished;

		if(mistakesCount == 0) {
			switch (timesHintAsked) {
				case 0:
					break;

				case 1:
					strFinished += " mas utilizou "+ timesHintAsked + " dica";
					break;

				default:
					strFinished += " mas utilizou "+ timesHintAsked + " dicas";
					break;
			}
		}

		strFinished += ".";

		return strFinished;
}

function millisecondsToString(ms) {
	var ret = '';
	if (ms < 1000) {
		ret = ms + " milissegundo";
		if (ms > 1) ret += "s";
	} else if (ms < 60000) {
		ret = Math.round(ms / 1000) + " segudo";
		if (Math.round(ms / 1000 > 1)) ret += "s";
	} else if (ms < 3600000) {
		ret = Math.round(ms / 60000) + " minuto";
		if (Math.round(ms / 60000 > 1)) ret += "s";
	} else if (ms < 86400000) {
		ret = Math.round(ms / 3600000) + " hora";
		if (Math.round(ms / 3600000 > 1)) ret += "s";
	} else {
		ret = Math.round(ms / 86400000) + " dia";
		if (Math.round(ms / 86400000 > 1)) ret += "s";
	}
	return ret;
}

function isPlayersTurn() {
	if (chessy.orientation() == 'white' && chessy.game.turn() == 'b') return false;
	if (chessy.orientation() == 'black' && chessy.game.turn() == 'w') return false;
	return true;
}

function rand(min, max) {
	return Math.random() * (max - min) + min;
}

function shuffle(a) {
	var currentIndex = a.length, temporaryValue, randomIndex;
	while (0 !== currentIndex) {
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;
		temporaryValue = a[currentIndex];
		a[currentIndex] = a[randomIndex];
		a[randomIndex] = temporaryValue;
	}
	return a;
}

function unique_array(a) {
	var seen = {};
	return a.filter(function(item) {
		return seen.hasOwnProperty(item.moves) ? false : (seen[item.moves] = true);
	});
}

String.prototype.startsWith = function(needle) {
	return(this.indexOf(needle) == 0);
};


// end helper functions

updateSelectedOpeningBook();
openingInstance = new openingClass();
$(window).trigger('resize');


currentLine = openingInstance.getNextLine(selectedOpeningBook);
nextMove = getNextMove(chessy.history().join(''), currentLine);
