<?php

/*if (isset($_GET['url']) && isset($_GET['type']) && isset($_GET['typeValue'])) {
  get_dataFrom($_GET['url'],$_GET['type'],$_GET['typeValue']);
} else {
  echo "parameters not match!";
}*/


get_dataFrom("http://news.detik.com/berita/3213983/ui-sampaikan-duka-cita-atas-meninggalnya-tegar-yang-kepalanya-terbentur-tiang-kantin","class","detail_text");


function get_redirectURL($otherURL='')
{
  $url=$otherURL;
  $pattern = array();
  $pattern[0] ="/\\\/";
  $replacement = array();
  $replacement[0] = "";
  $url=preg_replace($pattern, $replacement, $url);
  // echo $url;
  // die();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $a = curl_exec($ch); // $a will contain all headers

    $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // This is what you need, it will return you the last effective URL

    return $url;
    // echo $url;
}

function get_dataFrom($url, $type, $typeValue)
{
  $url = get_redirectURL($url);
  $xhtml = file_get_contents($url);
  
  $value=preg_match_all('/<div '.$type.'=\"'.$typeValue.'">(.*?)<\/div>/s',$xhtml,$estimates);
  if ($value > 0) {
  // echo "<pre>";
    echo "
      <html><head>
        <style type='text/css'>
          img {
            width: 100%;
            height:auto;
          }
        </style></head>
        <body>".$estimates[0][0]."</body></html>";  
  } else {
    echo "your type value not match!<br><br>";
    echo ("url : ".$url."<br>");
    echo ("type : ".$type."<br>");
    echo ("typeValue : ".$typeValue."<br>");
  }
  
}

?>