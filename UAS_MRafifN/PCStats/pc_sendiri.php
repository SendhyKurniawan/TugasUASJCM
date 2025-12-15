<?php
echo "<h2>Deteksi Hardware Server</h2>";
echo "<pre>";

echo "=== Sistem Operasi ===\n";
echo php_uname() . "\n\n";

$isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

// CUP DETECTION
echo "=== CPU Information ===\n";
if ($isWindows) {
    // Gunakan Powershell
    $cpu = shell_exec("powershell -command \"(Get-CimInstance Win32_Processor).Name\"");

    if (trim($cpu) !== "") {
        echo "CPU: " . $cpu . "\n";
    } else {
        // Fallback WMIC untuk Windows Lama
        $cpu = shell_exec("wmic cpu get Name");
        echo $cpu ? $cpu : "Informasi CPU tidak dapat dibaca.\n";
    }
} else {
    // Linux
    $cpuinfo = file_get_contents("/proc/cpuinfo");
    echo $cpuinfo ?: "CPU tidak terbaca.\n";
}

echo "\n";

// RAM DETECTION
echo "=== RAM Information ===\n";
if ($isWindows) {
    // Powershell
    $ram = shell_exec("powershell -command \"(Get-CimInstance Win32_ComputerSystem).TotalPhysicalMemory\"");

    if (trim($ram) !== "") {
        $gb = round ($ram / 1024 / 1024 / 1024, 2);
        echo "Total RAM:  {$gb} GB\n";
    } else {
        // Fallback WMIC
        $ram = shell_exec("wmic ComputerSystem get TotalPhysicalMemory");
        echo $ram ? $ram : "Informasi RAM tidak dapat dibaca.\n";
    }
} else {
    // Linux
    $meminfo = file_get_contents("/proc/meminfo");
    echo $meminfo ?: "RAM tidak terbaca.\n";
}
echo "\n";

// DISK
echo "=== Disk Information ===\n";
echo "Total Disk: " . round(disk_total_space("/") / 1024 / 1024 / 1024, 2) . " GB\n";
echo "Free Disk: " . round(disk_free_space("/") / 1024 / 1024 / 1024, 2) . " GB\n\n";

// PHP
echo "PHP Version: " . phpversion() . "\n";
echo "</pre>";
?>