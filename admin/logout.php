<?php
/*
 * logout.php
 * Description: Logout Processor
 * Author: 
 * Modified: 11-23-2024
 */

session_start();
header('location: ./');
session_destroy();