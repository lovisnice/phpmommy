<?php global $pdo;
    global $delid;
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна сторінка</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">

</head>
<body>
<div class="container">
    <?php include("header.php");
    include $_SERVER['DOCUMENT_ROOT'] . "/config/connection_database.php";
    ?>

    <h1 class="text-center">Категорії</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Фото</th>
            <th scope="col">Назва</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Select query
        $sql = "SELECT id, name, image, decscription FROM categories";
        $stmt = $pdo->query($sql);

        // Fetch the results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output the results
        foreach ($results as $row) {

            ?>
            <tr>
                <th scope="row"><?php echo $row["id"]; ?></th>
                <td>
                    <img src="<?php echo $row["image"]; ?>"
                         height="75"
                         alt="Фото">
                </td>
                <td>
                    <?php echo $row["name"]; ?>
                </td>
                <td>
                    <a href="#" class="btn btn-info" onclick="viewCategory(<?php echo $row['id']; ?>)">Переглянути</a>
                    <a href="/edit.php?id=<?php echo $row["id"]; ?>" class="btn btn-dark">Змінить</a>
                    <button class="btn btn-danger" onclick="confirmDeleteCategory(<?php echo $delid = $row['id']; ?>)">Видалити</button>
                </td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>




<script src="/js/bootstrap.bundle.min.js"></script>
<script>
    function viewCategory(categoryId) {
        // Implement your logic for viewing category
        console.log('View category:', categoryId);
    }

    function editCategory(categoryId) {
        // Implement your logic for editing category
        console.log('Edit category:', categoryId);
    }

    function deleteCategory(categoryId) {
        console.log("work");
    }

    function confirmDeleteCategory(categoryId) {
        // Show a confirmation dialog
        let isConfirmed = confirm('Ви впевнені, що хочете видалити категорію?');

        if (isConfirmed) {
            // If confirmed, send a Fetch request to the server to delete the category
            fetch('delete_category.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: categoryId }),
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the server response, e.g., refresh the page or update UI
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            console.log('Deletion canceled');
        }

        location.reload();

    }
</script>

</body>
</html>
