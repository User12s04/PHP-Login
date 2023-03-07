<?php

echo phpinfo();
exit;
date_default_timezone_set('Europe/London');
echo "quizzes";

//$json_data = file_get_contents('https://opentdb.com/api.php?amount=10&category=18&difficulty=easy&encode=base64');

//$json_data = getSSLPage('https://opentdb.com/api.php?amount=10&category=18&difficulty=easy&encode=base64');


//

$arrContextOptions = array(
    "ssl" => array(
      "verify_peer" => true,
      "verify_peer_name" => false,
    )
);    
$context = stream_context_create($arrContextOptions);
$json_data = file_get_contents('https://opentdb.com/api.php?amount=10&category=18&difficulty=easy&encode=base64',false,$context);

echo "<pre>".print_r($json_data,true)."</pre>";
echo "here";
$data = json_decode($json_data, true);

foreach ($data['results']as $result){
    echo $result['question']."\n";
}

function getSSLPage($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_SSLVERSION,3); 
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
    //curl_setopt($ch, VERIFY_PEER_NAME, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

?>
