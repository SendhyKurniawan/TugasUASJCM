<?php
include 'koneksi.php';

// Ambil kalimat acak dari database
$query = "SELECT * FROM kalimat ORDER BY RAND() LIMIT 1";
$result = mysqli_query($conn, $query);

// Cek jika database kosong
if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $kalimat_asli = strtoupper($data['teks']);
} else {
    $kalimat_asli = "DATABASE KOSONG";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Game Tebak Kalimat (3 Kesempatan)</title>
<style>
body { 
    font-family: 'Poppins', sans-serif;
    text-align:center; 
    background:#f3f3f3; 
    margin-top:50px; 
}
.container { 
    background:#fff; 
    display:inline-block; 
    padding:30px; 
    border-radius:15px; 
    box-shadow:0 0 10px #bbb; 
    max-width: 600px;
}
h1 { margin-bottom:20px; color: #333; }
.kalimat { 
    font-size:28px; 
    letter-spacing:5px; 
    margin-bottom:20px; 
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
}
button { 
    padding:10px 15px; 
    margin:5px; 
    font-size:18px; 
    cursor:pointer; 
    border:none; 
    border-radius:5px; 
    background:#6025d8;
    color:white; 
    width: 45px;
}
button:disabled { 
    background:#ccc; 
    cursor:not-allowed; 
    color: #666;
}
.btn-control {
    width: auto;
    background: #6c757d;
}
.correct { background:#28a745 !important; color: white !important; }
.wrong { background:#dc3545 !important; color: white !important; }

#hasil { 
    font-size:22px;     
    margin-top:20px; 
    font-weight:bold; 
    min-height: 60px;
}
#nyawa { 
    font-size:24px; 
    margin-bottom:15px; 
}
</style>
</head>
<body>

<div class="container">
    <h1>🔤 Tebak Kalimat 🔤</h1>
    <p>Tebak huruf satu per satu.</p>

    <div id="nyawa"></div>
    <div id="kalimat" class="kalimat"></div>
    
    <div id="keyboard"></div>
    
    <div id="hasil"></div>

    <br>
    <button class="btn-control" onclick="location.reload()">🔄 Main Lagi</button>
</div>

<script>
// ===============================
//          INISIALISASI
// ===============================
const kalimatAsli = "<?= $kalimat_asli ?>";

// LOGIC FIX: Ganti huruf A-Z dengan underscore (_), biarkan spasi tetap spasi
let tampil = kalimatAsli.replace(/[A-Z]/g, '_'); 

let salah = 0;
const nyawaMaks = 3;

// Render awal
document.getElementById('kalimat').textContent = tampil;
updateNyawa();

// ===============================
//          BUAT KEYBOARD
// ===============================
const keyboard = document.getElementById('keyboard');
const huruf = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

for (let i = 0; i < huruf.length; i++) {
    const btn = document.createElement('button');
    btn.textContent = huruf[i];
    btn.onclick = () => tebakHuruf(btn, huruf[i]);
    keyboard.appendChild(btn);
}

//==========FUNGSI UPDATE NYAWA==========
function updateNyawa() {
    let hearts = '';
    // Gambar hati merah (sisa nyawa)
    for (let i = 0; i < nyawaMaks - salah; i++) hearts += '❤️';
    // Gambar hati hitam (nyawa hilang)
    for (let i = 0; i < salah; i++) hearts += '🖤';
    
    document.getElementById('nyawa').innerHTML = hearts;
}

//==========FUNGSI TEBAK HURUF==========
function tebakHuruf(btn, hurufTebakan) {
    btn.disabled = true; // Matikan tombol setelah diklik
    let benar = false;
    let tampilBaru = '';

    // Loop setiap karakter di kalimat asli
    for (let i = 0; i < kalimatAsli.length; i++) {
        // Jika huruf di posisi ini cocok dengan tebakan
        if (kalimatAsli[i] === hurufTebakan) {
            tampilBaru += hurufTebakan; // Buka hurufnya
            benar = true;
        } else {
            // Jika tidak cocok, biarkan karakter yang sudah ada (bisa _ atau huruf yg sdh ditebak)
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

    //==========CEK KEMENANGAN==========
    // Jika tidak ada lagi underscore, berarti menang
    if (tampil.indexOf('_') === -1) {
        document.getElementById('hasil').innerHTML =
            "🎉 <span style='color:green;'>Selamat! Kamu Menang!</span><br>Jawaban: <b>" + kalimatAsli + "</b>";
        nonaktifkanKeyboard();
    }

    //==========CEK KEKALAHAN==========
    if (salah >= nyawaMaks) {
        document.getElementById('hasil').innerHTML =
            "❌ <span style='color:red;'>Game Over!</span><br>Jawabannya adalah:<br><b>" + kalimatAsli + "</b>";
        nonaktifkanKeyboard();
    }
}

//==========NONAKTIFKAN SEMUA TOMBOL==========
function nonaktifkanKeyboard() {
    const allBtns = document.querySelectorAll('#keyboard button');
    allBtns.forEach(b => b.disabled = true);
}
</script>

</body>
</html>