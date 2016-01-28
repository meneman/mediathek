<?php 

include '../app/config.php';

// the tables still have to be created manually

$genres = unserialize(GENRES);
$mysqli = new mysqli("localhost", "root", "", "media");


/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$mysqli->query("SET NAMES 'utf8'");

//create Tables
$sqlGenreTable = "CREATE TABLE genres (
id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
genre_name VARCHAR(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET='utf8';";


$sqlMovieTable = "CREATE TABLE movies (
id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `movie_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$sqlPivotTable = "CREATE TABLE genre_movie (
id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `genre_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$mysqli->query($sqlGenreTable );
$mysqli->query($sqlMovieTable);
$mysqli->query($sqlPivotTable);
echo $mysqli->error;
// druncat genre table 
$mysqli->query('TRUNCATE TABLE `genres`');

// Insert genres
foreach($genres as $genre){
	$query = "INSERT INTO `genres` (`id`, `genre_name`) VALUES (NULL, '$genre');";
	$mysqli->query($query);
}