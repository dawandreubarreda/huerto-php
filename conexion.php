<?php
 $conn = new mysqli("localhost", "root", "", "huerta_db");
 if ($conn->connect_error)
 die("Error: " . $conn->connect_error);
?>