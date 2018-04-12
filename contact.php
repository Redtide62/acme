<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <script>
        function validateEmail(email)
        {   //email regex
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        function validateForm() {
            var x = document.forms["myForm"]["name"].value;
            var y = document.forms["myForm"]["email"].value;
            var z = document.forms["myForm"]["msg"].value;
            if (x == "") {
                alert("Name must be filled out");
                return false;
            }
            if (y == ""){
                alert("Email must be filled out")
            }
            else if(validateEmail(y)==false){
                alert("Email address must be of the form example@example.example")
            }
            if (z == ""){
                alert("Comments need to be filled out")
                return false;
            }
        }
    </script>
</head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body bgcolor="#f0f8ff">
<?php
// define variables and set to empty values
$nameErr = $emailErr = $msgErr =  "";
$name = $femail = $msg = "";
$err = "not";
//checks input against empty string
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "* Name is required";
    $err = "* required field";
  } else {
     $err="";
    $name = test_input($_POST["name"]);
  }

  if (empty($_POST["email"])) {
    $emailErr = "* Email is required";
    $err = "* required field";
  }else {
    $femail = test_input($_POST["email"]);
  }
  

  if (empty($_POST["msg"])) {
    $msgErr = "* Must provide content for email";
    $err = "* required field";
  } else {
    $msg = test_input($_POST["msg"]);
  }
}
//cleans data before inserting
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if($err == "" && filter_var($femail, FILTER_VALIDATE_EMAIL)){
$servername = "localhost";
$username = "id5373938_contact_user";
$password = "19Imagine88";
$dbname = "id5373938_contact";
$fname =  $name;
$email =  $femail;
$ref =  $_SERVER['HTTP_REFERER'];
$message =  $msg;


$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}


$user_os        = getOS();
$user_browser   = getBrowser();


//inserts information above into database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO Client_Info (Name, Email, OS, Browser, Referrer, Message)
    VALUES ('$fname', '$email', '$user_os', '$user_browser', '$ref', '$message')";
  
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("$email","My subject",$msg);
mail("greg.mcgilvray@gmail.com", "some_oneused_this",$msg." From: ".$email);
    
$conn = null;
}
?>
<div class="w3-container w3-brown" style="padding: 45px">
    <h1 align="center" style="color: green;">Contact Us</h1>
    <h3 align="center" style="color: orange;">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="test3.php">See DB Entry</a>
    </h3>
</div>
<div class="w3-container w3-teal">
    <h2>Send us an email! We would love to here from you!</h2>
</div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="w3-container" name="myForm" onsubmit="validateForm()">
    <label class="w3-text-teal"><b>Name</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="name" style="width: 300px;">
    <span class="error"> <?php echo $nameErr;?></span>
    <br>

    <label class="w3-text-teal"><b>Email</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="email" style="width: 300px;">
    <span class="error"> <?php echo $emailErr;?></span>
    <br>

    <label class="w3-text-teal"><b>Comments</b></label>
    <input class="w3-input w3-border w3-light-grey" type="text" name="msg">
    <span class="error"> <?php echo $msgErr;?></span>
    <br>

    <button class="w3-btn w3-blue-grey">Send</button>
</form>

</body>
</html>
