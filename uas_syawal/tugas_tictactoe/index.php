<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Cerdas Tic Tac Toe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- STYLE GLOBAL --- */
        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 450px;
            width: 100%;
            transition: transform 0.3s;
        }

        h1 {
            color: #6a11cb;
            margin-bottom: 5px;
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* --- KONTROL GAME --- */
        .controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        select {
            padding: 8px 15px;
            border-radius: 50px;
            border: 2px solid #e0e0e0;
            font-family: 'Poppins', sans-serif;
            outline: none;
            cursor: pointer;
        }

        .btn-reset {
            padding: 8px 20px;
            border-radius: 50px;
            border: none;
            background: #ff6b6b;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-reset:hover { transform: scale(1.05); }

        /* --- PAPAN GAME (GRID) --- */
        #game {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            gap: 10px;
            justify-content: center;
            margin: 20px auto;
        }

        .cell {
            width: 100px;
            height: 100px;
            background: #f8f9fa;
            border-radius: 15px;
            font-size: 3.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            color: #333; /* Default */
        }

        .cell:hover {
            background: #e9ecef;
            transform: scale(1.05);
        }

        /* Warna X dan O */
        .cell.x-mark { color: #6a11cb; } /* Ungu */
        .cell.o-mark { color: #ff9f43; } /* Orange */

        #message {
            font-weight: 600;
            color: #6a11cb;
            margin-bottom: 10px;
            min-height: 24px;
        }

        /* --- TOMBOL MAIN LAGI --- */
        #btnPlayAgain {
            padding: 10px 30px;
            border-radius: 50px;
            border: none;
            background: #1dd1a1;
            color: white;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(29, 209, 161, 0.3);
            margin-top: 10px;
            display: none; /* Hidden by default */
        }

        /* --- SCOREBOARD --- */
        #scoreboard {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            background: #f1f2f6;
            padding: 15px;
            border-radius: 15px;
            gap: 5px;
        }

        .score-item {
            display: flex;
            flex-direction: column;
            width: 33%;
        }

        .score-label { font-size: 0.8rem; color: #777; }
        .score-val { font-size: 1.2rem; font-weight: bold; color: #333; }
        .win { color: #1dd1a1; }
        .lose { color: #ff6b6b; }
    </style>
</head>
<body>

    <div class="container">
        <h1>❌ Tic Tac Toe ⭕</h1>
        
        <div class="controls">
            <select id="mode">
                <option value="easy">Easy (Gampang)</option>
                <option value="hard">Hard (Mustahil)</option>
            </select>
            <button id="reset" class="btn-reset">Reset 🔄</button>
        </div>

        <div id="message">Memulai permainan...</div>

        <div id="game"></div>

        <div id="playAgain" style="display:none; text-align:center;">
            <button id="btnPlayAgain">Main Lagi 🎮</button>
        </div>

        <div id="scoreboard">
            <div class="score-item">
                <span class="score-label">MENANG</span>
                <span class="score-val win" id="winCount">0</span>
            </div>
            <div class="score-item">
                <span class="score-label">SERI</span>
                <span class="score-val" id="drawCount">0</span>
            </div>
            <div class="score-item">
                <span class="score-label">KALAH</span>
                <span class="score-val lose" id="loseCount">0</span>
            </div>
        </div>
    </div>

    <script>
        function initBoard() {
            const game = document.getElementById("game");
            game.innerHTML = "";
            for (let i = 0; i < 9; i++) {
                const cell = document.createElement("div");
                cell.classList.add("cell");
                cell.dataset.index = i;
                cell.addEventListener("click", () => makeMove(i));
                game.appendChild(cell);
            }
        }

        function loadGame() {
            fetch("session_reset.php", {
                method: "POST",
                body: new URLSearchParams({ mode: document.getElementById("mode").value })
            })
            .then(res => res.json())
            .then(data => updateUI(data))
            .catch(err => console.error("Error loading game:", err));
        }

        function makeMove(index) {
            fetch("process_move.php", {
                method: "POST",
                body: new URLSearchParams({ index })
            })
            .then(res => res.json())
            .then(data => updateUI(data))
            .catch(err => console.error("Error making move:", err));
        }

        function updateUI(data) {
            document.getElementById("message").textContent = data.message;
            
            const cells = document.querySelectorAll(".cell");
            cells.forEach((cell, i) => {
                cell.textContent = data.board[i];
                
                // Styling warna X dan O
                cell.classList.remove("x-mark", "o-mark");
                if (data.board[i] === "X") cell.classList.add("x-mark");
                if (data.board[i] === "O") cell.classList.add("o-mark");

                // Disable klik kalau game over
                cell.style.pointerEvents = data.gameover || data.board[i] !== "" ? "none" : "auto";
            });

            // Tombol Main Lagi
            const btnPlayAgain = document.getElementById("playAgain");
            btnPlayAgain.style.display = data.gameover ? "block" : "none";

            document.getElementById("winCount").textContent = data.score.win;
            document.getElementById("drawCount").textContent = data.score.draw;
            document.getElementById("loseCount").textContent = data.score.lose;
        }

        document.getElementById("reset").addEventListener("click", loadGame);
        document.getElementById("btnPlayAgain").addEventListener("click", loadGame);

        initBoard();
        loadGame();
    </script>
</body>
</html>