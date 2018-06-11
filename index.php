<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/Classes/autoload.php";
    use Classes\Utils\JSONResponse;
    use Classes\Utils\Sms;

    $res = Sms::send("375447386402","Hello from Desktop.rent!");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/index.js"></script>
    <title>Desktop.rent</title>
</head>
<body>
    <h1>Hello world!</h1>
</body>
</html>
