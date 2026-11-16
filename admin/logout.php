<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$_SESSION = [];
session_destroy();
session_start();

set_flash('success', 'Anda berhasil logout.');
redirect('login.php');
