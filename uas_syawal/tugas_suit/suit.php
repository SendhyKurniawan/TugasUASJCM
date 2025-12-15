<?php
// ==========================
// 1. LOGIKA PHP (ORIGINAL)
// ==========================
session_start();

// Pilihan yang Tersedia
$choices = [
    'batu' => '✊ Batu',
    'kertas' => '🖐 Kertas',
    'gunting' => '✌ Gunting'
];

// Inisialisasi & Reset Skor
if (!isset($_SESSION['player_score']) || isset($_POST['reset'])) {
    $_SESSION['player_score'] = 0;
    $_SESSION['computer_score'] = 0;
    $_SESSION['round_message'] = "Siap bermain? Pilih senjatamu!";
    $_SESSION['player_choice'] = '';
    $_SESSION['computer_choice'] = '';
}

// Fungsi Menentukan Pemenang
function determine_winner($player, $computer) {
    if ($player === $computer) {
        return 'seri';
    }
    if (
        ($player === 'batu' && $computer === 'gunting') ||
        ($player === 'gunting' && $computer === 'kertas') ||
        ($player === 'kertas' && $computer === 'batu')
    ) {
        return 'pemain';
    } else {
        return 'komputer';
    }
}

// Proses Pilihan User
if (isset($_POST['choice'])) {
    $player_raw_choice = strtolower($_POST['choice']);

    if (array_key_exists($player_raw_choice, $choices)) {
        // Pilihan Komputer
        $computer_raw_choice = array_rand($choices);
        $winner = determine_winner($player_raw_choice, $computer_raw_choice);

        // Simpan tampilan
        $_SESSION['player_choice'] = $choices[$player_raw_choice];
        $_SESSION['computer_choice'] = $choices[$computer_raw_choice];

        // Update Skor & Pesan
        if ($winner === 'pemain') {
            $_SESSION['player_score']++;
            $_SESSION['round_message'] = "🏆 MENANG! {$choices[$player_raw_choice]} menghajar {$choices[$computer_raw_choice]}.";
        } elseif ($winner === 'komputer') {
            $_SESSION['computer_score']++;
            $_SESSION['round_message'] = "💀 KALAH... {$choices[$computer_raw_choice]} memukul {$choices[$player_raw_choice]}.";
        } else {
            $_SESSION['round_message'] = "🤝 SERI! Sama-sama pilih {$choices[$player_raw_choice]}.";
        }
    }
}

// Ambil variabel session untuk ditampilkan
$player_score = $_SESSION['player_score'];
$computer_score = $_SESSION['computer_score'];
$round_message = $_SESSION['round_message'];
$player_choice_display = $_SESSION['player_choice'];
$computer_choice_display = $_SESSION['computer_choice'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Suit Jepang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- STYLE CLEAN & SIMPLE --- */
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
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
            transition: transform 0.3s;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        h1 {
            color: #6a11cb;
            margin-bottom: 20px;
            font-size: 2rem;
            font-weight: 700;
        }

        /* Scoreboard */
        .score-board {
            display: flex;
            justify-content: space-between;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 25px;
            border: 2px solid #eee;
        }

        .score-box {
            text-align: center;
            width: 48%;
        }

        .score-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
            display: block;
        }

        .score-number {
            font-size: 2rem;
            font-weight: bold;
            color: #6a11cb;
        }

        /* Pesan Hasil */
        .message-box {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            border-left: 5px solid #ffc107;
        }

        /* Tampilan Duel Terakhir */
        .last-move {
            margin-bottom: 25px;
            font-size: 1.1rem;
            color: #555;
            padding: 10px;
            background: #f1f2f6;
            border-radius: 10px;
        }

        /* Tombol Pilihan */
        .choices {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            gap: 10px;
        }

        .choice-btn {
            background: white;
            border: 2px solid #eee;
            border-radius: 15px;
            padding: 15px 10px;
            width: 100px;
            cursor: pointer;
            transition: 0.2s;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #333;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .choice-btn:hover {
            transform: translateY(-5px);
            border-color: #6a11cb;
            background: #fcfcfc;
            color: #6a11cb;
        }

        .choice-btn span {
            display: block;
            font-size: 2rem;
            margin-bottom: 5px;
        }

        /* Tombol Reset */
        .reset-btn {
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            background: #ff6b6b;
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            transition: 0.2s;
        }

        .reset-btn:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🖐 Batu Kertas Gunting</h1>

    <div class="score-board">
        <div class="score-box">
            <span class="score-label">KAMU</span>
            <span class="score-number"><?= $player_score ?></span>
        </div>
        <div class="score-box">
            <span class="score-label">KOMPUTER</span>
            <span class="score-number" style="color: #ff6b6b;"><?= $computer_score ?></span>
        </div>
    </div>

    <div class="message-box">
        <?= htmlspecialchars($round_message) ?>
    </div>

    <?php if ($player_choice_display): ?>
    <div class="last-move">
        Kamu <strong><?= $player_choice_display ?></strong> vs <strong><?= $computer_choice_display ?></strong> Komputer
    </div>
    <?php endif; ?>

    <form method="POST" class="choices">
        <button type="submit" name="choice" value="batu" class="choice-btn">
            <span>✊</span> Batu
        </button>
        <button type="submit" name="choice" value="kertas" class="choice-btn">
            <span>🖐</span> Kertas
        </button>
        <button type="submit" name="choice" value="gunting" class="choice-btn">
            <span>✌</span> Gunting
        </button>
    </form>

    <form method="POST">
        <button type="submit" name="reset" class="reset-btn">Reset Skor 🔄</button>
    </form>
</div>

</body>
</html>