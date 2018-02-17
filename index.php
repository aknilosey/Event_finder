<?php 
include("includes/header.php");


if(isset($_POST['post'])){
	$post = new Post($con, $userLoggedIn);
	$post->submitPost($_POST['post_text'], 'none');
}


 ?>
	<div class="user_details column">
		<a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right">
			<a href="<?php echo $userLoggedIn; ?>">
			<?php 
			echo $user['first_name'] . " " . $user['last_name'];

			 ?>
			</a>
			<br>
			<?php echo "Events: " . $user['num_posts']. "<br>"; 
			//echo "Likes: " . $user['num_likes'];

			?>
		</div>

	</div>

	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST">
			<textarea name="post_text" id="post_text" placeholder="Create an event"></textarea>
			<input type="submit" name="post" id="post_button" value="Post">
			<hr>

		</form>
		<!--akku-->
		<button onclick="getLocation()">Location</button>
		<p id="demo"></p>

		
        <script src="http://maps.google.com/maps/api/js?key=AIzaSyAoeNMQxTEkTFm4H-zNu5opnc_pUQBRb2c"></script>
	    <script>
			var x=document.getElementById("demo");
			function getLocation(){
			    if (navigator.geolocation){
			        navigator.geolocation.getCurrentPosition(showPosition,showError);
			    }
			    else{
			        x.innerHTML="Geolocation is not supported by this browser.";
			    }
			}

			function showPosition(position){
			    lat=position.coords.latitude;
			    lon=position.coords.longitude;
			    displayLocation(lat,lon);
			}

			function showError(error){
			    switch(error.code){
			        case error.PERMISSION_DENIED:
			            x.innerHTML="User denied the request for Geolocation."
			        break;
			        case error.POSITION_UNAVAILABLE:
			            x.innerHTML="Location information is unavailable."
			        break;
			        case error.TIMEOUT:
			            x.innerHTML="The request to get user location timed out."
			        break;
			        case error.UNKNOWN_ERROR:
			            x.innerHTML="An unknown error occurred."
			        break;
			    }
			}

			function displayLocation(latitude,longitude){
			    var geocoder;
			    geocoder = new google.maps.Geocoder();
			    var latlng = new google.maps.LatLng(latitude, longitude);

			    geocoder.geocode(
			        {'latLng': latlng}, 
			        function(results, status) {
			            if (status == google.maps.GeocoderStatus.OK) {
			                if (results[0]) {
			                    var add= results[0].formatted_address ;
			                    var  value=add.split(",");

			                    count=value.length;
			                    country=value[count-1];
			                    state=value[count-2];
			                    city=value[count-3];
			                    x.innerHTML = "city name is: " + city;
							    $.ajax({
							                       type: "POST",
							                       url: 'index.php',
							                       data: "indi=" + city,
							                       success: function(data)
							                       {
							                           alert("success!");
							                       }
							                   });
			                }
			                else  {
			                    x.innerHTML = "address not found";
			                }
			            }
			            else {
			                x.innerHTML = "Geocoder failed due to: " + status;
			            }
			        }
			    );
			}
			</script>
		<?php
			$iid = isset($_POST['indi']);
			
		?>
		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">


	</div>

	<div class="user_details column">

		<h4>Popular</h4>

		<div class="trends">
			<?php 
			$query = mysqli_query($con, "SELECT * FROM Event");

			foreach ($query as $row) {
				
				$word = $row['eventTitle'];
				$word_dot = strlen($word) >= 14 ? "..." : "";

				$trimmed_word = str_split($word, 14);
				$trimmed_word = $trimmed_word[0];

				echo "<div style'padding: 1px'>";
				echo $trimmed_word . $word_dot;
				echo "<br></div><br>";


			}

			?>
		</div>


	</div>




	<script>
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';

	$(document).ready(function() {

		$('#loading').show();

		//Original ajax request for loading first posts 
		$.ajax({
			url: "includes/handlers/ajax_load_posts.php",
			type: "POST",
			data: "page=1&userLoggedIn=" + userLoggedIn,
			cache:false,

			success: function(data) {
				$('#loading').hide();
				$('.posts_area').html(data);
			}
		});

		$(window).scroll(function() {
			var height = $('.posts_area').height(); //Div containing posts
			var scroll_top = $(this).scrollTop();
			var page = $('.posts_area').find('.nextPage').val();
			var noMorePosts = $('.posts_area').find('.noMorePosts').val();

			if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
				$('#loading').show();

				var ajaxReq = $.ajax({
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
					cache:false,

					success: function(response) {
						$('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 

						$('#loading').hide();
						$('.posts_area').append(response);
					}
				});

			} //End if 

			return false;

		}); //End (window).scroll(function())


	});

	</script>




	</div>
</body>
</html>