<?php
# access.molingo.unicore.universityinstitute.workspace.dev.uni.com
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unicore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
