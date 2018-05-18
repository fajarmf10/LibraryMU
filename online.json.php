<?php
require_once 'useronline.php';
header('Content-Type: application/json');
echo json_encode(TestClass::getOnline());
