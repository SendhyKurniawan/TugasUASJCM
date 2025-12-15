<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Project UAS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* --- CSS CLEAN, WHITE, GREY & BLUE ONLY --- */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            display: flex; 
            height: 100vh; 
            overflow: hidden; 
            background-color: #f8f9fa; /* Abu-abu sangat muda (Hampir putih) */
            color: #4a5568; /* Abu-abu Gelap (Slate) */
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 280px;
            background-color: #ffffff; /* Putih Bersih */
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
            border-right: 1px solid #e2e8f0; /* Garis pemisah abu tipis */
            z-index: 10;
        }

        /* Judul Sidebar */
        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #2d3748; /* Abu-abu Tua */
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            padding-bottom: 20px;
            border-bottom: 1px solid #edf2f7;
            transition: color 0.2s;
        }

        .sidebar h2:hover {
            color: #3182ce; /* Biru saat dihover */
        }

        /* Tombol Menu */
        .menu-btn {
            background: transparent;
            border: none;
            color: #718096; /* Abu-abu Medium */
            padding: 12px 15px;
            text-align: left;
            cursor: pointer;
            margin-bottom: 5px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        /* Efek Hover (Abu-abu Kebiruan) */
        .menu-btn:hover {
            background-color: #edf2f7; 
            color: #2b6cb0; /* Biru Gelap */
        }

        /* Efek Aktif (Biru Soft) */
        .menu-btn.active {
            background-color: #ebf8ff; /* Biru Sangat Muda */
            color: #3182ce; /* Biru Standar */
            font-weight: 600;
        }

        .menu-btn span { margin-left: 12px; }

        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa; /* Samakan dengan body */
        }

        /* --- LAYAR GAME (IFRAME) --- */
        .game-frame {
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            border: 1px solid #e2e8f0; /* Border tipis */
            border-radius: 12px; /* Rounded tidak terlalu tumpul */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); /* Shadow sangat halus */
        }

        /* Footer */
        .footer {
            margin-top: auto;
            text-align: center;
            font-size: 12px;
            color: #a0aec0; /* Abu-abu terang */
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2 onclick="kembaliKeHome()" title="Klik untuk ke Home">🎮 WALZ GAMING</h2>
        
        <button class="menu-btn" onclick="bukaGame(this, 'tugas_tictactoe/index.php')">
             <span>Tic Tac Toe</span>
        </button>
        
        <button class="menu-btn" onclick="bukaGame(this, 'tugas_tebakangka/index.php')">
             <span>AI Tebak Usia</span>
        </button>
        
        <button class="menu-btn" onclick="bukaGame(this, 'tugas_tebakangka2/index.php')">
             <span>Tebak Angka</span>
        </button>
        
        <button class="menu-btn" onclick="bukaGame(this, 'tugas_tebakkalimat/index.php')">
             <span>Tebak Kalimat</span>
        </button>
        
        <button class="menu-btn" onclick="bukaGame(this, 'tugas_suit/suit.php')">
             <span>Game Suit</span>
        </button>

        <div class="footer">
            UAS Jaringan Cerdas<br>Punya Syawal
        </div>
    </div>

    <div class="main-content">
        <iframe src="welcome.php" id="layarGame" class="game-frame"></iframe>
    </div>

    <script>
        // Fungsi ganti game
        function bukaGame(tombol, url) {
            // 1. Ganti sumber iframe
            document.getElementById('layarGame').src = url;

            // 2. Reset semua tombol jadi tidak aktif
            let semuaTombol = document.querySelectorAll('.menu-btn');
            semuaTombol.forEach(btn => btn.classList.remove('active'));

            // 3. Aktifkan tombol yang diklik
            tombol.classList.add('active');
        }

        // Fungsi Klik Judul (Balik ke Welcome)
        function kembaliKeHome() {
            // 1. Balikkan iframe ke welcome.php
            document.getElementById('layarGame').src = 'welcome.php';

            // 2. Hilangkan warna aktif dari semua tombol menu
            let semuaTombol = document.querySelectorAll('.menu-btn');
            semuaTombol.forEach(btn => btn.classList.remove('active'));
        }
    </script>

</body>
</html>