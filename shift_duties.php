<?php
include("connect.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cherguvannya zmyni</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
    try {
        $shift = $_GET['shift'];

        $stmt = $dbh->prepare('
            SELECT n.id_nurse, n.name, w.name AS ward_name, n.date
            FROM nurse n
            JOIN nurse_ward nw ON n.id_nurse = nw.fid_nurse
            JOIN ward w ON nw.fid_ward = w.id_ward
            WHERE n.shift = :shift
        ');
        $stmt->bindValue(":shift", $shift);
        $stmt->execute();

        $duties = $stmt->fetchAll();

        echo "<h2>Чергування у зміну: $shift</h2>";
        if ($duties) {
            echo "<ul>";
            foreach ($duties as $duty) {
                echo "<li>{$duty['name']} (<b>ID:</b> {$duty['id_nurse']}), <b>Палата:</b> {$duty['ward_name']}, <b>Дата:</b> {$duty['date']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>У цю зміну немає чергувань.</p>";
        }
    } catch (PDOException $e) {
        echo 'Помилка: ' . $e->getMessage();
    }
    ?>
</body>
</html>
