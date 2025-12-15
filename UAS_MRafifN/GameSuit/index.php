<?php
session_start();

$choices = ['batu' => '🪨 Batu', 'kertas' => '📃 Kertas', 'gunting' => '✂️ Gunting'];

if (!isset($_SESSION['player_score']) || isset($_POST['reset'])) {
    $_SESSION['player_score'] = 0;
    $_SESSION['computer_score'] = 0;
    $_SESSION['round_message'] = "Pilih untuk memulai permainan!";
    $_SESSION['player_choice'] = '';
    $_SESSION['computer_choice'] = '';
}

$player_score = $_SESSION['player_score'];
$computer_score = $_SESSION['computer_score'];
$round_message = $_SESSION['round_message'];
$player_choice_display = $_SESSION['player_choice'];
$computer_choice_display = $_SESSION['computer_choice'];

function determine_winner($player, $computer) {
    if ($player === $computer) {
        return 'seri';
    }
    if (
        ($player === 'batu' && $computer === 'gunting') ||
        ($player === 'kertas' && $computer === 'batu') ||
        ($player === 'gunting' && $computer === 'kertas')
    ) {
        return 'pemain';
    } else {
        return 'komputer';
    }    
}

if (isset($_POST['choice'])) {
    $player_raw_choice = strtolower($_POST['choice']);

    if (!array_key_exists($player_raw_choice, $choices)) {
        $_SESSION['round_message'] = "Pilihan tidak valid. Silakan pilih batu, kertas, atau gunting.";
    } else {
        $computer_raw_choice = array_rand($choices);
        $winner = determine_winner($player_raw_choice, $computer_raw_choice);

        $_SESSION['player_choice'] = $choices[$player_raw_choice];
        $_SESSION['computer_choice'] = $choices[$computer_raw_choice];

        if ($winner === 'pemain') {
            $_SESSION['player_score'] ++;
            $_SESSION['round_message'] = "🏅 Anda Menang! {$choices[$player_raw_choice]} mengalahkan {$choices[$computer_raw_choice]}.";
        } elseif ($winner === 'komputer') {
            $_SESSION['computer_score'] ++;
            $_SESSION['round_message'] = "🤖 Anda Kalah. {$choices[$computer_raw_choice]} mengalahkan {$choices[$player_raw_choice]}.";
        } else {
            $_SESSION['round_message'] = "🤝 Hasil seri! Anda berdua memilih {$choices[$player_raw_choice]}.";
        }

        $player_score = $_SESSION['player_score'];
        $computer_score = $_SESSION['computer_score'];
        $round_message = $_SESSION['round_message'];
        $player_choice_display = $_SESSION['player_choice'];
        $computer_choice_display = $_SESSION['computer_choice'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Permainan Batu, Kertas, Gunting (PHP)</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        h1 {
            color: #6025d8;
            margin-bottom: 20px;
        }
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.1em;
            background-color: #e9ecef;
            border: 1px solid #dee2e6;
        }
        .choices {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .choice-btn {
            background-color: #28a745;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .choice-btn:hover {
            background-color: #218838;
        }
        .scoreboard {
            display: flex;
            justify-content: space-around;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #e2e6ea;
        }
        .score {
            font-size: 1.2em;            
        }
        .player-score {
            color: #007BFF;
        }
        .computer-score {
            color: #dc3545;
        }
        .reset-btn {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }
        .reset-btn:hover {
            background-color: #5a6268;
        }
        .last-move {
            margin-top: 20px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>BATU, KERTAS, GUNTING</h1>
    <div class="scoreboard">
        <div class="score player-score">Pemain: <strong><?php echo $player_score; ?></strong></div>
        <div class="score computer-score">Komputer: <strong><?php echo $computer_score; ?></strong></div>
    </div>

    <div class="message">
        <?php echo htmlspecialchars($round_message); ?>
    </div>

    <?php if ($player_choice_display) : ?>
    <div class="last-move">
        Pilihan Anda: <strong><?php echo $player_choice_display; ?></strong>
        <br>
        Pilihan Komputer: <strong><?php echo $computer_choice_display; ?></strong>
    </div>
    <?php endif; ?>

    <h2>Pilih:</h2>
    <form method="post" class="choices">
        <button type="submit" name="choice" value="batu" class="choice-btn">🪨 Batu</button>
        <button type="submit" name="choice" value="kertas" class="choice-btn">📃 Kertas</button>
        <button type="submit" name="choice" value="gunting" class="choice-btn">✂️ Gunting</button>
    </form>
    <form method="post">
        <button type="submit" name="reset" class="reset-btn">🔄 Reset Skor</button>
    </form>
</div>
</body>
</html>