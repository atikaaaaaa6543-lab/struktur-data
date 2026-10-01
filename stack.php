<?php

session_start();

if (!isset($_SESSION['stack'])) {
    $_SESSION['stack'] = [];
}

$pesan = "";

if (isset($_POST['push'])) {

    $data = trim($_POST['data']);

    if ($data !== "") {

        $_SESSION['stack'][] = $data;

        $pesan = "Push berhasil: '$data' masuk ke Stack.";
    }
}

if (isset($_POST['pop'])) {

    if (!empty($_SESSION['stack'])) {

        $data = array_pop($_SESSION['stack']);

        $pesan = "Pop berhasil: '$data' keluar dari Stack.";

    } else {

        $pesan = "Stack kosong.";

    }
}

if (isset($_POST['clear'])) {

    $_SESSION['stack'] = [];

    $pesan = "Stack berhasil dikosongkan.";
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Demo Stack</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>

<body>

<div class="container">

    <a href="index.php" class="back">
        ← Kembali
    </a>

    <h1>📚 Demonstrasi Stack</h1>

    <p>
        Stack menggunakan prinsip
        <b>LIFO (Last In, First Out)</b>.
    </p>

    <?php if ($pesan): ?>

        <div class="message">
            <?= htmlspecialchars($pesan) ?>
        </div>

    <?php endif; ?>

    <div class="panel">

        <h2>Push Data</h2>

        <form method="POST">

            <input
                type="text"
                name="data"
                placeholder="Masukkan data"
                required
            >

            <button type="submit" name="push">
                ⬆ Push
            </button>

        </form>

    </div>

    <div class="panel">

        <h2>Operasi Stack</h2>

        <form method="POST">

            <button
                type="submit"
                name="pop"
                class="danger"
            >
                ⬇ Pop
            </button>

            <button
                type="submit"
                name="clear"
                class="secondary"
            >
                🗑 Clear
            </button>

        </form>

    </div>

    <div class="panel">

        <h2>Visualisasi Stack</h2>

        <div class="stack-container">

            <?php if (empty($_SESSION['stack'])): ?>

                <div class="empty">
                    Stack kosong
                </div>

            <?php else: ?>

                <?php

                $stack = array_reverse(
                    $_SESSION['stack']
                );

                ?>

                <?php foreach ($stack as $index => $data): ?>

                    <div
                        class="
                            stack-item
                            <?= $index === 0 ? 'top' : '' ?>
                        "
                    >

                        <?= htmlspecialchars($data) ?>

                        <?php if ($index === 0): ?>

                            <span>
                                ← TOP
                            </span>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </div>

    <div class="explanation">

        <h2>Cara Kerja Stack</h2>

        <ol>

            <li>
                <b>Push</b> digunakan untuk memasukkan data.
            </li>

            <li>
                Data baru ditempatkan di bagian TOP.
            </li>

            <li>
                <b>Pop</b> mengambil data paling atas.
            </li>

            <li>
                Karena menggunakan LIFO, data terakhir masuk
                akan keluar terlebih dahulu.
            </li>

        </ol>

        <pre>
Push 10
Push 20
Push 30

       TOP
        ↓
      ┌────┐
      │ 30 │
      ├────┤
      │ 20 │
      ├────┤
      │ 10 │
      └────┘

Pop()

30 keluar
        </pre>

    </div>

</div>

</body>

</html>