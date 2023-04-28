<?php
session_start();

$request = 0;

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

  return [$ip, $os, $browser, $device_name]
}


if(isset($_GET['reg'])) {
  if ($_GET['reg'] == "true") {
    if(!isset($_SESSION['reg_device'])) {
      $_SESSION['reg_device'] = generateRandomString();
      echo $_SESSION['reg_device'];
    }else {
      echo "Your device is registed";
    }
    $request = 1;
  }
}else {
  if(isset($_SESSION['reg_device'])) {
    echo $_SESSION['reg_device'];
  }else {
    header("location: reg_device.php?reg=new");
  }
}

if(isset($_GET['reg'])) {
  if ($_GET['reg'] == "new") {
    $_SESSION['reg_device'] = "";
    $_SESSION['reg_device'] = generateRandomString();
    echo $_SESSION['reg_device'];
    $request = 1;
  }
}else {
  echo $_SESSION['reg_device'];
}

if ($request == 0) {
  echo "Request are not existing. Error Code: 34927.";
}

// Überprüfen, ob eine ID angegeben wurde, um ein vorhandenes Gerät zu registrieren
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Überprüfen, ob die ID bereits in der Datenbank vorhanden ist
    $sql = "SELECT * FROM devices WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // ID bereits in der Datenbank vorhanden
        echo "Dieses Gerät wurde bereits registriert.";
    } else {
        // ID in der Datenbank speichern
        $sql = "INSERT INTO devices (id) VALUES ('$id')";
        if ($conn->query($sql) === TRUE) {
            echo "Das Gerät wurde erfolgreich registriert.";
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    // Neues Gerät anmelden
    $name = $_POST['name'];
    $model = $_POST['model'];
    $os = $_POST['os'];

    // Geräteinformationen in der Datenbank speichern
    $sql = "INSERT INTO devices (device_id, device_os, device_name, device_browser, device_ip) VALUES ('$os', '$model', '$os')";
    if ($conn->query($sql) === TRUE) {
        echo "Das Gerät wurde erfolgreich angemeldet.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Verbindung zur Datenbank schließen
$conn->close();

function generateRandomString($length = 2500) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!^$%&/(=?\}][{+~*#-_.:,;<>|}])';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
