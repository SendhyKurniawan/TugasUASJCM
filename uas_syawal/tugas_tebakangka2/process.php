<?php
session_start();

// Jika permainan belum dimulai, kembalikan ke index
if (!isset($_SESSION['target'])) {
    header('Location: index.php');
    exit;
}

// Pastikan request datang dari form (POST) dan parameter guess ada
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['guess'])) {
    header('Location: index.php');
    exit;
}

// Inisialisasi attempts jika belum ada
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

// Hitung satu percobaan baru
$_SESSION['attempts']++;
$attempts = (int) $_SESSION['attempts'];

$guess = (int) $_POST['guess'];
$target = (int) $_SESSION['target'];
$diff = abs($target - $guess);

$message = "";

// Logika utama untuk membandingkan tebakan dan memberi umpan balik
if ($guess > $target) {
    if ($diff >= 30) $message = "Tebakan Anda: Sangat Jauh (terlalu besar).";
    elseif ($diff >= 10) $message = "Tebakan Anda: Cukup Jauh (terlalu besar).";
    else $message = "Tebakan Anda: Dekat (terlalu besar).";
} elseif ($guess < $target) {
    if ($diff >= 30) $message = "Tebakan Anda: Sangat Jauh (terlalu kecil).";
    elseif ($diff >= 10) $message = "Tebakan Anda: Cukup Jauh (terlalu kecil).";
    else $message = "Tebakan Anda: Dekat (terlalu kecil).";
} else {
    // Kondisi jika tebakan benar
    $message = "<b>Selamat!</b> Anda berhasil menebak angka $target dalam {$attempts} percobaan.";
}

// Simpan pesan ke session untuk ditampilkan di index.php
$_SESSION['message'] = $message;

// Kembalikan pengguna ke halaman index.php
header('Location: index.php');
exit;

?>