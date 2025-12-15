<?php
session_start();

// Inisialisasi session jika permainan belum dimulai
if (!isset($_SESSION['target'])) {
    $_SESSION['target'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tebak Angka</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- STYLE CLEAN & SIMPLE (Sama Persis) --- */
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
            max-width: 450px;
            width: 100%;
            transition: transform 0.3s;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        h1 {
            color: #6a11cb;
            margin-bottom: 10px;
            font-size: 2rem;
        }

        p {
            color: #666;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        /* Input Styling */
        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 1.2rem;
            text-align: center;
            outline: none;
            transition: 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        input[type="number"]:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.2);
        }

        /* Tombol */
        button {
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.2s;
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%; /* Tombol lebar penuh */
            margin-bottom: 10px;
        }

        button:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .btn-submit {
            background: #6a11cb; /* Ungu Utama */
        }

        .btn-reset {
            background: #ff6b6b; /* Merah Soft */
        }

        /* Pesan Feedback (Menang/Kalah/Hint) */
        .message-box {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
            border-left: 5px solid #6a11cb;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>🔢 Tebak Angka</h1>
        <p>Saya menyembunyikan angka <b>1 - 100</b>.<br>Coba tebak angkanya!</p>

        <?php
        // Menampilkan pesan session dengan style baru
        if (isset($_SESSION['message'])) {
            echo "<div class='message-box'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        ?>

        <form action="process.php" method="post">
            <input type="number" name="guess" min="1" max="100" placeholder="Masukkan Angka..." required autofocus>
            <button type="submit" class="btn-submit">Tebak Sekarang 🚀</button>
        </form>

        <form action="reset.php" method="post">
            <button type="submit" class="btn-reset">Ulangi Game 🔄</button>
        </form>
    </div>

</body>
</html>