<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>

    <!--BootStrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
 
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/styles/style.css" />

    <!--Font Awesome CDN-->

</head>

<body>
<?php
    require('./includes/db.php');
    session_start();
    echo "<script>
        document.cookie = 'step=1'
    </script>";
?>
    <!-- <nav class="navbar navbar-expand-lg navbar-dark" style="height:10vh;background-color:rgba(0,0,0,0);position:fixed">
        <div class="container-fluid">
            <h1 class="navbar-brand"></h1>
        </div>
    </nav> -->