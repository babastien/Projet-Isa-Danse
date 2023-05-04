<?php

$_SESSION = [];
session_destroy();
header('Location: ' . constructUrl('home'));
exit;