<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onur Özdemir MD5</title>
</head>
<body>
<h1>MD5 cracker</h1>
<p>This application takes an MD5 hash of a four digit pin and check all 10,000 possible four digit PINs to determine the PIN.</p>
<pre>Debug Output:
<?php
$goodtext = "Not found";
//Deger yoksa bu calisir
if ( isset($_GET["md5"]) ) {
    $time_pre = microtime(true);
    $md5 = $_GET["md5"];

    $txt = "abcdefghijklmnopqrstuvwxyz";
    $show = 15;

    //Ilk konumdaki degerden baslayarak döngüye girer.

    for($i=0; $i<strlen($txt); $i++ ) {
        $ch1 = $txt[$i];   // 2 karakterden ilki"

        //Ikinci döngü
        for($j=0; $j<strlen($txt); $j++ ) {
            $ch2 = $txt[$j]; // 2. karakter

            //iki karakteri birlestirir
            $try = $ch1.$ch2;

            //hash yapar ve kontrol eder
            $check = hash("md5", $try);
            if ( $check == $md5 ) {
                 $goodtext = $try;
                 break 2;  // cikis yapar
            }

            // Debug cikisi $show = 0 olana kadar devam eder
            if ( $show > 0) {
                print "$check $try\n";
                $show = $show - 1;
            }   
        }
    }

    //Gecen süreyi hesaplar
    $time_post = microtime(true);
    print "Elapset time: ";
    print $time_post - $time_pre;
    print "\n";
}
?>

</pre>

<!-- html entities() cagirir -->
<p>Original Text: <?= htmlentities($goodtext); ?></p>

<form action="" method="GET">
    <input type="text" name="md5" size="40">
    <input type="submit" value="Crack MD5" >
</form>
<ul>
    <li><a href="index.php">Reset this page</a></li>
    <li><a href="md5.php">Make an MD5 PIN</a></li>
    <li><a href="makecode.php">MD5 Encoder</a></li>
    <li><a 
    href="https://github.com/csev/php-intro/tree/master/code/crack" 
    target="_blank">Source code similar to this application</a></li></a></li>
</ul>
</body>
</html>