#!/usr/local/bin/php
<?php
	session_name('project'); // resume hw5 session
    session_start();
    session_unset(); //clear section
    header('Location: index.php'); //directly refer back to index.php

?>


