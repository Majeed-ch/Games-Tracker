<?php
// Include gamesDAO file
require_once('./dao/gamesDAO.php');
$gamesDAO = new gamesDAO();

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Title</label>
                        <p><b><?php echo $title; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Release Date</label>
                        <p><b><?php echo $release; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Platforms</label>
                        <p><b><?php echo $platforms; ?></b></p>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 my-auto">
                            <img src="<?php echo $cover; ?>" class="img-fluid img-thumbnail" alt="Cover image of the game">
                        </div>
                    </div>

                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>