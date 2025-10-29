<?php
require_once 'functions.php';

handleContactForm();

// This should not be reached if redirect happens
header('Location: index.php');
exit;
?>
