<?php
// Betriebssysteminformationen abrufen
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if (strpos($user_agent, 'Windows') !== false) {
    $os = 'Windows';
} elseif (strpos($user_agent, 'Mac') !== false) {
    $os = 'Macintosh';
} elseif (strpos($user_agent, 'Linux') !== false) {
    $os = 'Linux';
} else {
    $os = $_SERVER['HTTP_USER_AGENT'];
}

$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];

if (isset($_SERVER['HTTP_REFERER'])) {
  echo "Referer: " . $_SERVER['HTTP_REFERER'] . "<br>";
}
echo "Betriebssystem: " . $os . "<br>";
echo "IP-Adresse: " . $ip . "<br>";
echo "Browser: " . $browser . "<br>";

if (strpos($user_agent, 'MSIE') !== false) {
    $browser = 'Internet Explorer';
} elseif (strpos($user_agent, 'Firefox') !== false) {
    $browser = 'Mozilla Firefox';
} elseif (strpos($user_agent, 'Chrome') !== false) {
    $browser = 'Google Chrome';
} elseif (strpos($user_agent, 'Safari') !== false) {
    $browser = 'Apple Safari';
} elseif (strpos($user_agent, 'Opera Mini') !== false) {
    $browser = "Opera Mini";
} elseif (strpos($user_agent, 'Opera') !== false) {
    $browser = 'Opera';
} else {
    $browser = $_SERVER['HTTP_USER_AGENT'];
}

echo "Ihr Browser ist: " . $browser. "<br>";

$ip_name = $_SERVER['REMOTE_ADDR'];
$device_name = gethostbyaddr($ip_name);

echo "Device Name: ". $device_name;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Molingo and Milo - UniCore & Smart Education</title>
  </head>
  <body>

  </body>
</html>
