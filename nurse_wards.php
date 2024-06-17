<?php
include("connect.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Palati medsestry</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
    try {
        $nurse_name = $_GET['nurse'];

        $stmt = $dbh->prepare('
            SELECT w.name AS ward_name 
            FROM ward w
            JOIN nurse_ward nw ON w.id_ward = nw.fid_ward
            JOIN nurse n ON nw.fid_nurse = n.id_nurse
            WHERE n.name = :nurse_name
        ');
        $stmt->bindValue(":nurse_name", $nurse_name);
        $stmt->execute();

        $wards = $stmt->fetchAll();

        echo "<h2>Палати, у яких чергує медсестра: $nurse_name</h2>";
        if ($wards) {
            echo "<ul>";
            foreach ($wards as $ward) {
                echo "<li><b>{$ward['ward_name']}</b></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Немає даних про чергування для цієї медсестри.</p>";
        }
    } catch (PDOException $e) {
        echo 'Помилка: ' . $e->getMessage();
    }
    ?>
</body>
</html>
