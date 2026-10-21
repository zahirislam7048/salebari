<?php
require __DIR__ . '/../app/bootstrap.php';
unset($_SESSION['seller_id']);
redirect('account/login.php');
