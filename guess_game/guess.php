<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
$oldguess = isset($_POST["guess"]) ? $_POST["guess"] : '';
?>
    
<p>Guessing game...</p>
<form action="" method="post">
    <p><label for="guess">Input Guess: </label>
    <input type="text" name="guess" id="guess"
        size="40" value="<?= htmlentities($oldguess) ?>"/> </p>
<!-- htmlentities($oldguess) is used to prevent (HTML Injection) XSS attacks -->
    <input type="submit" >
</form>

<br>

<pre>$_POST: </pre>
<?php echo($oldguess); ?>
</body>
</html>