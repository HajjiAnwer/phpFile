<?php
$title = 'Internet Joke Database';
ob_start();
include  __DIR__ . '/includeFile/home.html.php';
$output = ob_get_clean();
include  __DIR__ . '/includeFile/layout.html.php';