<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/my-style.css">
</head>
<body>
<?php include "navbar.php"; ?>
<div class="container">
    <h1 class="txt">Список новин</h1>
    <?php
    include "connection_database.php";
    $sql = "SELECT * FROM news";
    $reader = $dbh->query($sql);
    ?>
    <div class="row-fluid">
        <?php
        foreach ($reader as $row) {
            ?>
            <div class="card" style="width: 18rem;">
            <img src='/images/<?php echo $row['image'] ?>' class="card-img-top" alt='salo'>
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                <p class="card-text"><?php echo $row ['description']; ?></p>
            </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>