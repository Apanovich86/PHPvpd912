<?php
include "connection_database.php";
//if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $id = $_GET['update_id'];
        $sql = 'SELECT * FROM news WHERE id =:id';
        if (isset($dbh)) {
            $select_stmt = $dbh->prepare($sql);
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
//}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = $_POST['txt_name'];
        $description = $_POST['description'];
        $image_file = $_FILES["txt_file"]["name"];
        $path = "/images/" . $image_file;
        if ($image_file) {
            $filedelete=$_SERVER['DOCUMENT_ROOT']."/images/" . $row['image'];
            unlink($filedelete);
            $filename = uniqid() . '.jpg';
            $filesavepath = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $filename;
            move_uploaded_file($_FILES['txt_file']['tmp_name'], $filesavepath);
        } else {
            $image_file = $row['image'];
        }
        if (!isset($error_Msg)) {
            $update_stmt = $dbh->prepare('UPDATE news SET name=:name_up, description=:description_up, image=:file_up WHERE id=:id');
            $update_stmt->bindParam(':name_up', $name);
            $update_stmt->bindParam(':description_up', $description);
            $update_stmt->bindParam(':file_up', $filename);
            $update_stmt->bindParam(':id', $id);
            if ($update_stmt->execute()) {
                $updateMsg = "File Update Successfully";
                header("Location: /");
                exit();
            }
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php"; ?>
<div class="container">
    <h1>Оновити новину</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Назва</label>
            <input type="text" class="form-control" id="name" name="txt_name" value="<?php echo $name; ?>">
        </div>
        <div class="mb-3" class="form-label">
            <label for="description">Опис</label>
            <textarea class="form-control" rows="10" cols="35" id="description"
                      name="description"><?php echo $description; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">
                Фото
            </label>
            <input type="file" name="txt_file" class="form-control" value="<?php echo $image; ?>"/>
            <p><img src="/images/<?php echo $image; ?>" height="100" width="100"/></p>
        </div>
        <input type="submit" name="btn_update" class="btn btn-primary" value="Update"></input>
        <a href="index.php" class="btn btn-danger">Відмінити</a>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>