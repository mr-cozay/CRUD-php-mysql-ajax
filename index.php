<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AJAX CRUD PHP MYSQL</title>
    <script src="js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
    <?php require_once 'php/process.php';
    if (isset($_SESSION["message"])):?>

    <div class="alert alert-<?= $_SESSION["msg_type"]?>">
        <?php echo ($_SESSION['message']);
        unset($_SESSION["message"]);
        ?>
    </div>
<?php endif; ?>


    <?php
    $req = $db->prepare("SELECT * FROM article");
    $req->execute();
    ?>
    <div class="justify-content-center">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Prix 2</th>
                    <th>Image</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
<?php  while ($row = $req->fetch()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['noprice']; ?></td>
                <td><?php echo $row['img']; ?></td>
                <td>
                    <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Editer</a>
                    <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
<?php endwhile; ?>
        </table>
    </div>
    <div class="row justify-content-center">
        <form action="php/process.php" method="POST">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" class="form-control" name="field1" value="<?= $field1; ?>">
            </div>
            <div class="form-group">
                <label>Prix</label>
                <input type="number" name="field2" class="form-control" value="<?= $field2; ?>">
            </div>
            <div class="form-group">
                <label>Prix 2</label>
                <input type="number" name="field3" class="form-control" value="<?= $field3; ?>">
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="text" name="field4" class="form-control" value="<?= $field4; ?>">
            </div>
            
            <div class="form-group">
            <?php if($update == true): ?>
                <button type="submit" class="btn btn-info" name="update">Modifier</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary" name="save">Entrer</button>
            <?php endif; ?>
            </div>
        </form>
    </div>
    </div>
</body>
</html>