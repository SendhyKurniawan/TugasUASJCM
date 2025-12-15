<?php
header('Content-Type: application/json');
session_start();

// Inisialisasi session jika belum ada
if (!isset($_SESSION['board'])) {
  $_SESSION['board'] = array_fill(0, 9, "");
  $_SESSION['mode'] = 'easy';
  $_SESSION['message'] = 'Permainan baru. Giliran Anda (X).';
  $_SESSION['gameover'] = false;
  $_SESSION['score'] = ['win' => 0, 'draw' => 0, 'lose' => 0];
}

// Pastikan skor ada
if (!isset($_SESSION['score'])) {
  $_SESSION['score'] = ['win' => 0, 'draw' => 0, 'lose' => 0];
}

$index = isset($_POST['index']) ? intval($_POST['index']) : null;
$board = $_SESSION['board'];
$mode = isset($_SESSION['mode']) ? $_SESSION['mode'] : 'easy';

// Cek pemenang
function checkWinner($b) {
  $wins = [
    [0,1,2],[3,4,5],[6,7,8],
    [0,3,6],[1,4,7],[2,5,8],
    [0,4,8],[2,4,6]
  ];
  foreach ($wins as $w) {
    if ($b[$w[0]] !== "" && $b[$w[0]] === $b[$w[1]] && $b[$w[1]] === $b[$w[2]]) {
      return $b[$w[0]];
    }
  }
  return "";
}

// Jika game over, kirim status
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

// Letakkan X
$board[$index] = "X";

// Cek menang
$winner = checkWinner($board);
if ($winner === "X") {
  $_SESSION['score']['win']++;
  $_SESSION['message'] = "Anda menang! 🏆";
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

// --- AI bergerak ---
$placed = false;
$empty = array_keys($board, "");

// Hard mode: try win -> block -> center -> corner -> random
if ($mode === 'hard') {
  // 1) Cek gerakan yang membuat AI menang
  foreach ($empty as $move) {
    $temp = $board;
    $temp[$move] = "O";
    if (checkWinner($temp) === "O") {
      $board[$move] = "O";
      $placed = true;
      break;
    }
  }
  // 2) Jika belum, blok gerakan X yang menang di giliran berikutnya
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
  // 4) Ambil sudut jika tersedia
  if (!$placed) {
    $corners = [0, 2, 6, 8];
    $avail = [];
    foreach ($corners as $c) if ($board[$c] === "") $avail[] = $c;
    if (!empty($avail)) {
      $mv = $avail[array_rand($avail)];
      $board[$mv] = "O";
      $placed = true;
    }
  }
  // 5) Fallback: random dari sisa
  if (!$placed) {
    $empty = array_keys($board, "");
    if (!empty($empty)) {
      $mv = $empty[array_rand($empty)];
      $board[$mv] = "O";
      $placed = true;
    }
  }
} else {
  // Easy mode: random
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

$_SESSION['board'] = $board;

// Kembalikan status ke client
echo json_encode([
  'board' => $board,
  'message' => $_SESSION['message'],
  'gameover' => $_SESSION['gameover'],
  'score' => $_SESSION['score']
]);
?>
