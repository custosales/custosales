<?php
echo("Installation script");


// Check if GD is installed - needed for making thumbnails of user photos.
$testGD = get_extension_funcs("gd"); // Grab function list 

// Print message if GD is not installed
if (!$testGD){ echo "GD not installed."; exit; }
echo"<pre>".print_r($testGD,true)."</pre>";


?>


