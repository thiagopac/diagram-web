var game = engineGame({book: '../../assets/admin/custom/scripts/stockfish.js'});

console.log("game: "+game);

function newGame() {
  game.setSkillLevel(1);
  game.setPlayerColor('black');
  game.start();
}


function engineGame(options) {
    options = options || {}
    var engine = new Worker(options.stockfishjs || '../../assets/admin/custom/scripts/stockfish.js');
    var engineStatus = {};
    var time = { wtime: 300000, btime: 300000, winc: 2000, binc: 2000 };
    var playerColor = 'black';
    var isEngineRunning = false;

    // do not pick up pieces if the game is over
    // only pick up pieces for White

    engineGame.uciCmd = function(cmd) {
        engine.postMessage(cmd);
    };

    engineGame.uciCmd('uci');

		engineGame.prepareMove = function(){
			var moves = '';
		  var history = chessy.game.history({verbose: true});
		  for(var i = 0; i < history.length; ++i) {
		      var move = history[i];
		      moves += ' ' + move.from + move.to + (move.promotion ? move.promotion : '');
		  }

			engineGame.uciCmd('position startpos moves' + moves);
			if(engineGame.depth) {
					engineGame.uciCmd('go depth ' + engineGame.depth);
			} else if(engineGame.nodes) {
					engineGame.uciCmd('go nodes ' + engineGame.nodes);
			} else {
					engineGame.uciCmd('go wtime ' + engineGame.wtime + ' winc ' + engineGame.winc + ' btime ' + engineGame.btime + ' binc ' + engineGame.binc);
			}
			isEngineRunning = true;
		};

    engineGame.displayStatus = function() {
        var status = 'Engine: ';
        if(!engineStatus.engineLoaded) {
            status += 'loading...';
        } else if(!engineStatus.engineReady) {
            status += 'loaded...';
        } else {
            status += 'ready.';
        }
        status += ' Book: ' + engineStatus.book;
        if(engineStatus.search) {
            status += '<br>' + engineStatus.search;
            if(engineStatus.score) {
                status += ' Score: ' + engineStatus.score;
            }
        }
        $('#engineStatus').html(status);
    };

    engine.onmessage = function(event) {
        var line = event.data;
        if(line == 'uciok') {
            engineStatus.engineLoaded = true;
        } else if(line == 'readyok') {
            engineStatus.engineReady = true;
        } else {
            var match = line.match(/^bestmove ([a-h][1-8])([a-h][1-8])([qrbk])?/);
            if(match) {
                isEngineRunning = false;
                chessy.game.move({from: match[1], to: match[2], promotion: match[3]});
                engineGame.prepareMove();
            } else if(match = line.match(/^info .*\bdepth (\d+) .*\bnps (\d+)/)) {
                engineStatus.search = 'Depth: ' + match[1] + ' Nps: ' + match[2];
            }
            if(match = line.match(/^info .*\bscore (\w+) (-?\d+)/)) {
                var score = parseInt(match[2]) * (chessy.game.turn() == 'w' ? 1 : -1);
                if(match[1] == 'cp') {
                    engineStatus.score = (score / 100.0).toFixed(2);
                } else if(match[1] == 'mate') {
                    engineStatus.score = '#' + score;
                }
                if(match = line.match(/\b(upper|lower)bound\b/)) {
                    engineStatus.score = ((match[1] == 'upper') == (chessy.game.turn() == 'w') ? '<= ' : '>= ') + engineStatus.score
                }
            }
        }
        engineGame.displayStatus();
    };

    if(options.book) {
        var bookRequest = new XMLHttpRequest();
        bookRequest.open('GET', '../../assets/admin/custom/scripts/stockfish.js', true);
        bookRequest.responseType = "arraybuffer";
        bookRequest.onload = function(event) {
            if(bookRequest.status == 200) {
                engine.postMessage({book: bookRequest.response});
                engineStatus.book = 'ready.';
                engineGame.displayStatus();
            } else {
                engineStatus.book = 'failed!';
                engineGame.displayStatus();
            }
        };
        bookRequest.send(null);
    } else {
        engineStatus.book = 'none';
    }

    return {
        reset: function() {
            game.reset();
            uciCmd('setoption name Contempt Factor value 0');
            uciCmd('setoption name Skill Level value 20');
            uciCmd('setoption name Aggressiveness value 100');
        },
        loadPgn: function(pgn) { game.load_pgn(pgn); },
        setPlayerColor: function(color) {
            playerColor = color;
            board.orientation(playerColor);
        },
        setSkillLevel: function(skill) {
            uciCmd('setoption name Skill Level value ' + skill);
        },
        setTime: function(baseTime, inc) {
            time = { wtime: baseTime * 1000, btime: baseTime * 1000, winc: inc * 1000, binc: inc * 1000 };
        },
        setDepth: function(depth) {
            time = { depth: depth };
        },
        setNodes: function(nodes) {
            time = { nodes: nodes };
        },
        setContempt: function(contempt) {
            uciCmd('setoption name Contempt Factor value ' + contempt);
        },
        setAggressiveness: function(value) {
            uciCmd('setoption name Aggressiveness value ' + value);
        },
        setDisplayScore: function(flag) {
            displayScore = flag;
            engineGame.displayStatus();
        },
        start: function() {
            uciCmd('ucinewgame');
            uciCmd('isready');
            engineStatus.engineReady = false;
            engineStatus.search = null;
            engineGame.displayStatus();
            engineGame.prepareMove();
        },
        undo: function() {
            if(isEngineRunning)
                return false;
            game.undo();
            game.undo();
            engineStatus.search = null;
            engineGame.displayStatus();
            engineGame.prepareMove();
            return true;
        }
    };
}
