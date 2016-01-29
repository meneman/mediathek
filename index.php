<?php 
				include 'app/config.php';
				include 'core/FTPFilesystem.php';
				$genres = unserialize(GENRES);

?>
<html>
    <head>
        <meta charset="utf-8">
        
        
        

        
       <link rel="stylesheet" href="ressource/css/bootstrap.css" type="text/css" /> 
        
        <title>Mediathek </title>
        
        
        
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        <meta name="csrf-token" content="" />
    </head>
    <body>
        
        
        
    <!-- Navigation -->
    <nav class="navbar navbar-inverse" role="navigation">
        
    </nav>

            <!-- Page Content -->
    <div class="container">
        
        


        <div class="row">
            <div class="col-lg-12 text-center">
                 <div class="well"> 
                    <blockquote> <div id='joke'> </div></blockquote>
                 
         
            </div>
        </div>
        <!-- /.row -->
        <div class="container">
                
<div class="well">
    <div class="container" id=genreCheckbox>

            <div class="btn-group" data-toggle="buttons">
				<?php 
				foreach($genres as $genre){
						echo "<label class='btn btn-default'>";
						echo "<input type=radio id='".$genre."' class=genreradio name=genres[1] value='".$genre."' /> ".$genre;
						echo "</label>"; 
				}              
				?> 
            </div>
            

</div>    
<div class="container">
<br>
<button id="refresh" class="btn btn-danger" >Refresh movies</button>
<button id="scanDir" class="btn btn-danger" >Scan drive for new Movies</button>
</div>
    


<div id=movieTable></div>


        </div>
    </div>
    <!-- /.container -->
        


        
        <script src="ressource/js/jquery-1.12.0.min.js"></script>
        <script src="ressource/js/bootstrap.js"></script>
        <script src="ressource/js/libScript.js"></script>


    </body>

</html>