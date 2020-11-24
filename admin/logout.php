<?php

include('../config.php');

session_destroy();

header('Location: ' . SITE_URL . 'admin/login.php');

?>