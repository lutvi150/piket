<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// ===== SECURITY =====
if (!isset($_GET['key']) || $_GET['key'] !== 'rahasia123') {
    die('Akses ditolak');
}

// ===== CONFIG =====
$host = "localhost";
$user = "teamclov_clover";
$pass = "teamclov_clover";
$db   = "teamclov_demo_8";

// ===== CONNECT =====
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// PARAM
$table = $_GET['table'] ?? null;
$action = $_GET['action'] ?? 'structure';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mini phpMyAdmin</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            background: #f4f6f9;
        }
        .sidebar {
            width: 250px;
            background: #2f3542;
            color: #fff;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar h2 {
            padding: 15px;
            margin: 0;
            font-size: 18px;
            background: #1e272e;
        }
        .sidebar a {
            display: block;
            padding: 10px 15px;
            color: #dcdde1;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #57606f;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .card {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            padding: 8px;
            border-top: 1px solid #eee;
        }
        th {
            background: #f1f2f6;
            text-align: left;
        }
        .nav a {
            margin-right: 10px;
            text-decoration: none;
            color: #0984e3;
        }
        textarea {
            width: 100%;
            height: 100px;
        }
        button {
            padding: 8px 12px;
            border: none;
            background: #0984e3;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>📂 <?= $db ?></h2>
    <?php
    $tables = $conn->query("SHOW TABLES");
    while ($t = $tables->fetch_array()) {
        echo "<a href='?key=rahasia123&table={$t[0]}'>{$t[0]}</a>";
    }
    ?>
</div>

<!-- CONTENT -->
<div class="content">

<?php if ($table): ?>

    <div class="card">
        <h3>📄 Tabel: <?= $table ?></h3>
        <div class="nav">
            <a href="?key=rahasia123&table=<?= $table ?>&action=structure">Structure</a>
            <a href="?key=rahasia123&table=<?= $table ?>&action=data">Data</a>
            <!-- <a href="?key=rahasia123&table=<?= $table ?>&action=query">SQL</a> -->
        </div>
    </div>

    <?php if ($action == 'structure'): ?>
        <div class="card">
            <h4>Struktur</h4>
            <table>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Null</th>
                    <th>Key</th>
                    <th>Default</th>
                    <th>Extra</th>
                </tr>
                <?php
                $columns = $conn->query("DESCRIBE $table");
                while ($col = $columns->fetch_assoc()) {
                    echo "<tr>
                        <td>{$col['Field']}</td>
                        <td>{$col['Type']}</td>
                        <td>{$col['Null']}</td>
                        <td>{$col['Key']}</td>
                        <td>{$col['Default']}</td>
                        <td>{$col['Extra']}</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

    <?php elseif ($action == 'data'): ?>
        <div class="card">
            <h4>Data (limit 50)</h4>
            <table>
                <tr>
                    <?php
                    $result = $conn->query("SELECT * FROM $table LIMIT 50");
                    while ($field = $result->fetch_field()) {
                        echo "<th>{$field->name}</th>";
                    }
                    ?>
                </tr>
                <?php
                $result->data_seek(0);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $val) {
                        echo "<td>" . htmlspecialchars($val??"") . "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

    <?php elseif ($action == 'query'): ?>
        <div class="card">
            <h4>SQL Query</h4>
            <form method="post">
                <textarea name="sql"></textarea><br><br>
                <button type="submit">Run</button>
            </form>

            <?php
            if (isset($_POST['sql'])) {
                $sql = $_POST['sql'];
                echo "<pre><b>Query:</b> $sql</pre>";

                if ($res = $conn->query($sql)) {
                    if ($res === TRUE) {
                        echo "✅ Query berhasil dijalankan";
                    } else {
                        echo "<table><tr>";
                        while ($field = $res->fetch_field()) {
                            echo "<th>{$field->name}</th>";
                        }
                        echo "</tr>";

                        while ($row = $res->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($row as $val) {
                                echo "<td>" . htmlspecialchars($val??"") . "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                } else {
                    echo "❌ Error: " . $conn->error;
                }
            }
            ?>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="card">
        <h3>👈 Pilih tabel di sebelah kiri</h3>
    </div>
<?php endif; ?>

</div>

</body>
</html>