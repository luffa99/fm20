<?php
require ("x_session.php");
session_destroy();
header("Location: index.php");
?>