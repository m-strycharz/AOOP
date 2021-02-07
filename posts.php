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
    <title>Wpisy</title>
</head>
<body>
<!-- NAVBAR -->
<?php
include "Include/navbar.html";
?>
<!-- NAVBAR END -->


<!-- HEADER -->
<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-blog" style="color:#27aae1;"></i>Wpisy</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="addnewpost.php" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Dodaj nowy wpis</a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Categories.php" class="btn btn-info btn-block"><i class="fas fa-folder-plus"></i> Dodaj nową kategorię</a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="authors.php" class="btn btn-warning btn-block"><i class="fas fa-user-plus"></i> Dodaj nowego autora</a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="comments.php" class="btn btn-success btn-block"><i class="fas fa-check"></i> przegląd komentarzy</a>
            </div>
        </div>
    </div>
</header>
<!-- HEADER END -->
<section class="container py-2 mb-4">
    <div class="row">
        <div clas="col-lg-12">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>#</th><th>Tytuł</th><th>Kategoria</th><th>Opublikowano</th><th>Autor</th><th>Obraz</th><th>Komentarze</th><th>Akcje</th><th>Podgląd</th></tr>
                </thead>
                <?php
                    global $ConnectingDB;
                    $sql = "select * from posts";
                    $stmt = $ConnectingDB->query($sql);
                    while($DataPostRows = $stmt->fetch()){
                        $id = $DataPostRows["id"];
                        $DateTime = strftime("%d-%m-%Y %H:%M", $DataPostRows["datetime"]);
                        $PostTitle = $DataPostRows["title"];
                        $Category = $DataPostRows["category"];
                        $Author = $DataPostRows["author"];
                        $Image = $DataPostRows["image"];
                        $PostText = $DataPostRows["post"];

                    echo "<tbody><tr>
                            <td>$id</td>";
                    if(strlen($PostTitle)>20){$PostTitle = substr($PostTitle,0,15).'...';}
                    echo   "<td>$PostTitle</td>
                            <td>$Category</td>
                            <td>$DateTime</td>
                            <td>$Author</td>
                            <td><img src=\"Uploads/".$Image."\" width=\"170px;\"></td>
                            <td>Komentarze</td>
                            <td><a href=\"editpost.php?id=".$id."\"><span class=\"btn btn-warning\">Edycja</span></a><a href=\"deletepost.php?id=".$id."\"><span class=\"btn btn-danger\">Usuń</span></a></td>
                            <td><a href=\"FullPost.php?id=".$id."\" target='_blank'><span class=\"btn btn-primary\">Podgląd</span></a></td>
                          </tr></tbody>";
                    }
                ?>

            </table>
        </div>

    </div>

</section>
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
