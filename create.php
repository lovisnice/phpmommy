<?php
global $pdo;
global $image;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include $_SERVER['DOCUMENT_ROOT'] . "/config/connection_database.php";

    $name = $_POST["name"];
    $decscription = $_POST["decscription"];

    // Check if a file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Specify the target directory for the uploaded image
        $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/images/';
        $uploadedFilePath = $targetDirectory . basename($_FILES['image']['name']);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFilePath)) {
            $image = '/images/' . basename($_FILES['image']['name']);

            // Insert query
            $sql = "INSERT INTO categories (name, image, decscription) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // Execute the query with the data
            $stmt->execute([$name, $image, $decscription]);

            header("Location: /");
            exit;
        } else {
            echo 'Error moving uploaded file to target directory.';
            exit;
        }
    } else {
        echo 'No file uploaded or an error occurred.';
        exit;
    }
}
?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Додати</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
</head>
<body>
<div class="container py-3">
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
    ?>

    <h1 class="text-center">Додати категорію</h1>

    <form class="col-md-6 offset-md-3" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Назва</label>
            <input type="text" class="form-control" name="name" id="name" >
        </div>

        <div class="mb-3">
            <div class="row">
                <img class="imageDiv" id="previewImage" src="">
                <label for="image" class="form-label">Фото</label>
                <input type="file" class="form-control" name="image" id="image" onchange="previewImage()">
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Опис</label>
            <textarea class="form-control" name="decscription" id="decscription"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Додати</button>
    </form>

</div>
<script src="/js/bootstrap.bundle.min.js"></script>
<script>
    function previewImage() {
        var input = document.getElementById('image');
        var preview = document.getElementById('previewImage');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                console.log(e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Ensure the function is defined before the onchange event is triggered
    document.getElementById('image').onchange = previewImage;
</script>

</body>
</html>