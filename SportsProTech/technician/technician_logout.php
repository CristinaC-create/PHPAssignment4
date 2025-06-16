<?php
session_start();
session_unset();
session_destroy();
header('Location: technician_login.php');
exit();