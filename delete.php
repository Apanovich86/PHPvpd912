<?php
include "connection_database.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['delete_id'];
    if (isset($dbh)) {
        $sql = 'SELECT * FROM news WHERE id =:id';
        $select_stmt = $dbh->prepare($sql);
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        $filedelete = $_SERVER['DOCUMENT_ROOT'] . "/images/" . $row['image'];
        unlink($filedelete);
        $delsql = 'DELETE FROM news WHERE id =:id';
        $delete_stmt = $dbh->prepare($delsql);
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();
        header("Location: /");
        exit();
    }
}
?>