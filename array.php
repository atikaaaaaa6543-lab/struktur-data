<?php
session_start();

if (!isset($_SESSION['array_data'])) {
    $_SESSION['array_data'] = ["Apel", "Mangga", "Jeruk"];
}

$pesan = "";

if (isset($_POST['tambah'])) {
    $data = trim($_POST['data']);

    if ($data !== "") {
        $_SESSION['array_data'][] = $data;
        $pesan = "Data '$data' berhasil ditambahkan.";
    }
}

if (isset($_POST['hapus'])) {
    $index = intval($_POST['index']);

    if (isset($_SESSION['array_data'][$index])) {
        $data = $_SESSION['array_data'][$index];

        array_splice($_SESSION['array_data'], $index, 1);

        $pesan = "Data '$data' berhasil dihapus.";
    }
}

if (isset($_POST['cari'])) {
    $keyword = trim($_POST['keyword']);
    $index = array_search(
        strtolower($keyword),
        array_map('strtolower', $_SESSION['array_data'])
    );

    if ($index !== false) {
        $pesan = "Data '$keyword' ditemukan pada index $index.";
    } else {
        $pesan = "Data '$keyword' tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Array</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <a href="index.php" class="back">← Kembali</a>

    <h1>📦 Demonstrasi Array</h1>

    <p>
        Array menyimpan beberapa data dalam satu variabel.
        Setiap data memiliki posisi yang disebut <b>index</b>.
    </p>

    <?php if ($pesan): ?>
        <div class="message">
            <?= htmlspecialchars($pesan) ?>
        </div>
    <?php endif; ?>

    <div class="panel">
        <h2>Tambah Data</h2>

        <form method="POST">
            <input
                type="text"
                name="data"
                placeholder="Contoh: Pisang"
                required
            >

            <button type="submit" name="tambah">
                + Tambah
            </button>
        </form>
    </div>

    <div class="panel">
        <h2>Cari Data</h2>

        <form method="POST">
            <input
                type="text"
                name="keyword"
                placeholder="Masukkan data"
                required
            >

            <button type="submit" name="cari">
                🔍 Cari
            </button>
        </form>
    </div>

    <div class="panel">
        <h2>Isi Array</h2>

        <div class="data-container">

            <?php foreach ($_SESSION['array_data'] as $index => $data): ?>

                <div class="data-box">
                    <small>Index <?= $index ?></small>

                    <strong>
                        <?= htmlspecialchars($data) ?>
                    </strong>

                    <form method="POST">
                        <input
                            type="hidden"
                            name="index"
                            value="<?= $index ?>"
                        >

                        <button
                            type="submit"
                            name="hapus"
                            class="danger"
                        >
                            Hapus
                        </button>
                    </form>
                </div>

            <?php endforeach; ?>

        </div>
    </div>

    <div class="explanation">
        <h2>Cara Kerja Array</h2>

        <ol>
            <li>Data disimpan dalam satu variabel array.</li>
            <li>Setiap elemen mempunyai index mulai dari 0.</li>
            <li>Data dapat diakses berdasarkan index.</li>
            <li>Elemen dapat ditambahkan atau dihapus.</li>
        </ol>

        <pre>
$array = ["Apel", "Mangga", "Jeruk"];

echo $array[0];

// Output:
// Apel
        </pre>
    </div>

</div>

</body>
</html>