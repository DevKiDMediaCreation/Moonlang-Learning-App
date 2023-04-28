<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unicore";

$conn = null;
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "";

function device_information()
{
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
  $ip_name = $_SERVER['REMOTE_ADDR'];
  $device_name = gethostbyaddr($ip_name);

  return [$ip, $os, $browser, $device_name];
}

if(!isset($_SESSION['reg_device'])) {
  $_SESSION['reg_device'] = generateRandomID();
  $ip = device_information()[0];
  $os = device_information()[1];
  $browser = device_information()[2];
  $device_name = device_information()[3];

  reg_in_db($conn, $ip, $os, $browser, $device_name);
}else {
  reg_in_db($conn, "", "", "", "");
}

// Überprüfen, ob eine ID angegeben wurde, um ein vorhandenes Gerät zu registrieren
function reg_in_db($conn, $ip, $os, $browser, $device_name)
{

  // Überprüfen, ob die ID bereits in der Datenbank vorhanden ist
  if(isset($_SESSION['ID'])) {
    $id = $_SESSION['ID'];
    $sql = "SELECT * FROM devices WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // ID bereits in der Datenbank vorhanden
        echo "You device is registred. You device log in.";
        exit;
    } else {
        echo "Error. The Authentification of this device is failed. The system can not resolved this devices. Please contact the support or delete all cookies to reset the device in the system. Thank you. If the system function the system registered this device automatically.";
        session_destroy();
        exit;
    }
  }

  if (isset($_SESSION['reg_device'])) {

    $id = $_SESSION['reg_device'];
    $sql = "SELECT * FROM devices WHERE id='$id'";
    $result = $conn->query($sql);

    do {
      $_SESSION['reg_device'] = generateRandomID();
    } while ($result->num_rows > 0);

    $id = $_SESSION['reg_device'];
    $sql = "INSERT INTO devices (device_id, device_os, device_name, device_browser, device_ip) VALUES ('$id', '$os', '$device_name', '$browser', '$ip')";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
      $_SESSION['ID'] = $last_id;
      echo "New record created successfully. Last inserted ID is: " . $last_id . "<br>";
      echo "The device is successfully registred.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    $_SESSION['reg_device'] = generateRandomID();
  }


  // Verbindung zur Datenbank schließen
  $conn->close();
}

function generateRandomID($length = 2500) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!^$%&/(=?}][{+~*-_.:,;<>|}])';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
