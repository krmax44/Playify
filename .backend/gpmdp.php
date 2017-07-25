<!DOCTYPE html>
<html>

<head>
    <title>Google Play Music Desktop Player - Playify</title>
    <link rel="stylesheet" type="text/css" href="css/materialize.min.css">
    <link rel="icon" href="icon.png">
    <style type="text/css">
    body {
        font-family: "Roboto", sans-serif;
    }
    
    .green.accent-4 {
        background-color: #10BC4C !important;
    }
    
    .green-text.accent-4 {
        color: #10BC4C !important;
    }
    
    .hidden {
        display: none;
    }
    /* loading animation from https://codepen.io/peterssonjesper/pen/LvpqB */
    
    .eq-spinner {
        height: 20px;
        width: 21px;
        margin: 100px auto;
        transform: rotate(180deg);
    }
    
    .eq-spinner:before,
    .eq-spinner:after,
    .eq-spinner > i {
        float: left;
        width: 5px;
        height: 20px;
        background: #10BC4C;
        margin-left: 3px;
        content: "";
    }
    
    .eq-spinner:before {
        margin-left: 0;
    }
    
    .eq-spinner:before {
        animation: bounce-3 1s infinite linear;
    }
    
    .eq-spinner > i {
        animation: bounce-2 1s infinite linear;
    }
    
    .eq-spinner:after {
        animation: bounce-1 1s infinite linear;
    }
    
    @keyframes bounce-1 {
        0% {
            height: 1px
        }
        16.7% {
            height: 20px
        }
        33.4% {
            height: 20px
        }
        100% {
            height: 1px
        }
    }
    
    @keyframes bounce-2 {
        0% {
            height: 1px
        }
        16.7% {
            height: 1px
        }
        33.4% {
            height: 20px
        }
        50% {
            height: 20px
        }
        100% {
            height: 1px
        }
    }
    
    @keyframes bounce-3 {
        0% {
            height: 1px
        }
        33.4% {
            height: 1px
        }
        50% {
            height: 20px
        }
        66.7% {
            height: 20px
        }
        100% {
            height: 1px
        }
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
        <br>
        <br>
        <h1 class="center header green-text accent-4">GPMDP</h1>
        <br>
        <br>
        <div class="playing center">
            <div class="eq-spinner"><i></i></div>
            <p>
              Opened it in GPMDP.
          </p>
        </div>
        <div class="error center hidden">
            <p>
                Error: GPMDP is probably configured wrong. Please click on the Playify icon in Chrome and select 'Setup' next to 'Google Play Music Desktop Player'.
            </p>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
    var socket = new WebSocket("ws://localhost:5672");
    var parser = document.createElement("a");
    parser.href = window.location.href;
    var payload = parser.hash.substring(1);

    socket.onmessage = function(message) {
        var data = JSON.parse(message.data);

        if (data.channel == "connect") {
            if (data.payload == "CODE_REQUIRED") {
                $(".playing").hide();
                $(".error").show();
            }
        }
      
        if (data.channel == "search-results" && data.payload.searchText == "<?php echo $search; ?>") {
          console.log(data.payload.<?php echo $category; ?>[0]);
            console.log("sending");
            socket.send(JSON.stringify({
                namespace: "search",
                method: "playResult",
                arguments: [data.payload.<?php echo $category; ?>[0]]
            }));
            <?php
              if (intval($_GET["v"]) >= 2) {
                ?>
                setTimeout(function(){
                  window.location.href = "https://krmax44.de/playify/close";
                }, 2000);
                <?php
              }
            ?>
        }
    };

    socket.onopen = function() {
        socket.send(JSON.stringify({
            namespace: "connect",
            method: "connect",
            arguments: ["Playify", payload]
        }));
        socket.send(JSON.stringify({
            namespace: "search",
            method: "performSearch",
            arguments: ["<?php echo $search; ?>"]
        }));
    };

    socket.onerror = function() {
        $(".playing").hide();
        $(".error").show();
    };
    </script>
</body>

</html>