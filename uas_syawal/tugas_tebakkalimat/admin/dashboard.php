<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

include '../koneksi.php';

// CREATE (Tambah)
if (isset($_POST['tambah'])) {
    $teks = mysqli_real_escape_string($conn, $_POST['teks']);
    if (!empty($teks)) {
        mysqli_query($conn, "INSERT INTO kalimat (teks) VALUES ('$teks')");
        $msg = "✅ Kalimat berhasil ditambahkan!";
    }
}

// READ
$data = mysqli_query($conn, "SELECT * FROM kalimat ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body { font-family: Arial; background:#f7f7f7; }
        .container { width:80%; margin:40px auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 0 10px #ccc; }
        textarea { width:80%; height:60px; margin-bottom:10px; }
        button { padding:8px 15px; cursor:pointer; }
        table { width:100%; border-collapse: collapse; margin-top:20px; }
        th, td { padding:10px; border:1px solid #ddd; }
        th { background:#eee; }
        .msg { color:green; }
        .logout { float:right; }
        a { text-decoration:none; color:blue; }
        a:hover { text-decoration:underline; }
    </style>
</head>
<body>
<div class="container">
    <h2>🛠️ Dashboard Admin</h2>
    <a href="logout.php" class="logout">🚪 Logout</a>
    <?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

    <form method="post">
        <textarea name="teks" placeholder="Tulis kalimat baru di sini..." required></textarea><br>
        <button type="submit" name="tambah">Tambah Kalimat</button>
    </form>

    <h3>Daftar Kalimat</h3>
    <table>
        <tr><th>ID</th><th>Kalimat</th><th>Aksi</th></tr>
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['teks']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">✏️ Edit</a> | 
                <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus kalimat ini?')">🗑️ Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>