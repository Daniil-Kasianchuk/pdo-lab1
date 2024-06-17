<?php
    include("connect.php");

    $SELECT_NURSES = "SELECT name FROM nurse";
    $SELECT_DEPARTMENTS = "SELECT DISTINCT department FROM nurse";
    $SELECT_SHIFTS = "SELECT DISTINCT shift FROM nurse";
    try {
        $stmt = $dbh->prepare($SELECT_NURSES);
        $stmt->execute();
        $nurses = $stmt->fetchAll();

        $stmt = $dbh->prepare($SELECT_DEPARTMENTS);
        $stmt->execute();
        $departments = $stmt->fetchAll();

        $stmt = $dbh->prepare($SELECT_SHIFTS);
        $stmt->execute();
        $shifts = $stmt->fetchAll();

    } catch (PDOException $ex) {
        echo $ex->GetMessage();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hospital Management</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1>Hospital Management</h1>
    
    <h2>Перелік палат, у яких чергує обрана медсестра</h2>
    <form action="nurse_wards.php" method="get">
        <label for="nurse">Ім'я медсестри:</label>
        <select id="nurse" name="nurse" required>
            <?php
                foreach ($nurses as $row) {
                    echo("<option value='$row[0]'>$row[0]</option>");
                }
            ?>
        </select>
        <input type="submit" value="Отримати перелік палат">
    </form>
    
    <h2>Медсестри обраного відділення</h2>
    <form action="department_nurses.php" method="get">
        <label for="department">Відділення:</label>
        <select id="department" name="department" required>
            <?php
                foreach ($departments as $row) {
                    echo("<option value='$row[0]'>$row[0]</option>");
                }
            ?>
        </select>
        <input type="submit" value="Отримати медсестер">
    </form>
    
    <h2>Чергування у зазначену зміну</h2>
    <form action="shift_duties.php" method="get">
        <label for="shift">Зміна:</label>
        <select id="shift" name="shift" required>
            <?php
                foreach ($shifts as $row) {
                    echo("<option value='$row[0]'>$row[0]</option>");
                }
            ?>
        </select>
        <input type="submit" value="Отримати чергування">
    </form>
</body>
</html>
