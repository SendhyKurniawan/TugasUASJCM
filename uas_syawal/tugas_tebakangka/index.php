<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tebak Usia AI</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* RESET SEDERHANA */
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%); /* Background Gradasi Soft */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        /* KARTU UTAMA */
        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); /* Bayangan halus */
            text-align: center;
            max-width: 500px;
            width: 100%;
            transition: transform 0.3s;
        }

        .container:hover {
            transform: translateY(-5px); /* Efek naik dikit pas di-hover */
        }

        h1 {
            color: #6a11cb;
            margin-bottom: 10px;
            font-size: 2rem;
        }

        p {
            color: #666;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        /* TOMBOL-TOMBOL */
        button {
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.2s;
            margin: 5px;
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        button:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        /* Warna Spesifik Tombol */
        #startBtn { background: #6a11cb; width: 100%; }
        #lowerBtn { background: #ff9f43; } /* Orange */
        #higherBtn { background: #54a0ff; } /* Biru Muda */
        #correctBtn { background: #1dd1a1; } /* Hijau */

        /* AREA GAME */
        #game {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        #guessText {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        /* HASIL & ANIMASI */
        #output {
            margin-top: 20px;
            font-weight: bold;
            color: #6a11cb;
        }

        .robot { font-size: 80px; margin-bottom: 10px; }
        .celebrate-text {
            font-size: 1.5rem;
            font-weight: 800;
            color: #ff9f43;
            text-transform: uppercase;
        }

        /* Animasi Simpel buat Robot */
        @keyframes dance {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(10deg); }
            75% { transform: rotate(-10deg); }
            100% { transform: rotate(0deg); }
        }
        .dancing { animation: dance 0.8s infinite ease-in-out; }

    </style>
</head>
<body>

    <div class="container">
        <h1>🤖 AI Tebak Usia</h1>
        <p>Pikirkan angkanya (1-100), biarkan saya menebaknya!</p>
        
        <button id="startBtn">Mulai Main</button>

        <div id="game" style="display:none;">
            <p id="guessText">...</p>
            <div>
                <button id="lowerBtn">Lebih Muda 👇</button>
                <button id="correctBtn">Benar! ✅</button>
                <button id="higherBtn">Lebih Tua 👆</button>
            </div>
        </div>

        <div id="output"></div>
        
        <div id="celebration" style="display:none; margin-top: 20px;">
            <div class="robot dancing">🤖</div>
            <div class="celebrate-text">Hore! Aku Menang!</div>
        </div>
    </div>

    <script>
        // LOGIKA GAME (Tetap sama, cuma JS-nya jadi lebih bersih)
        let min, max, steps, guess;

        const startBtn = document.getElementById('startBtn');
        const gameDiv = document.getElementById('game');
        const guessText = document.getElementById('guessText');
        const lowerBtn = document.getElementById('lowerBtn');
        const higherBtn = document.getElementById('higherBtn');
        const correctBtn = document.getElementById('correctBtn');
        const output = document.getElementById('output');
        const celebration = document.getElementById('celebration');

        function makeGuess() {
            guess = Math.floor((min + max) / 2);
            steps++;
            guessText.textContent = `Apakah usiamu ${guess} tahun?`;
        }

        startBtn.addEventListener('click', () => {
            min = 1; max = 100; steps = 0;
            gameDiv.style.display = 'flex';
            startBtn.style.display = 'none'; // Sembunyikan tombol mulai
            output.textContent = '';
            celebration.style.display = 'none';
            makeGuess();
        });

        lowerBtn.addEventListener('click', () => {
            max = guess - 1;
            if (min > max) return errorGame();
            makeGuess();
        });

        higherBtn.addEventListener('click', () => {
            min = guess + 1;
            if (min > max) return errorGame();
            makeGuess();
        });

        correctBtn.addEventListener('click', () => {
            gameDiv.style.display = 'none';
            startBtn.style.display = 'block'; // Tampilkan lagi tombol mulai
            startBtn.textContent = "Main Lagi?";
            output.innerHTML = `Tebakan benar: <b>${guess} tahun</b><br>Dalam ${steps} langkah.`;
            celebration.style.display = 'block';
        });

        function errorGame() {
            gameDiv.style.display = 'none';
            startBtn.style.display = 'block';
            output.innerHTML = "<span style='color:red'>Kamu curang ya? Angkanya gak masuk akal! 😤</span>";
        }
    </script>

</body>
</html>