<?php
include 'koneksi.php';

// Ambil kalimat acak dari database
$query = "SELECT * FROM kalimat ORDER BY RAND() LIMIT 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$kalimat_asli = strtoupper($data['teks']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tebak Kalimat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- STYLE CLEAN & SIMPLE (Sama kayak Tebak Angka) --- */
        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%); /* Background Gradasi */
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
            max-width: 800px;
            width: 100%;
            transition: transform 0.3s;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        h1 {
            color: #6a11cb;
            margin-bottom: 5px;
            font-size: 2rem;
            font-weight: 700;
        }

        p {
            color: #666;
            margin-bottom: 25px;
        }

        /* Area Nyawa */
        #nyawa {
            font-size: 2rem;
            margin-bottom: 20px;
            letter-spacing: 5px;
        }

        /* Tampilan Soal Kalimat */
        .kalimat {
            font-family: 'Courier New', Courier, monospace; /* Font mesin ketik biar huruf jelas */
            font-size: 2.5rem;
            letter-spacing: 5px;
            font-weight: bold;
            margin: 20px 0 40px 0;
            color: #333;
            word-wrap: break-word;
            border-bottom: 2px dashed #ddd;
            padding-bottom: 20px;
        }

        /* Area Keyboard */
        #keyboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
        }

        /* Tombol Huruf */
        #keyboard button {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            background: #f0f0f0;
            color: #333;
            transition: 0.2s;
            box-shadow: 0 4px 0 #dcdcdc;
            font-family: 'Poppins', sans-serif;
        }

        #keyboard button:hover:not(:disabled) {
            transform: translateY(-2px);
            background: #e0e0e0;
        }

        #keyboard button:active:not(:disabled) {
            transform: translateY(2px);
            box-shadow: 0 0 0 #dcdcdc;
        }

        /* Status Tombol */
        #keyboard button.correct {
            background: #1dd1a1; /* Hijau */
            color: white;
            box-shadow: 0 4px 0 #10ac84;
        }

        #keyboard button.wrong {
            background: #ff6b6b; /* Merah */
            color: white;
            opacity: 0.5;
            box-shadow: none;
            transform: translateY(4px);
        }

        #keyboard button:disabled {
            cursor: default;
        }

        /* Pesan Hasil */
        #hasil {
            margin-top: 25px;
            font-size: 1.2rem;
            min-height: 40px;
            font-weight: 600;
        }

        /* Tombol Reset */
        .btn-restart {
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            background: #6a11cb;
            color: white;
            margin-top: 30px;
            box-shadow: 0 4px 10px rgba(106, 17, 203, 0.3);
            transition: 0.3s;
        }

        .btn-restart:hover {
            transform: scale(1.05);
            background: #5f27cd;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🎭 Tebak Kalimat</h1>
    <p>Pilih huruf di bawah untuk menebak kata.</p>

    <div id="nyawa">❤️❤️❤️</div>
    
    <div id="kalimat" class="kalimat"></div>
    
    <div id="keyboard"></div>
    
    <div id="hasil"></div>

    <button onclick="location.reload()" class="btn-restart">🔄 Main Lagi</button>
</div>

<script>
// ==========================
// INISIALISASI (Logika Original)
// ==========================
const kalimatAsli = "<?= $kalimat_asli ?>";
let tampil = kalimatAsli.replace(/[A-Z]/g, '_'); // sembunyikan huruf
let salah = 0;
let nyawaMaks = 3;

document.getElementById('kalimat').textContent = tampil;
updateNyawa();

// ==========================
// BUAT KEYBOARD
// ==========================
const keyboard = document.getElementById('keyboard');
const huruf = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
for (let i = 0; i < huruf.length; i++) {
    const btn = document.createElement('button');
    btn.textContent = huruf[i];
    btn.onclick = () => tebakHuruf(btn, huruf[i]);
    keyboard.appendChild(btn);
}

// ==========================
// FUNGSI UPDATE NYAWA
// ==========================
function updateNyawa() {
    let hearts = '';
    for (let i = 0; i < nyawaMaks - salah; i++) hearts += '❤️';
    for (let i = 0; i < salah; i++) hearts += '🖤';
    document.getElementById('nyawa').innerHTML = hearts;
}

// ==========================
// FUNGSI TEBAK HURUF
// ==========================
function tebakHuruf(btn, huruf) {
    btn.disabled = true;
    let benar = false;
    let tampilBaru = '';

    for (let i = 0; i < kalimatAsli.length; i++) {
        if (kalimatAsli[i] === huruf) {
            tampilBaru += huruf;
            benar = true;
        } else {
            tampilBaru += tampil[i];
        }
    }

    tampil = tampilBaru;
    document.getElementById('kalimat').textContent = tampil;

    if (benar) {
        btn.classList.add('correct');
    } else {
        btn.classList.add('wrong');
        salah++;
        updateNyawa();
    }

    // ==========================
    // CEK KEMENANGAN
    // ==========================
    if (tampil.indexOf('_') === -1) {
        document.getElementById('hasil').innerHTML = 
            "<span style='color:#1dd1a1;'>🎉 Selamat! Kamu berhasil!</span><br><span style='font-size:0.9em; color:#666;'>Jawaban: " + kalimatAsli + "</span>";
        nonaktifkanKeyboard();
    }

    // ==========================
    // CEK KEKALAHAN
    // ==========================
    if (salah >= nyawaMaks) {
        document.getElementById('hasil').innerHTML = 
            "<span style='color:#ff6b6b;'>💀 Yah, Kesempatan Habis!</span><br><span style='font-size:0.9em; color:#666;'>Jawaban: " + kalimatAsli + "</span>";
        nonaktifkanKeyboard();
    }
}

// ==========================
// NONAKTIFKAN SEMUA TOMBOL
// ==========================
function nonaktifkanKeyboard() {
    const allBtns = document.querySelectorAll('#keyboard button');
    allBtns.forEach(b => b.disabled = true);
}
</script>
</body>
</html>