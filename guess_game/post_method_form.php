<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GET und POST Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h2 {
            color: #333;
        }
        p {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="url"],
        input[type="tel"],
        input[type="number"],
        input[type="date"],
        input[type="color"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        input[type="submit"], input[type="button"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #218838;
        }
        input[type="radio"], input[type="checkbox"] {
            margin-right: 10px;
        }
        .section-title {
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<form action="" method="POST">
    <p><label for="inp1">Account:</label>
    <input type="text" name="account" id="inp01" size="40"></p>

    <p><label for="inp2">Password:</label>
    <input type="password" name="pw" id="inp02" size="40"></p>

    <p><label for="inp3">Nick Name:</label>
    <input type="text" name="nick" id="inp03" size="40"></p>

    <p>Birthday: <input type="date" name="bday" value="2019-20-12"></p>

    <p>E-Mail: <input type="email" name="email"></p>

    <p>Add your homepage: <input type="url" name="homepage"></p>

    <p>Telephone: <input type="tel" name="phone"></p>

    <p>Quantity (between 1 and 5): <input type="number" name="quantity" min="1" max="5"></p>

    <p>Select Color: <input type="color" name="favcolor" value="#0000ff"></p>

    <p>Preffered Time: <br>
    <input type="radio" name="when" value="am">AM<br>
    <input type="radio" name="when" value="pm">PM</p>

    <p>Classes taken: <br>
    <input type="checkbox" name="class1" value="si502" checked> SI502 - Networked Tech <br>
    <input type="checkbox" name="class2" value="si539"> SI539 - App Engine <br>
    <input type="checkbox" name="class3" value="si43"> SI43 - Java <br> </p>

    <p><label for="inp6">Which soda:</label>
    <select name="soda" id="inp6">
        <option value="0">-- Please Select --</option>
        <option value="1">Coke</option>
        <option value="2">Lidl</option>
        <option value="3">Mountain Dew</option>
        <option value="4">Orange Juice</option>
        <option value="5">Lemonade</option>
    </select></p>

    <p><label for="inp7">Which snack:</label>
    <select name="snack" id="inp6">
        <option value="">-- Please Select --</option>
        <option value="chips">Chips</option>
        <option value="peanuts">Peanuts</option>
        <option value="cookie" selected>Cookie</option>
    </select></p>

    <p><label for="inp08">Tell us about yourself:</label><br>
    <textarea name="about" id="inp08" cols="40" rows="10">I love building web sites in PHP and MySQL</textarea></p>

    <p><label for="inp09">Which are awesome?</label><br>
    <select name="code[]" id="inp09" multiple="multiple">
        <option value="python">Python</option>
        <option value="css">CSS</option>
        <option value="html">HTML</option>
        <option value="php">PHP</option>
    </select></p>

    <p>
    <input type="submit" name="dopost" value="Submit">
    <input type="button" value="Escape" onclick="location.href='https://www.youtube.com/'; return false;">
    </p>
</form>

<pre>
$_POST;
</pre>

<?php
if (!empty($_POST)) {
    echo "<h2>Formulardaten empfangen:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "<h2>Keine Daten empfangen</h2>";
}
?>

</body>
</html>
