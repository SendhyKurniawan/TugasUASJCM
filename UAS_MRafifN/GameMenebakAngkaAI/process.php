<?php 
session_start();

if (!isset($_SESSION['target'])) {
    header("Location: index.php");
    exit;
}

$guess = intval($_POST['guess']);
$_SESSION['attempts']++;

$target = $_SESSION['target'];
$diff = abs($target - $guess);

$message = "";
$mode = $_SESSION['difficulty'];

if ($guess == $target) {
    $message = "🎊 Tepat! Anda menebak angka <b>$target</b> dalam <b>{$_SESSION['attempts']}</b> percobaan.";

    $_SESSION['target'] = rand(1, 100);
    $_SESSION['attempts'] = 0;

    $_SESSION['difficulty'] = ($mode == 'normal') ? 'hard' : 'normal';
} else {
    if ($diff <= 3) $hint = "🔥 Sangat dekat!";
    elseif ($diff <= 10) $hint = "✨ Cukup Dekat!";
    elseif ($diff <= 25) $hint = "🙂 Lumayan Dekat!";
    else $hint = "❄️ Jauh sekali!";

    if ($guess < $target) {
        $message = "$hint Angka terlalu <b>kecil</b>!";
    } else {
        $message = "$hint Angka terlalu <b>besar</b>!";
    }
    
    if ($mode == 'hard' && $_SESSION['attempts'] > 5) {
        $message = "💥 Mode hard aktif!!! Petunjuk terbatas!!.";
    }
}

$_SESSION['message'] = $message;
header("Location: index.php");
exit;