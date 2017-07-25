<?php
function getLink ($search) {
  $domains = array();
  $domains["list"] = array("gpm","amazon", "youtube", "gpmdp");
  $domains["gpm"] = "https://play.google.com/music/listen#/sr/#s#";
  $domains["amazon"] = "https://music.amazon#e#/search/#s#";
  $domains["youtube"] = "https://youtube.com/results?search_query=#s#";
  $domains["amazontlds"] = array(".com",".de",".co.uk",".at");
  
  if (!in_array($_GET["d"], $domains["list"])) {
    $domain = "gpm";
  }
  else {
    $domain = $_GET["d"];
  }
  
  if (!in_array($_GET["e"], $domains["amazontlds"])) {
    $tld = ".com";
  }
  else {
    $tld = $_GET["e"];
  }
  
  if ($domain == "gpmdp") {
    $category = $_GET["type"]."s";
    include("gpmdp.php");
    exit;
  }

  return str_replace("#s#", urlencode($search), str_replace("#e#", $tld, $domains[$domain]));
}
?>