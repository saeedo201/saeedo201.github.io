<?php
/*  have fun  .. :) */
#GET TOKEN FROM SNAP
#I used this : https://accounts.snapchat.com/accounts/signup?client_id=scan
function _getToken($url){
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_URL,$url);
  $done = curl_exec($ch);
  if(preg_match_all('/<div id="sign-up-root" data-xsrf="(.*?)"(.*?)>/is',$done,$token)):
    return $token[1][0];
    #print_r to show all result that came from preg_match_all
    //print_r($token);
  endif;
}
// if u want to call function like:
// _getToken("https://accounts.snapchat.com/accounts/signup?client_id=scan");
// build http request to get the username avaliblity
$url ="https://accounts.snapchat.com/accounts/signup?client_id=scan";
$username = $_POST['search'];
$token = _getToken($url);
$ch = curl_init();
// also you can use proxy ,, if it personal useage you have to use proxy
// you ca
//curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_USERAGENT,"User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch,CURLOPT_HTTPHEADER, array("Cookie: xsrf_token=".$token.";","Content-Type: application/x-www-form-urlencoded; charset=utf-8"));
curl_setopt($ch,CURLOPT_POSTFIELDS,"requested_username=".$username."&xsrf_token=".$token."");
curl_setopt($ch,CURLOPT_URL,"https://accounts.snapchat.com/accounts/get_username_suggestions");
$done=curl_exec($ch);
echo $done;
if (!curl_errno($ch)) {
  switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
    case 200:  # OK
      break;
    default:
      echo 'Unexpected HTTP code: ', $http_code, "\n";
  }
}
//echo "requested_username=".$username."&xsrf_token=".$token."";
 ?>