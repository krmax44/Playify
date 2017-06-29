<!DOCTYPE html>
<html>

<head>
    <title>Spotify Playlist - Playify</title>
    <link rel="stylesheet" type="text/css" href="css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
	<link rel="icon" href="icon.png">
    <style type="text/css">
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
				for ($i=0; $i<count($res["items"]); $i++) {
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
						
							<?php if ($_GET["d"] == "gpmdp") { ?>
								<a data-search="<?php echo $res["items"][$i]["track"]["id"]; ?>" class="secondary-content gpmdp" style="cursor:pointer;" target="_blank">
							<?php } else { ?>
								<a href="<?php echo getLink($res["items"][$i]["track"]["name"]." - ".$res["items"][$i]["track"]["artists"][0]["name"]); ?>" class="secondary-content" target="_blank">
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
	</div>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript">
			var parser = document.createElement("a");
			parser.href = window.location.href;

			$("a.gpmdp").on("click", function(){
				var win = window.open("/playify/?d=gpmdp&type=track&q="+$(this).attr("data-search")+parser.hash, "_blank");
  			win.focus();
			});
		</script>
</body>

</html>