<?php
$md5 = "Not computed";

if (isset($_GET["encode"]) ) {
    $md5 = hash("md5", $_GET["encode"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onur Özdemir MD5</title>
</head>
<body>
<h1>MD5 Maker</h1>
<p>MD5: <?= htmlentities($md5); ?></p>

<form action="" method = "GET">
    <input type="text" name="encode" size="40" />
    <input type="submit" value="Compute MD5" />
</form>

<p><a href="md5.php">Reset</a></p>
<p><a href="index.php">Back to Cracking</a></p>
</body>
</html>