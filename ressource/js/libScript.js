

$(document).ready(function() {

    var  movies;
	function refresh(){
        $.get('app/ajax_refresh.php', function(data) {
                localStorage.setItem("movies", data);
                
                movies =$.parseJSON(data);
				// console.log(movies);
				updateTable('all');
        });
    }    
		
		
	function updateJoke(){
		 $.get('http://api.icndb.com/jokes/random/', function(data) {
			// console.log(data);
			$('#joke').text(data.value.joke);
        });
		
	}
        
    
   
    
    
    $('#refresh').click(function(){
        refresh();
        updateJoke();
    });
	
    $('#scanDir').click(function(){
		scanDrive(); 
    });
    

    $('input[type=radio][class=genreradio]').change(function() {
        console.log('selected Genre: '+this.value);
        updateTable(this.value);
    });

	function scanDrive(){
		        $.get('app/ajax_scandrive.php', function(data) {
					console.log('mapped movies vom drive to database');
					refresh();
        });
	}
 
 
	function getDateDifferenceToNow(timestamp1){
		
		
		// Split timestamp into [ Y, M, D, h, m, s ]
		var t = timestamp1.split(/[- :]/);

		// Apply each element to the Date function
		var d1 = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
		var d2 = new Date(); 
		
		return Math.floor(((d2- d1)/1000) * 0.0000115741); // this calculates the days inbetween the two dates and rounds them down, so 1,7 days is still 1 day 

	}
 
 
    
    // Function which sorts the data for the Table
    // param: value (Movie genre)
    function updateTable(value) {
        console.log('updating Table');
        if(movies == null){
            refresh();
        }
        var filteredMovies = [];
        
        
       if(value == "all"){
           return buildHtmlTable(movies);
       } else {
       
           
            $.each(movies,function(i, item){
        
                if(item.genreArray.includes(value)){
                    filteredMovies.push(item);
                }
        
            });
             
            return buildHtmlTable(filteredMovies);
       }
            
    };


        
        
        
function buildHtmlTable(filtedMovies) {
	//remove old Table
	$('#movieTable').children().remove();
	// create table
	var $table = $('<table>').addClass('table table-striped')

	// thead
	$table
	.append('<thead>').children('thead')
	.append('<tr />').children('tr').append('<th>Name</th><th>Genre</th><th>Added</th>');

	//tbody
	var $tbody = $table.append('<tbody />').children('tbody');


	$.each(filtedMovies, function (i, movie) {
		
	$tbody.append('<tr />').children('tr:last')
	.append("<td>"+movie.movie_name+"</td>")
	.append("<td>"+ movie.genreArray.toString()+"</td>")
	.append("<td> Added "+getDateDifferenceToNow(movie.created_at)+" days ago</td>");


	});


	// add table to dom
	$table.appendTo('#movieTable');

			
		
}

//initial load;
refresh();




});
    
