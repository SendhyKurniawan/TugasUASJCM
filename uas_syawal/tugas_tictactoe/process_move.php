<?php
header('Content-Type: application/json');
session_start();

// Inisialisasi session jika belum ada (aman)
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill(0, 9, "");
    $_SESSION['mode'] = 'easy';
    $_SESSION['message'] = 'Permainan baru. Giliran Anda (X).';
    $_SESSION['gameover'] = false;
    $_SESSION['score'] = ['win'=>0,'draw'=>0,'lose'=>0];
}

// Pastikan skor ada
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = ['win'=>0,'draw'=>0,'lose'=>0];
}

// Ambil index dari request
$index = isset($_POST['index']) ? intval($_POST['index']) : null;
$board = $_SESSION['board'];
$mode = isset($_SESSION['mode']) ? $_SESSION['mode'] : 'easy';
    
// Helper: cek pemenang
function checkWinner($b) {
    $wins = [
        [0,1,2],[3,4,5],[6,7,8],
        [0,3,6],[1,4,7],[2,5,8],
        [0,4,8],[2,4,6],
    ];
    foreach ($wins as $w) {
        if ($b[$w[0]] !== "" && $b[$w[0]] === $b[$w[1]] && $b[$w[1]] === $b[$w[2]]) {
            return $b[$w[0]];
        }
    }
    return "";
}

// Jika game sudah over, kembalikan status sekarang
if (!empty($_SESSION['gameover'])) {
    echo json_encode([
        "board" => $board,
        "message" => $_SESSION['message'],
        "gameover" => true,
        "score" => $_SESSION['score']
    ]);
    exit;
}

// Validasi index
if ($index === null || $index < 0 || $index > 8) {
    echo json_encode([
        "board" => $board,
        "message" => "Gerakan tidak valid.",
        "gameover" => $_SESSION['gameover'],
        "score" => $_SESSION['score']
    ]);
    exit;
}

// Jika sel sudah terisi
if ($board[$index] !== "") {
    echo json_encode([
        "board" => $board,
        "message" => "Kotak sudah terisi. Pilih kotak lain.",
        "gameover" => $_SESSION['gameover'],
        "score" => $_SESSION['score']
    ]);
    exit;
}

// --- Letakkan X (aksi pemain) ---
$board[$index] = "X";

// Cek apakah pemain menang
$winner = checkWinner($board);
if ($winner === "X") {
    $_SESSION['score']['win']++;
    $_SESSION['message'] = "Anda menang! 🎉";
    $_SESSION['gameover'] = true;
    $_SESSION['board'] = $board;
    echo json_encode([
        "board" => $board,
        "message" => $_SESSION['message'],
        "gameover" => true,
        "score" => $_SESSION['score']
    ]);
    exit;
}

// Cek seri
if (!in_array("", $board)) {
    $_SESSION['score']['draw']++;
    $_SESSION['message'] = "Seri!";
    $_SESSION['gameover'] = true;
    $_SESSION['board'] = $board;
    echo json_encode([
        "board" => $board,
        "message" => $_SESSION['message'],
        "gameover" => true,
        "score" => $_SESSION['score']
    ]);
    exit;
}

// --- AI Move ---
$placed = false;
$empty = array_keys($board, "");

// Hard mode: AI pintar
if ($mode == 'hard') {
    // 1) Coba menang dulu
    foreach ($empty as $move) {
        $temp = $board;
        $temp[$move] = "O";
        if (checkWinner($temp) === "O") {
            $board[$move] = "O";
            $placed = true;
            break;
        }
    }

    // 2) Jika belum, blok pemain
    if (!$placed) {
        foreach ($empty as $move) {
            $temp = $board;
            $temp[$move] = "X";
            if (checkWinner($temp) === "X") {
                $board[$move] = "O";
                $placed = true;
                break;
            }
        }
    }

    // 3) Ambil tengah jika kosong
    if (!$placed && $board[4] === "") {
        $board[4] = "O";
        $placed = true;
    }

    // 4) Ambil sudut
    if (!$placed) {
        $corners = [0,2,6,8];
        $avail = [];
        foreach ($corners as $c) if ($board[$c] === "") $avail[] = $c;
        if (!empty($avail)) {
            $board[$avail[array_rand($avail)]] = "O";
            $placed = true;
        }
    }

    // 5) Fallback: acak
    if (!$placed && !empty($empty)) {
        $mv = $empty[array_rand($empty)];
        $board[$mv] = "O";
        $placed = true;
    }

} else {
    // Easy mode: acak
    if (!empty($empty)) {
        $mv = $empty[array_rand($empty)];
        $board[$mv] = "O";
    }
}

// Cek hasil setelah AI bergerak
$winner = checkWinner($board);
if ($winner === "O") {
    $_SESSION['score']['lose']++;
    $_SESSION['message'] = "Komputer menang! 🤖";
    $_SESSION['gameover'] = true;
} elseif (!in_array("", $board)) {
    $_SESSION['score']['draw']++;
    $_SESSION['message'] = "Seri!";
    $_SESSION['gameover'] = true;
} else {
    $_SESSION['message'] = "Giliran Anda (X).";
    $_SESSION['gameover'] = false;
}

// Simpan board dan kirim ke client
$_SESSION['board'] = $board;

echo json_encode([
    "board" => $board,
    "message" => $_SESSION['message'],
    "gameover" => $_SESSION['gameover'],
    "score" => $_SESSION['score']
]);
