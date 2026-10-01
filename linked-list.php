<?php

class Node
{
    public $data;
    public $next;

    public function __construct($data)
    {
        $this->data = $data;
        $this->next = null;
    }
}

class LinkedList
{
    public $head = null;

    public function tambahAwal($data)
    {
        $node = new Node($data);

        $node->next = $this->head;
        $this->head = $node;
    }

    public function tambahAkhir($data)
    {
        $node = new Node($data);

        if ($this->head === null) {
            $this->head = $node;
            return;
        }

        $current = $this->head;

        while ($current->next !== null) {
            $current = $current->next;
        }

        $current->next = $node;
    }

    public function hapus($data)
    {
        if ($this->head === null) {
            return false;
        }

        if ($this->head->data == $data) {
            $this->head = $this->head->next;
            return true;
        }

        $current = $this->head;

        while (
            $current->next !== null &&
            $current->next->data != $data
        ) {
            $current = $current->next;
        }

        if ($current->next !== null) {
            $current->next = $current->next->next;
            return true;
        }

        return false;
    }

    public function getData()
    {
        $data = [];

        $current = $this->head;

        while ($current !== null) {
            $data[] = $current->data;
            $current = $current->next;
        }

        return $data;
    }
}

session_start();

if (!isset($_SESSION['linked_list'])) {
    $_SESSION['linked_list'] = ["10", "20", "30"];
}

$pesan = "";

if (isset($_POST['tambah'])) {

    $data = trim($_POST['data']);
    $posisi = $_POST['posisi'];

    if ($data !== "") {

        if ($posisi == "awal") {
            array_unshift($_SESSION['linked_list'], $data);
        } else {
            $_SESSION['linked_list'][] = $data;
        }

        $pesan = "Node '$data' berhasil ditambahkan.";
    }
}

if (isset($_POST['hapus'])) {

    $data = trim($_POST['hapus_data']);

    $index = array_search(
        $data,
        $_SESSION['linked_list']
    );

    if ($index !== false) {

        array_splice(
            $_SESSION['linked_list'],
            $index,
            1
        );

        $pesan = "Node '$data' berhasil dihapus.";

    } else {

        $pesan = "Node '$data' tidak ditemukan.";

    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Linked List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <a href="index.php" class="back">← Kembali</a>

    <h1>🔗 Demonstrasi Linked List</h1>

    <p>
        Linked List terdiri dari beberapa node.
        Setiap node menyimpan data dan alamat node berikutnya.
    </p>

    <?php if ($pesan): ?>

        <div class="message">
            <?= htmlspecialchars($pesan) ?>
        </div>

    <?php endif; ?>

    <div class="panel">

        <h2>Tambah Node</h2>

        <form method="POST">

            <input
                type="text"
                name="data"
                placeholder="Masukkan data"
                required
            >

            <select name="posisi">

                <option value="akhir">
                    Tambah di Akhir
                </option>

                <option value="awal">
                    Tambah di Awal
                </option>

            </select>

            <button type="submit" name="tambah">
                + Tambah Node
            </button>

        </form>

    </div>

    <div class="panel">

        <h2>Hapus Node</h2>

        <form method="POST">

            <input
                type="text"
                name="hapus_data"
                placeholder="Data yang ingin dihapus"
                required
            >

            <button
                type="submit"
                name="hapus"
                class="danger"
            >
                Hapus Node
            </button>

        </form>

    </div>

    <div class="panel">

        <h2>Visualisasi Linked List</h2>

        <div class="linked-list">

            <?php foreach ($_SESSION['linked_list'] as $index => $data): ?>

                <div class="node">

                    <span class="node-title">
                        Node <?= $index + 1 ?>
                    </span>

                    <strong>
                        <?= htmlspecialchars($data) ?>
                    </strong>

                    <small>
                        next →
                    </small>

                </div>

                <?php if ($index < count($_SESSION['linked_list']) - 1): ?>

                    <div class="arrow">
                        →
                    </div>

                <?php else: ?>

                    <div class="arrow">
                        → NULL
                    </div>

                <?php endif; ?>

            <?php endforeach; ?>

        </div>

    </div>

    <div class="explanation">

        <h2>Cara Kerja Linked List</h2>

        <ol>

            <li>
                Node dibuat untuk menyimpan data.
            </li>

            <li>
                Node memiliki pointer/reference menuju node berikutnya.
            </li>

            <li>
                Node pertama disebut <b>head</b>.
            </li>

            <li>
                Node terakhir menunjuk ke <b>NULL</b>.
            </li>

        </ol>

        <pre>
Node 10
   |
   v
Node 20
   |
   v
Node 30
   |
   v
 NULL
        </pre>

    </div>

</div>

</body>
</html>