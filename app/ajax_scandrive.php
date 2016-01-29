<?php
// 1. compare config genres to database genres -> give debugg message if database has mmore genres, database misses a genre
// make schnittminge of the two arrays
// 3. scan folder for folder names in /Filme/$genre
// 4. insert new movies in database


include '../core/FTPFilesystem.php';
include './config.php';

$genres = unserialize(GENRES);
$mysqli = new mysqli($d[0],$d[1],$d[2],$d[3]);


if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->query("SET NAMES 'utf8'");
// pull all genres in the database
$query = 'SELECT * FROM genres';
$myArray = array();
echo $mysqli->error;

if ($result = $mysqli->query($query)) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
		$dataGenres[] = $row['genre_name']; // for checking against config 
	
    }
}

switch ($a = count($dataGenres) - count($genres)) {

case ($a > 0):
	$genres = array_intersect($dataGenres, $genres);
	break;
case ($a < 0):
	$genres = array_intersect($dataGenres, $genres);
	break;
case $a == 0;
	// same size do nothing $genres doesnt change
	break;
}

// only pull intersect genres from database
$genreString = join("', '", array_values($genres));
$query = "SELECT * FROM genres WHERE genre_name IN ('".$genreString."');";
$dataGenres = array();
$result = $mysqli->query($query);
echo $mysqli->error;
echo $result->num_rows;
if ($result = $mysqli->query($query)) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {	

		$dataGenres[] = array('genre_name' => $row['genre_name'], 'genre_id' => $row['id']);
    }
}
var_dump($dataGenres);
//this needs heavy testing
//this will make a shit ton of querys but its okay ITS OKAY

// it would be much faster to fetch all movies in the database and then run this against the FTPdrive movies and and then insert the new ones. this will do for now
$movies = array();
$ftpdirve = FTPFilesystem::getInstance();
foreach($dataGenres as $genre)
{
	$moviesInFolder = $ftpdirve->getDirNames($genre['genre_name']);
	foreach($moviesInFolder as $movie)
	{
		//check if movie already has an entry
		$result	= $mysqli->query("SELECT COUNT(*) FROM movies WHERE movie_name = '".$movie."';");
		$exists = $result->fetch_row();
		if($exists[0] == '0'){
			// not catchin errors for better performance
			$result_movieInsert = $mysqli->query("INSERT INTO `movies` (`id`,`movie_name`) VALUES (NULL, '".$movie."');");
					if($result_movieInsert){
						$mysqli->query("INSERT INTO `genre_movie` (`id`, `genre_id`, `movie_id`) VALUES (NULL, '".$genre['genre_id']."', LAST_INSERT_ID());");
					}							
		} else {
		//echo "movie does already exist. MOVIE: ".$movie." genre id: ".$genre['genre_id'];
		}


	}
}





