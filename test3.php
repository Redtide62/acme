<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
    <title>Database Entries</title>
    </head>
    <body>
        <h2><a href="index.php">Return to the Home page</a></h2>
        <br>
        <h2><a href="contact.php">Return to the Contact page</a></h2>
    </body>
</html>
<?php
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Name</th><th>Email</th><th>OS</th><th>Browser</th><th>Referer</th><th>Message</th><th>TimeStamp</th></tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:350px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}

$servername = "localhost";
$username = "id5373938_contact_user";
$password = "19Imagine88";
$dbname = "id5373938_contact";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT Name, Email, OS, Browser, Referrer, Message, Time_Stamp FROM Client_Info");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>