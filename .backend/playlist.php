<!DOCTYPE html>
<html>

<head>
    <title>Spotify Playlist - Playify</title>
    <link rel="stylesheet" type="text/css" href="css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
	<link rel="icon" href="icon.png">
    <style type="text/css">
	  	* {
	    	user-select: none;
	  	}
      
		.green.accent-4 {
			background-color: #10BC4C !important;
		}

		.green-text.accent-4 {
			color: #10BC4C !important;
		}
		
		.collection li img {
	        position: absolute;
	        width: 42px;
	        height: 42px;
	        overflow: hidden;
	        left: 15px;
	        display: inline-block;
	        vertical-align: middle;
	    }

	    .progress-footer {
		    background-size: 0%;
		    background-image: linear-gradient(to bottom, #26a69a, #26a69a);
		    background-repeat: repeat-y;
		    transition: background-size ease .5s, height ease .5s, background-color ease .5s;
	    }
    </style>
</head>

<body>
    <nav class="green accent-4" role="navigation">
        <div class="nav-wrapper container">
        	<a id="logo-container" href="#!" class="brand-logo">Playify</a>
        </div>
    </nav>

	<div class="container">
		<br><br>
		<h1 class="center header green-text accent-4">Playlist</h1>
		<br><br>
		<ul class="collection">
		    <?php
				$tracks = array();
				for ($i=0; $i<count($res["items"]); $i++) {
					$searchword = $res["items"][$i]["track"]["name"]." - ".$res["items"][$i]["track"]["artists"][0]["name"];
					array_push($tracks, $searchword);
					?>
					<li class="collection-item avatar">
					  <img src="<?php echo $res["items"][$i]["track"]["album"]["images"][2]["url"]; ?>" alt="Album cover">
					  <span class="title"><?php echo $res["items"][$i]["track"]["name"]; ?></span>
					  <p><?php
						$artists = "";
						$i2max = count($res["items"][$i]["track"]["artists"]);
						for ($i2=0; $i2<$i2max; $i2++) {
							$artists .= $res["items"][$i]["track"]["artists"][$i2]["name"];
							if ($i2 + 1 < $i2max) {
								$artists .= ", ";
							}
						}
						echo $artists;
						echo "<br>";
						echo $res["items"][$i]["track"]["album"]["name"];
						  ?></p>
						
							<?php 
								if ($_GET["d"] == "gpmdp") { 
							?>
								<a data-search="<?php echo str_replace('"', '\"', $searchword); ?>" class="secondary-content gpmdp" style="cursor:pointer;" target="_blank">
							<?php } else { ?>
								<a href="<?php echo getLink($searchword); ?>" class="secondary-content" target="_blank">
							<?php } ?>
									
						<svg fill="#000000" height="32" viewBox="0 0 24 24" width="32" xmlns="http://www.w3.org/2000/svg">
							<path d="M8 5v14l11-7z"/>
							<path d="M0 0h24v24H0z" fill="none"/>
						</svg>      
					  </a>
					</li>
					<?php
				}
			?>
		</ul>

	    <?php if ($_GET["d"] == "gpm" || $_GET["d"] == "gpmdp") { ?>
			<div class="fixed-action-btn horizontal export-playlist">
		      <a class="btn-floating btn-large red center waves-effect waves-light tooltipped" style="line-height: 76px" data-tooltip="Export playlist" data-position="left">
		        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAABlBMVEX///////9VfPVsAAAAAXRSTlMAQObYZgAAACZJREFUeAFjGNlgFDACAbkaRjWMamDEAwahBoo8PaphVMOIBqMAAMTdANFjxU67AAAAAElFTkSuQmCC" width="32">
		      </a>
		    </div>
		<?php } ?>
		
		<div class="modal" id="transfer-auth">
			<div class="modal-content">
				<h4>Please login</h4>
				<div class="row">
        	<div class="input-field col s6">
						<input placeholder="user@gmail.com" id="transfer-gmail" type="email" class="validate" autocomplete="off">
					</div>
					<div class="input-field col s6">
						<input placeholder="Password" id="transfer-gpass" type="password" class="validate" autocomplete="off">
					</div>
				</div>
				<input placeholder="Transfer password" id="transfer-pass" type="password" class="validate" autocomplete="off">
				<!-- FAQ -->
				<ul class="collapsible" data-collapsible="accordion">
					<li>
						<div class="collapsible-header">What is my Transfer password?</div>
						<div class="collapsible-body"><span>It is the password you set when installing Transfer. If you lost it, the password is stored in plain text as "password.txt" file in the path you've installed Transfer.</span></div>
					</li>
					<li>
						<div class="collapsible-header">Why do I have to enter my Google account data instead of logging in with OAuth?</div>
						<div class="collapsible-body"><span>Google Play Music does not offer an API, so a few workarounds are needed to transfer your playlists. Playify and Transfer are both open-source, so you don't have to worry about your data.</span></div>
					</li>
				</ul>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-action waves-effect waves-light btn-flat modal-close" id="transfer-login">Login</a>
			</div>
		</div>
		
		<div class="modal modal-fixed-footer" id="transfer-start">
			<div class="modal-content">
				<div class="config">
					<h4>Preparing the transfer</h4>
					<div class="input-field">
						<select>
							<option value="">Create a new playlist...</option>
						</select>
					</div>
					<div class="input-field">
						<input type="text" class="validate" placeholder="Playlist name" id="transfer-playlist-name">
					</div>
				</div>

				<img src="data:image/svg+xml;base64,PHN2ZyBmaWxsPSIjMTBiYzRjIiBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4gICAgPHBhdGggZD0iTTAgMGgyNHYyNEgweiIgZmlsbD0ibm9uZSIvPiAgICA8cGF0aCBkPSJNOSAxNi4xN0w0LjgzIDEybC0xLjQyIDEuNDFMOSAxOSAyMSA3bC0xLjQxLTEuNDF6Ii8+PC9zdmc+" style="width: 40%; display: none; margin-top: 50px; transform: scale(1.5);">

				<ul class="collection with-header errors" style="display: none">
        			<li class="collection-header"><h4 style="margin: 1.14rem 0 .912rem 0;"></h4></li>
        		</ul>
			</div>
			<div class="modal-footer progress-footer">
				<span></span>
				<a href="#!" class="btn-flat modal-action waves-effect waves-light" id="transfer-logout">Log out</a>
				<a href="#!" class="btn-flat modal-action waves-effect waves-light" id="transfer-confirm">Start transfer</a>
			</div>
		</div>
	</div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript">
			var tracks = <?php echo json_encode($tracks); ?>;
			
			var parser = document.createElement("a");
			parser.href = window.location.href;
			var payload = parser.hash.substring(1);

			var old_payload;

			var gpmdp = {readyState: 0};
			
			$("select").material_select();

			$("a.gpmdp").on("click", function(){
		        var search = $(this).attr("data-search");

				if (gpmdp.readyState != 1) {
					gpmdp = new WebSocket("ws://localhost:5672");
		        
			        gpmdp.onmessage = function(message) {
			            var data = JSON.parse(message.data);
			            
			            if (data.channel == "connect") {
			                if (data.payload == "CODE_REQUIRED") {
			                    Materialize.toast("Could not play song in GPMDP - is it set up correctly?");
			                }
			            }
			            
						if (data.channel == "search-results" && old_payload != data.payload.searchText && data.payload.searchText != "") {
							gpmdp.send(JSON.stringify({
									namespace: "search",
									method: "playResult",
									arguments: [data.payload.tracks[0]]
							}));
		      				Materialize.toast("Playing in GPMDP...", 1000);
							old_payload = data.payload.searchText;
			            }
			        };

			        gpmdp.onopen = function() {
			            gpmdp.send(JSON.stringify({
			                namespace: "connect",
			                method: "connect",
			                arguments: ["Playify", payload]
			            }));
			            gpmdp.send(JSON.stringify({
			                namespace: "search",
			                method: "performSearch",
			                arguments: [search]
			            }));
			        };

			        gpmdp.onerror = function() {
			            Materialize.toast("Could not play song in GPMDP - is it set up correctly?");
			        };
			    }
			    else {
			    	gpmdp.send(JSON.stringify({
		                namespace: "connect",
		                method: "connect",
		                arguments: ["Playify", payload]
		            }));
		            gpmdp.send(JSON.stringify({
		                namespace: "search",
		                method: "performSearch",
		                arguments: [search]
		            }));
			    }
			});
			
			
			var transfer = {readyState: 0};
			var progress = 0;
			var errors = 0;

			$(".export-playlist").on("click", function(){
				$(this).prop("disabled", true);
				
				if (transfer.readyState != 1) {
					transfer = new WebSocket("ws://localhost:5673");
					
					transfer.onopen = function() {
						if (localStorage.getItem("transferauth") === null) {
							$("#transfer-auth").modal("open");
							$("#transfer-auth input").removeClass("valid invalid").addClass("validate");
						}
						else {
							var auth = JSON.parse(localStorage.getItem("transferauth"));
							transfer.send(JSON.stringify({
								q: "auth",
								auth: auth.pass
							}));
						}
					};
					
					transfer.onmessage = function(message) {
						console.log(message.data);
						var data = JSON.parse(message.data);
						if (data.q == "auth") {
							if (data.error) {
								$("#transfer-auth").modal("open");
								if (data.google) {
									$("#transfer-gpass, #transfer-gmail").removeClass("validate valid").addClass("invalid");
									$("#transfer-pass").removeClass("validate invalid").addClass("valid");
								}
								else {
									$("#transfer-pass").removeClass("validate valid").addClass("invalid");
									$("#transfer-gpass, #transfer-gmail").removeClass("validate invalid").addClass("valid");
								}
							}
							else {
								var auth = JSON.parse(localStorage.getItem("transferauth"));
								transfer.send(JSON.stringify({
									q: "get_playlists",
									auth: auth.pass,
									email: auth.gmail,
									password: auth.gpass
								}));
							}
						}
						
						if (data.q == "playlists") {
							var auth = JSON.parse(localStorage.getItem("transferauth"));
							$("#transfer-start select").html("<option value=''>Create a new playlist...</option>");
							$.each(data.lists, function(){
								$("#transfer-start select").append("<option value='"+this.id+"'>"+this.name+"</option>");
							});
							$("select").material_select();
							$("#transfer-start .modal-footer span").html(auth.gmail);
							$("#transfer-start").modal("open");
						}

						if (data.q == "progress") {
							progress++;
							$(".progress-footer").css("background-size", progress / tracks.length * 100 + "%")

							if (data.error == true) {
								if (errors == 0) {
									$("#transfer-start .errors").slideDown();
								}

								errors++;
								$("#transfer-start .errors .collection-header h4").text(errors + " song" + (errors>1&&"s"||"") + " not found")
										.parent().parent().append('<li class="collection-item">' + data.track + '</li>');
							}

							if (progress == tracks.length) {
								$("#transfer-start .config").slideUp();
								$("#transfer-start .modal-content img").fadeIn(500).delay(2000).fadeOut(500, function(){
									$("#transfer-start").modal("close");
								});

								if (errors == 0) {
									$("#transfer-start .modal-content").css("text-align", "center");

								}
							}

						}
					};
					
					transfer.onerror = function() {
						Materialize.toast("Could not connect to Transfer - is it set up correctly?");
					};
				}
				else {
					if (localStorage.getItem("transferauth") === null) {
						$("#transfer-auth").modal("open");
						$("#transfer-auth input").removeClass("valid invalid").addClass("validate");
					}
					else {
						var auth = JSON.parse(localStorage.getItem("transferauth"));
						transfer.send(JSON.stringify({
							q: "auth",
							auth: auth.pass
						}));
					}
				}
			});
			
			$("#transfer-login").on("click", function(){
				localStorage.setItem("transferauth", JSON.stringify({
					gmail: $("#transfer-gmail").val(),
					gpass: $("#transfer-gpass").val(),
					pass: $("#transfer-pass").val()
				}));
				setTimeout(function(){
					$(".export-playlist").trigger("click");
				}, 750);
			});

			$("#transfer-logout").on("click", function(){
				localStorage.clear();
				$("#transfer-start").modal("close");
				setTimeout(function(){
					$(".export-playlist").trigger("click");
				}, 750);
			});
			
			$("#transfer-confirm").on("click", function(){
				var auth = JSON.parse(localStorage.getItem("transferauth"));
				
				if ($("#transfer-start select").val() == "") {
					var new_playlist = true;
					var playlist = $("#transfer-playlist-name").val();
				}
				else {
					var new_playlist = false;
					var playlist = $("#transfer-start select").val();
				}

				$(".progress-footer span").fadeOut();
				$(".progress-footer a").fadeOut(function(){
					$("#transfer-start .modal-content").css("height", "calc(100% - 5px)");
					$(".progress-footer").css({
						"height": "5px",
						"background-color": "#acece6"
					});
				});
				
				transfer.send(JSON.stringify({
					q: "transfer_playlist",
					auth: auth.pass,
					email: auth.gmail,
					password: auth.gpass,
					new_playlist: new_playlist,
					playlist: playlist,
					tracks: tracks
				}));

				$(".export-playlist").fadeOut();
			});
			
			$("#transfer-start select").on("change", function(){
				if ($(this).val() == "") {
					$("#transfer-playlist-name").show();
				}
				else {
					$("#transfer-playlist-name").hide();
				}
			});
		</script>
</body>

</html>