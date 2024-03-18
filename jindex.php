<?php
$file = 'vid.mkv';
header('Content-Type: application/octet-stream');
header('Content-Disposition:attachment; filename="'.basename($file).'"');
readfile($file);
?>