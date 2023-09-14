<?php
session_start();

session_destroy();

header("location: ../index.html");
exit(); // Add this line to prevent further code execution