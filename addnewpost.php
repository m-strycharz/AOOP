<?php
require_once("Include/db.php");
require_once("Include/Functions.php");
require_once("Include/Sessions.php");
if(isset($_POST["Submit"])){
    $Category = $_POST["CategoryTitle"];
    $Author = "Mariusz";
    date_default_timezone_set("Europe/Warsaw");
    $CurrentTime = time();
    $DateTime = strftime("%d-%B-%Y %H:%M", $CurrentTime);

    if(empty($Category)){
        $_SESSION["ErrorMessage"] = "Wszystkie pola muszą być uzupełnione";
        Redirect_to("Categories.php");
    } elseif(strlen($Category)<4){
        $_SESSION["ErrorMessage"] = "Podana nazwa jest za krótka (min 4 znaki)";
        Redirect_to("Categories.php");
    } elseif(strlen($Category)>25){
        $_SESSION["ErrorMessage"] = "Podana nazwa jest za długa (max 25 znaków)";
        Redirect_to("Categories.php");

    }else{
        $sql = "insert into category(name, author, created)";
        $sql .= "values(:catname, :catauthor, :catcreated)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':catname',$Category);
        $stmt->bindValue(':catauthor',$Author);
        $stmt->bindValue(':catcreated',$CurrentTime);
        $Execute = $stmt->execute();

        if($Execute){
            $_SESSION["SuccessMessage"]="Kategoria " .$Category." została dodana";
            Redirect_to("Categories.php");

        }else{
            $_SESSION["ErrorMessage"] = "Coś poszło nie tak, spróbuj ponownie.";
            Redirect_to("Categories.php");
        }
    }
}
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
        <title>Document</title>
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
                    <h1><i class="fas fa-edit" style="color:#27aae1;"></i> Nowy wpis</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10 " style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <form class="" ation="categories.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Dodaj Wpis</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo">Tytuł wpisu</span></label>
                                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Tytuł wpisu" value="">
                            </div>
                            <div class="form-group">
                                <label for="categoryName"><span class="FieldInfo">Kategoria</span></label>
                                <select class="form-control" id="categoryName" name="Category">
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="selectImage" value="">
                                    <label for="selectImage" class="custom-file-label"></label>
                                </div>
                            <div class="form-group">
                                <label for="Post"><span class="FieldInfo">Wpis:</span></label>
                                <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="index.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Powrót</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Dodaj</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
<?php
