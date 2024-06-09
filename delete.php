<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

require_once "pdo.php";

if (isset($_POST['delete']) && isset($_GET['auto_id'])) {
    $sql = "DELETE FROM automobiles WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':auto_id' => $_GET['auto_id']));
    $_SESSION['success'] = 'Record deleted';
    header('Location: index.php');
    return;
}

if (!isset($_GET['auto_id'])) {
    $_SESSION['error'] = "Missing auto_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT make FROM automobiles WHERE auto_id = :auto_id");
$stmt->execute(array(":auto_id" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header('Location: index.php');
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>4b34e3d7</title>
</head>
<body>
<div class="container">
    <p>Confirm: Deleting <?php echo $row['make'] ?></p>
    <form method="post">
        <input type="hidden" name="auto_id" value="<?php echo $_GET['auto_id'] ?>">
        <input type="submit" value="Delete" name="delete">
        <a href="index.php">Cancel</a>
    </form>
</div>
</body>
</html>
