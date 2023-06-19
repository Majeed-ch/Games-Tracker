<?php
// Include employeeDAO file
require_once('./dao/gamesDAO.php');

 
// Define variables and initialize with empty values
$title = $release = $platforms = $cover = "";
$title_err = $release_err = $platforms_err = $cover_err = "";
$target_dir = "imgs/";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
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

    // validate image upload
    $fileToUpload = basename($_FILES["cover"]["name"]);
    if(empty($fileToUpload)){
        $cover_err = "Please select an image to upload";
    } else {
        // name of the image to upload
        $cover = $target_dir . $fileToUpload;
        // move the file to imgs folder
        move_uploaded_file($_FILES["cover"]["tmp_name"], $cover);
    }

    // Check input errors before inserting in database
    if(empty($title_err) && empty($release_err) && empty($platforms_err) && empty($cover_err)){
        $gamesDAO = new gamesDAO();
        $game = new Games(0, $title, $release, $platforms, $cover);
        $addResult = $gamesDAO->addGame($game);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $gamesDAO->getMysqli()->close();
        }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background: #2a2a2a;
            color: snow;
        }
        .invalid{
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>To add a new game to the database
                    , please fill this form correctly and submit.</p>
					
					<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="date" name="release" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" min="2022-01-01" max="2023-12-12">
                            <span class="invalid-feedback"><?php echo $release_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Platforms</label>
                            <input type="text" name="platforms" class="form-control <?php echo (!empty($platforms_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $platforms; ?>">
                            <span class="invalid-feedback"><?php echo $platforms_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Upload game cover</label>
                            <input type="file" name="cover" id="cover" class="form-control">
                            <span class="invalid"><?php echo $cover_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
        <?include 'footer.php';?>
    </div>
</body>
</html>
<!--
<?php /*echo (!empty($cover_err)) ? 'is-invalid' : ''; */?>

-->