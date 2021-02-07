<?php
require_once("Include/db.php");
require_once("Include/Functions.php");
require_once("Include/Sessions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/Styles.css">
    <title>Blog</title>
</head>
<body>
<!-- NAVBAR -->
<div style="height:10px; background:#27aae1;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="#" class="navbar-brand"> MStrycharz</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="blog.php" class="nav-link">Strona główna</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">O nas</a>
                </li>
                <li class="nav-item">
                    <a href="blog.php" class="nav-link">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Kontakt</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <div class="form-group">x
                <form class="form-inline d-none d-sm-block" action="blog.php">
                    <input class="form-control" type="text" name="search" placeholder="Szukaczka" value="">
                    <button type="button" class="btn btn-primary" name="SearchButton">Idź</button>
                </div>
                </form>

            </ul>
        </div>
    </div>
</nav>
<div style="height:10px; background:#27aae1;"></div>
<!-- NAVBAR END -->
<div class="container">
    <div class="row mt-4">
        <div class="col-sm-8 ">
            <h1>DevBlog wszystkich moich projektów</h1>
            <?php
            global $ConnectingDB;
            if(isset($_GET["SearchButton"])){
                $search = $_GET["Search"];
                $sql = "select * from posts where
                        title like :search or 
                        category like :search or
                        author like :search or 
                        post like:search";
                $stmt = $ConnectingDB->prepare($sql);
                $stmt->bindValue(':search','%'.$search.'%');
                $stmt->execute();
            }

                else {
                $idFromURL = $_GET["id"];
                if(!isset($idFromURL)){
                    $_SESSION["ErrorMessage"]="Wystąpił błąd, brak podanego wpisu.";
                    Redirect_to("blog.php");
                }
                $sql = "select * from posts where id=$idFromURL";
                $stmt = $ConnectingDB->query($sql);}
                while ($DataBlogRows = $stmt->fetch()){
                    $id = $DataBlogRows["id"];
                    $DateTime = strftime("%d-%m-%Y %H:%M", $DataBlogRows["datetime"]);
                    $PostTitle = $DataBlogRows["title"];
                    $Category = $DataBlogRows["category"];
                    $Author = $DataBlogRows["author"];
                    $Image = $DataBlogRows["image"];
                    $PostText = $DataBlogRows["post"];

            ?>
                    <div class="card">
                        <img src="Uploads/<?php echo $Image; ?> " class="img-fluid card-image-top">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $PostTitle; ?></h4>
                            <small>Autor: <?php echo $Author; ?> Dnia: <?php echo $DateTime; ?></small>
                            <span style="float:right;" class="badge badge-dark text-light">Komentarzy: </span>
                            <hr>
                            <p class="card-text"><?php echo $PostText; ?></p>

                        </div>
                    </div>
<?php } ?>
            </div>
        <div class="offset-sm-1 col-sm-3">

        </div>

        </div>

</div>
<!-- FOOTER -->
<?php
include "Include/footer.html";
?>
<!-- FOOTER END-->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
    $('#year').text(new Date().getFullYear());
</script>
</body>
</html>
