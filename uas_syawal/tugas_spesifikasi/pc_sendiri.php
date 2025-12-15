<?php
function ps($cmd) {
    return trim(shell_exec("powershell -NoProfile -Command \"$cmd\""));
}

// ================= OS =================
$os = ps("(Get-CimInstance Win32_OperatingSystem).Caption");

// ================= CPU =================
$cpu = ps("(Get-CimInstance Win32_Processor).Name");

// ================= RAM =================
// Dalam bytes -> konversi ke GB
$ramBytes = ps("(Get-CimInstance Win32_ComputerSystem).TotalPhysicalMemory");
$ramGB = round($ramBytes / 1073741824, 2);

// ================= GPU =================
$gpu = ps("(Get-CimInstance Win32_VideoController)[0].Name");

// ================= Motherboard =================
$mb = ps("(Get-CimInstance Win32_BaseBoard).Product");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Deteksi Hardware - PowerShell</title>
    <style>
        body { font-family: Arial; background:#f1f1f1; padding:40px; }
        .box { background:white; padding:20px; width:500px; margin:auto; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.2); }
        h2 { text-align:center; }
        .item { margin-bottom:10px; font-size:18px; }
    </style>
</head>
<body>
<div class="box">
    <h2>Deteksi Hardware (PowerShell)</h2>
    <div class="item"><strong>OS:</strong> <?= $os ?></div>
    <div class="item"><strong>CPU:</strong> <?= $cpu ?></div>
    <div class="item"><strong>RAM:</strong> <?= $ramGB ?> GB</div>
    <div class="item"><strong>GPU:</strong> <?= $gpu ?></div>
    <div class="item"><strong>Motherboard:</strong> <?= $mb ?></div>
</div>
</body>
</html>