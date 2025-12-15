<?php
// --- LOGIKA DETEKSI HARDWARE (TETAP SAMA) ---
function ps($cmd) {
    return trim(shell_exec("powershell -NoProfile -Command \"$cmd\""));
}

// Ambil Data
$os = ps("(Get-CimInstance Win32_OperatingSystem).Caption");
$cpu = ps("(Get-CimInstance Win32_Processor).Name");
$ramBytes = ps("(Get-CimInstance Win32_ComputerSystem).TotalPhysicalMemory");
$ramGB = round($ramBytes / 1073741824, 2);
$gpu = ps("(Get-CimInstance Win32_VideoController)[1].Name");
$mb = ps("(Get-CimInstance Win32_BaseBoard).Product");
$vramBytes = ps("(Get-CimInstance Win32_VideoController)[1].AdapterRAM");
$vramGB = is_numeric($vramBytes) ? round($vramBytes / 1073741824, 2) . " GB" : "N/A";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>System Specs</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* RESET */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f4f6f9; /* Abu-abu sangat muda */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* --- KARTU UTAMA --- */
        .system-card {
            background: #ffffff;
            width: 100%;
            max-width: 700px; /* Lebar kartu */
            box-shadow: 0 15px 35px rgba(0,0,0,0.05); /* Bayangan soft */
            overflow: hidden; /* Biar sudut rounded rapi */
            border: 1px solid #eef2f5;
        }

        /* --- BAGIAN HEADER (Profil) --- */
        .card-header {
            background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
            padding: 40px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }

        .card-header h1 {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .card-header p {
            color: #7f8c8d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* --- BAGIAN ISI (Spesifikasi) --- */
        .card-body {
            padding: 30px 40px;
        }

        .spec-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f4f4f4;
        }

        .spec-row:last-child {
            border-bottom: none;
        }

        .spec-label {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            color: #555;
            font-size: 0.95rem;
        }

        /* Ikon kecil di sebelah label */
        .icon-box {
            width: 35px;
            height: 35px;
            background: #eef2f5;
            color: #2c3e50;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .spec-value {
            font-weight: 500;
            color: #2c3e50;
            text-align: right;
            font-size: 0.95rem;
            max-width: 300px; 
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

    </style>
</head>
<body>

    <div class="system-card">
        
        <div class="card-header">
            <img src="https://cache.lahelu.com/image-PFAomJsCN-43666" class="profile-img" alt="Foto Profil">
            <h1>AHMAD SYAWAL ANDRIANTO</h1>
            <p>NIM: 2290343007 &bull; KELAS RJ22B</p>
        </div>

        <div class="card-body">
            
            <div class="spec-row">
                <div class="spec-label">
                    Operating System
                </div>
                <div class="spec-value"><?= $os ?></div>
            </div>

            <div class="spec-row">
                <div class="spec-label">
                    Processor (CPU)
                </div>
                <div class="spec-value"><?= $cpu ?></div>
            </div>

            <div class="spec-row">
                <div class="spec-label">
                    Memory (RAM)
                </div>
                <div class="spec-value"><?= $ramGB ?> GB</div>
            </div>

            <div class="spec-row">
                <div class="spec-label">
                    Graphics (GPU)
                </div>
                <div class="spec-value"><?= $gpu ?></div>
            </div>

            <div class="spec-row">
                <div class="spec-label">
                    Video Memory
                </div>
                <div class="spec-value"><?= $vramGB ?></div>
            </div>

            <div class="spec-row">
                <div class="spec-label">
                    Motherboard
                </div>
                <div class="spec-value"><?= $mb ?></div>
            </div>

        </div>
    </div>

</body>
</html>