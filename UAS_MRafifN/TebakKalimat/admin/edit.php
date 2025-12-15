<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
include '../koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM kalimat WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan!");
}

// UPDATE
if (isset($_POST['update'])) {
    $teks = mysqli_real_escape_string($conn, $_POST['teks']);
    mysqli_query($conn, "UPDATE kalimat SET teks='$teks' WHERE id=$id");
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Kalimat</title>
<style>
body { font-family: Arial; background:#f0f0f0; text-align:center; margin-top:100px; }
form { background:#fff; display:inline-block; padding:30px; border-radius:10px; box-shadow:0 0 10px #ccc; width:400px; }
textarea { width:100%; height:80px; margin-bottom:10px; }
button { padding:8px 20px; cursor:pointer; }
</style>
</head>
<body>
    <h2>Edit Kalimat</h2>
    <form method="post">
        <textarea name="teks" required><?= htmlspecialchars($data['teks']) ?></textarea><br>
        <button type="submit" name="update">Simpan Perubahan</button>
        <br><br>
        <a href="dashboard.php">Kembali</a>
    </form>
</body>
</html>