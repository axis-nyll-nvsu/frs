<?php
/*
 * Logout
 * Description: Logout
 * Author: Vernyll Jan P. Asis
 */

session_start();
header('location: ./');
session_destroy();