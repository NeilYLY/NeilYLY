<?php
$commands = array(
    'up' => 'postup.xml',
    'down' => 'postdown.xml',
    'left' => 'postleft.xml',
    'right' => 'postright.xml',
    'stop' => 'poststop.xml'
);

if (isset($_POST['command']) && array_key_exists($_POST['command'], $commands)) {
    $command = $_POST['command'];
    $xmlFile = $commands[$command];
    $url = 'http://120.114.140.215:8899/onvif/ptz';
    
    $myvars = join('', file($xmlFile));
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    // Optionally you can log the response or handle errors here
    echo $response;
} else {
    echo "Invalid command";
}
?>
