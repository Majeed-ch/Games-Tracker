<?php
// Include gamesDAO file
require_once('./dao/gamesDAO.php');
 
// Define variables and initialize with empty values
$title = $release = $platforms = $cover = "";
$title_err = $release_err = $platforms_err = "";
$target_dir = "imgs/";

$gamesDAO = new gamesDAO();

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter a game title.";
    } elseif(strlen($input_title) > 255){
        $title_err = "Please enter a Maximum characters of 255.";
    } else{
        $title = $input_title;
    }
    
    // Validate release date
    $input_release = trim($_POST["release"]);
    if(empty($input_release)){
        $release_err = "Please enter a release date.";
    } elseif($input_release < '2022-01-01' || $input_release > '2023-01-01'){
        $release_err = "Please enter a date in the year 2022 only.";
    } else{
        $release = $input_release;
    }

    // Validate platforms
    $input_platforms = trim($_POST["platforms"]);
    if(empty($input_platforms)){
        $platforms_err = "Please enter the platforms this game is available on.";
    } elseif(strlen($input_title) > 255){
        $platforms_err = "Please enter a Maximum characters of 255.";
    } else{
        $platforms = $input_platforms;
    }

    // check if an image selected
    if (array_key_exists('cover', $_FILES)) {
        $fileToUpload = basename($_FILES["cover"]["name"]);
        // name of the image to upload
        $cover = $target_dir . $fileToUpload;
        // move the file to imgs folder
        move_uploaded_file($_FILES["cover"]["tmp_name"], $cover);
    }
    else {
        $cover = $gamesDAO->getGame($id)->getCover();
    }

    // Check input errors before inserting in database
    if(empty($title_err) && empty($release_err) && empty($platforms_err)){
        $game = new Games($id, $title, $release, $platforms, $cover);
        $result = $gamesDAO->updateGame($game);
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $gamesDAO->getMysqli()->close();
    }

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $game = $gamesDAO->getGame($id);
                
        if($game){
            // Retrieve individual field value
            $title = $game->getTitle();
            $release = $game->getReleasedate();
            $platforms = $game->getPlatforms();
            $cover = $game->getCover();
        } else{
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $gamesDAO->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background: #2a2a2a;
            color: snow;
        }
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the games record.</p>

                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="date" name="release" min="2022-01-01" max="2023-12-31" class="form-control <?php echo (!empty($release_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $release; ?>">
                            <span class="invalid-feedback"><?php echo $release_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Platforms</label>
                            <input type="text" name="platforms" class="form-control <?php echo (!empty($platforms_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $platforms; ?>">
                            <span class="invalid-feedback"><?php echo $platforms_err;?></span>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="checkbox" onclick="myFunction()">
                            <label class="form-check-label" for="checkbox">Update cover image?</label>
                            <br><br><label >Upload game cover</label>
                            <input type="file" name="cover" id="cover" class="form-control" disabled="true" style="background-color: rgba(255,255,255,0)">
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    <script>
        function myFunction() {
            let check = document.getElementById("checkbox");
            let upload = document.getElementById("cover")
            if(check.checked){
                upload.disabled = false;
                upload.style = "background-color: rgba(255,255,255,100)";
            }
            else {
                upload.disabled = true;
                upload.style = "background-color: rgba(255,255,255,0)";
            }
        }
    </script>
</body>
</html>