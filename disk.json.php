<?php
require_once 'server-monitor.php';
header('Content-Type: application/json');
echo json_encode(ServerMonitor::getDisk());
