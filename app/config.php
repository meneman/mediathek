<?php

error_reporting(-1);

$genres= [
'Action',
'Komödie',
'Zeichentrick',
'Drama',
'Mädchenfilme',
'Horror',
'James Bond Collection',
'Serien'
];

define ("GENRES", serialize ($genres));
// mysqli connection parameters: host, user, password, database
$d = ["localhost", "root", "", "media"];