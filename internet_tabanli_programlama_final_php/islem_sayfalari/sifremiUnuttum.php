<?php
    error_reporting(0);
    require "medoo.php";
    
    // Using Medoo namespace
    use Medoo\Medoo;
    
    $database = new Medoo([
        // required
        "database_type" => "mysql",
        "database_name" => "php_final",
        "server" => "localhost",
        "username" => "root",
        "password" => "",
    
        // [optional]
        "charset" => "utf8mb4",
        "collation" => "utf8mb4_general_ci",
        "port" => 3306,
    ]);


    //----------------------------Mail işlemleri için gereken kütüphanelerin ve eklentilerin çağrılması
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require '../vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    if (isset($_POST["kullaniciMail"])) {
        $kullaniciMail = $_POST["kullaniciMail"];
        $parola = $database->get("385168_tbl_users", "kullaniciParola", ["kullaniciMail" => $kullaniciMail]);
        }

    try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP(); // Send using SMTP
    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'mstfmrt.ybs@gmail.com'; // SMTP username
    $mail->Password = 'ktuybs1955'; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('mstfmrt.ybs@gmail.com', 'Mustafa Mert Kisa');
    $mail->addAddress($kullaniciMail, "Yeni Kullanıcı"); // Add a recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Sifre Hatirlatma Talebiniz Hakkinda';
    $mail->Body = 'Merhaba, talepte bulundugunuz hesabinizin sifresi: '.$parola.'';
    $mail->AltBody = 'MUSTAFA MERT KISA - 385168';
    $mail->send();
    header("Location:giris.php");

    } catch (Exception $e) {
   
    }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <title>Mustafa Mert Kısa</title>
</head>
<body>
<div class="inputAlani">
    <form action="" method="post">
        <label for="kullaniciMail">E-Posta Adresiniz:</label><input type="email" name="kullaniciMail" id="" required><br><br>
        <input type="submit" value="Gönder" id="button"><br><br><br>
        <a href="giris.php" style="font-size: small; color: aliceblue; text-decoration: none; margin-right: 36%;">Giriş Yap</a>
    </form>
</div>

<!-- Sayfa yenilendiğinde bir önceki veriyi tekrardan eklemesini engellemek için -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>  
</body>
</html>
