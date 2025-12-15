<?php
session_start();
if (!isset ($_SESSION['target'])) {
    $_SESSION['target'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
    $_SESSION['difficulty'] = 'normal';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Game Cerdas - Tebak Angka</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            align-items: center;
            background: #f5f5f5;
            padding: 50px;
        }
        h1 {
            color: #2b5876;
        }
        .card {
            background: #fff;
            padding: 20px;
            margin: auto;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,2);
        }
        input {
            padding: 8px;
            font-size: 16px;
            width: 100px;
            text-align: center;
        }
        button {
            padding: 8px 20px;
            font-size: 16px;
            margin-top: 10px;
            background: #6025d8;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #4e4376;
        }
        .result {
            margin-top: 15px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🎯 Game Cerdas - Tebak Angka</h1>
        <p>Tebak angka antara <b>1- 100</b></p>

        <form action="process.php" method="post">
            <input type="number" name="guess" min="1" max="100" required autofocus>
            <br>
            <button type="submit">Tebak!</button>
        </form>

        <form action="reset.php" method="post">
            <button type="submit" style="background: #b33; margin-top: 10px;">Reset Permainan</button>
        </form>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="result"><?=$_SESSION['message']?></div>
        <?php endif; ?>
    </div>
</body>
</html>