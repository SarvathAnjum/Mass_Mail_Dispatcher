<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Send Personalized Email By Uploading CSV</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
<link rel="stylesheet" type="text/css" href="bootstrap.css"/>
<script src="js/jquery.js"></script>
</head>
<body>
<?php
// Include PHPMailerAutoload.php library file
include("php/lib/PHPMailerAutoload.php");

$email_sub = "";
$msg = "";
$user_list = array();
$status = array();
$file_path = "";

// Retrieving & storing user's submitted information
if (isset($_POST['user_list'])) {
$user_list = json_decode($_POST['user_list']);
}
if (isset($_POST['email_sub'])) {
$email_sub = $_POST['email_sub'];
}
if (isset($_POST['box_msg'])) {
$msg = $_POST['box_msg'];
}
if (isset($_POST['uploaded_file_path'])) {
$file_path = $_POST['uploaded_file_path'];
}

// Sending personalized email
foreach ($user_list as $list) {
$receiver_name = "";
$receiver_add = "";
$per_msg = "";
$per_email_sub = "";
//$receiver_name = $list[0];
$receiver_add = $list[0];

// Replacing {user} with client name from subject and message
$per_msg = str_replace("{user}", $receiver_add, $msg);
$per_email_sub = str_replace("{user}", $receiver_add, $email_sub);

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
//$mail->SMTPDebug = 3;

// Enable SMTP authentication
$mail->SMTPAuth = true;

// SMTP username
$mail->Username = 'sarvathanjum04@gmail.com';

// SMTP password
$mail->Password = 'Badu@0412';

// Enable encryption, 'tls' also accepted
$mail->SMTPSecure = 'tls';

// Sender Email address
$mail->From = 'sarvathanjum04@gmail.com';

// Sender name
$mail->FromName = "Sarvath Anjum";

// Receiver Email address
$mail->addAddress($receiver_add);

$mail->Subject = $per_email_sub;
$mail->Body = $per_msg;
$mail->WordWrap = 50;

// Sending message and storing status
if (!$mail->send()) {
$status[$receiver_add] = False;
} else {
$status[$receiver_add] = TRUE;
}
}
?>
<div id="main" class="col-sm-12 col-md-6 col-lg-6">
<h1>Message Status</h1>
<div id="status">
<ul>
<?php
foreach ($status as $user => $sent_status) {
if ($sent_status == True) {
$img = "php/img/errorFree.png";
} else {
$img = "php/img/error.png";
}
echo "<li> <img src='$img'/>" . $user;
}
// Deleting iuploaded CSV file from the uploads folder
//unlink($file_path);
?>
</ul>
<a href="index.php" id="more">Send More Emails...</a>
<a href="https://onlinegdb.com/kbc_9aFrn">Check for valid and invalid email addresses....</a>
</div>
</div>
</body>
</html>