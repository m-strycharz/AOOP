<?php
require_once("Include/db.php");
require_once("Include/Functions.php");
require_once("Include/Sessions.php");
if(isset($_POST["Submit"])){
    $PostTitle = $_POST["PostTitle"];
    $Category = $_POST["Category"];
    $Image = $_FILES["Image"]["name"];
    $Target = "Uploads/".basename($_FILES["Image"]["name"]);
    $PostText = $_POST["PostDescription"];
    $Author = "Mariusz";
    date_default_timezone_set("Europe/Warsaw");
    $CurrentTime = time();
    $DateTime = strftime("%d-%B-%Y %H:%M", $CurrentTime);

    if(empty($PostTitle)){
        $_SESSION["ErrorMessage"] = "Wszystkie pola muszą być uzupełnione";
        Redirect_to("addnewpost.php");
    } elseif(strlen($PostTitle)<5){
        $_SESSION["ErrorMessage"] = "Podana nazwa jest za krótka (min 5 znaki)";
        Redirect_to("addnewpost.php");
    } elseif(strlen($PostTitle)>50){
        $_SESSION["ErrorMessage"] = "Podana nazwa jest za długa (max 50 znaków)";
        Redirect_to("addnewpost.php");
    } elseif(strlen($PostText)>999){
        $_SESSION["ErrorMessage"] = "Podany tekst jest za długi (max 1000 znaków)";
        Redirect_to("addnewpost.php");
    }else{
        $sql = "insert into posts (datetime,title,category,author,image,post)";
        $sql .= "values(:postTime, :posttitle, :postcategory, :postAuthor, :postImage, :postText)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':postTime',$CurrentTime);
        $stmt->bindValue(':posttitle',$PostTitle);
        $stmt->bindValue(':postcategory',$Category);
        $stmt->bindValue(':postAuthor',$Author);
        $stmt->bindValue(':postImage',$Image);
        $stmt->bindValue(':postText',$PostText);
        $Execute = $stmt->execute();
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

        if($Execute){
            $_SESSION["SuccessMessage"]="Wpis " .$PostTitle." został dodany";
            Redirect_to("addnewpost.php");

        }else{
            $_SESSION["ErrorMessage"] = "Coś poszło nie tak, spróbuj ponownie.";
            Redirect_to("addnewpost.php");
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
        <title>Edycja wpisu</title>
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
                    <h1><i class="fas fa-edit" style="color:#27aae1;"></i> Edycja wpisu</h1>
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
                global $ConnectingDB;
                $idFromURL = $_GET["id"];
                $sql = "select * from posts where id='$idFromURL'";
                $result = $ConnectingDB->query($sql);
                while($DataRows=$result->fetch()){
                    $TitleUp = $DataRows['title'];
                    $CategoryUp = $DataRows['category'];
                    $ImageUp = $DataRows['image'];
                    $PostUp = $DataRows['post'];
                }

                ?>
                <form class="" ation="addnewpost.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Edycja wpisu</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="FieldInfo">Tytuł wpisu</span></label>
                                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Tytuł wpisu" value="<?php echo $TitleUp; ?>">
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Aktualna kategoria</span><?php echo $CategoryUp; ?><br>
                                <label for="categoryName"><span class="FieldInfo">Kategoria</span></label>

                                <select class="form-control" id="categoryName" name="Category">
                                    <?php
                                    global $ConnectingDB;
                                    $sql = "select id,name from category";
                                    $stmt = $ConnectingDB->query($sql);
                                    while ($DataRows = $stmt->fetch()){
                                        $catId = $DataRows["id"];
                                        $catName = $DataRows["name"];
                                        echo "<option> ". $catName ." </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Aktualna grafika: </span><?php echo $ImageUp; ?><br>
                                <img src="Uploads/<?php echo $ImageUp; ?>" height="70">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="selectImage" value="">
                                    <label for="selectImage" class="custom-file-label"></label>
                                </div>
                            <div class="form-group">
                                <label for="Post"><span class="FieldInfo">Wpis:</span></label>
                                <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80"><?php echo $PostUp; ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="index.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Powrót</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Zmień</button>
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
