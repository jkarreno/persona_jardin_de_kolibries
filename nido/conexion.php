<?php

$conn=mysqli_connect ("localhost", "pjardinko_personas",
"Kolibri2024#") or die('Cannot connect to the database because: ' . mysqli_error());
mysqli_select_db ($conn, "pjardinko_personas");

mysqli_set_charset($conn, "utf8");

//@jkarreno 2024 - 2025
?>