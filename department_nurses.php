<?php
include("connect.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medestri viddilennya</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
    try {
        $department_id = $_GET['department'];

        $stmt = $dbh->prepare('
            SELECT id_nurse, name, shift, date
            FROM nurse
            WHERE department = :department_id
        ');
        $stmt->bindValue(":department_id", $department_id);
        $stmt->execute();

        $nurses = $stmt->fetchAll();

        echo "<h2>Медсестри відділення: $department_id</h2>";
        if ($nurses) {
            echo "<ul>";
            foreach ($nurses as $nurse) {
                echo "<li><b>ID:</b> {$nurse['id_nurse']}, <b>Ім'я:</b> {$nurse['name']}, <b>Зміна:</b> {$nurse['shift']}, <b>Дата:</b> {$nurse['date']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>У цьому відділенні немає медсестер.</p>";
        }
    } catch (PDOException $e) {
        echo 'Помилка: ' . $e->getMessage();
    }
    ?>
</body>
</html>
