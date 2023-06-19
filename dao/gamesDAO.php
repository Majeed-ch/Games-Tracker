<?php
require_once('abstractDAO.php');
require_once('./model/games.php');

class gamesDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    /**
     * this function will retrieve one row from the database
     * where the id matches the passed parameter
     */
    public function getGame($gameId){
        // stores a query to get one row based on the id number.
        $query = 'SELECT * FROM games WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        // this will replace the ? in the query with the passed gameId.
        $stmt->bind_param('i', $gameId);
        $stmt->execute();
        // gets the result of the executed query
        $result = $stmt->get_result();
        // this will run the code if the query returned one row
        // if there's no row returned, then will skip and return false on this function
        if($result->num_rows == 1){
            // this will return an array containing values of the columns
            $temp = $result->fetch_assoc();

            $game = new Games($temp['id'],$temp['title'], $temp['release_date'], $temp['platforms'], $temp['cover']);
            $result->free();
            return $game;
        }
        $result->free();
        // if there is no data with the passed gameId
        return false;
    }

    /**
     * this function will retrieve the entire table of games
     * it will return an array of Games objects,
     * the array's elements corresponds to each row of the table.
     */
    public function getGames(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM games');
        $games = Array();

        // if the table form the query is not empty
        if($result->num_rows >= 1){
            // iterate over each element (table row) in the array
            while($row = $result->fetch_assoc()){
                //Create a new employee object, and add it to the array.
                $game_row = new Games($row['id'], $row['title'], $row['release_date'], $row['platforms'], $row['cover']);
                $games[] = $game_row;
            }
            $result->free();
            return $games;
        }
        $result->free();
        // if the table is empty
        return false;
    }   
    
    public function addGame($game){
        
        if(!$this->mysqli->connect_errno){
            /**
            The query uses the question mark (?) as a
            placeholder for the parameters to be used in the query.
            The prepare method of the mysqli object returns
            a mysqli_stmt object. It takes a parameterized
            query as a parameter.
            */
			$query = 'INSERT INTO games (Title, release_date, Platforms, Cover) VALUES (?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $title = $game->getTitle();
			        $release = $game->getReleasedate();
			        $platforms = $game->getPlatforms();
                    $cover = $game->getCover();
                  
			        $stmt->bind_param('ssss',
				        $title,
				        $release,
				        $platforms,
                        $cover
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $game->getTitle() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   
    public function updateGame($game){
        
        if(!$this->mysqli->connect_errno){
            /**
            The query uses the question mark (?) as a
            placeholder for the parameters to be used
            in the query.
            The prepare method of the mysqli object returns
            a mysqli_stmt object. It takes a parameterized
            query as a parameter.
            */
            $query = "UPDATE games SET Title=?, release_date=?, Platforms=?, Cover=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $game->getId();
                    $title = $game->getTitle();
			        $release = $game->getReleasedate();
			        $platforms = $game->getPlatforms();
                    $cover = $game->getCover();

                    $stmt->bind_param('ssssi',
                        $title,
                        $release,
                        $platforms,
                        $cover,
                        $id
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $game->getTitle() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deleteGame($gameId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM games WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $gameId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>

