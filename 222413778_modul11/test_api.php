<?php

include 'api_bps.php';

$result = getBpsData('pressrelease');

echo "<pre>";
print_r($result);
echo "</pre>";
?>