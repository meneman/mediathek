<?php 
error_reporting(-1);


include('../core/FTPFilesystem.php');
include('./config.php');
// ajax Script this shits spagethi yo
$genres = unserialize(GENRES);
//if((in_array($_GET['genre'], $genres) OR $_GET['genre'] == 'all') ? $genre = $_GET['genre'];
$genre = 'all';
$mysqli = new mysqli($d[0],$d[1],$d[2],$d[3]);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->query("SET NAMES 'utf8'");
if($genre == 'all'){
	$query = 'SELECT * FROM movies';
} else {
	$query ='SELECT * FROM movies WHERE genre ='.$genre;
}


$query = '
SELECT movies.created_at,movies.movie_name, group_concat(genres.genre_name) AS genre_names FROM genres 
INNER JOIN genre_movie ON genres.id = genre_movie.genre_id 
INNER JOIN movies ON movies.id = genre_movie.movie_id
GROUP BY movies.movie_name
ORDER BY created_at DESC;';

$mysqli->query($query);

$myArray = array();
echo $mysqli->error;
if ($result = $mysqli->query($query)) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = array('created_at' => $row['created_at'], 'movie_name' => $row['movie_name'], 'genreArray' => explode(',',$row['genre_names']));
    }
}


    echo json_encode($myArray);


