<?php
session_start();
// If you installed via composer, just use this code to require autoloader on the top of your projects.
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
        <label for="kullaniciParola">Parolanız:</label><input type="password" name="kullaniciParola" id="" required><br>
        <input type="submit" value="Giriş Yap" id="button"><br><br>
        <a href="sifremiUnuttum.php" style="font-size: small; color: aliceblue; text-decoration: none; margin-right: 28%;">Şifremi Unuttum</a><br><br>
        <a href="../index.php" style="font-size: small; color: aliceblue; text-decoration: none; margin-right: 30%;">Hesap Oluştur</a>
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
<?php
if (isset($_POST["kullaniciMail"]) && isset($_POST["kullaniciParola"])) {
    $kullaniciMail = $_POST["kullaniciMail"];
    $kullaniciParola = $_POST["kullaniciParola"];
    $user = $database->get("385168_tbl_users", "id", ["AND" => ["kullaniciMail" => $kullaniciMail, "kullaniciParola" => $kullaniciParola, "kullaniciAktifMi" => 1]]);
        
    if ($user>0) {
        $_SESSION['user'] = $user;
        header("Location:panel.php");
    }
    else {
        echo "<script>alert('Üzgünüz, bir terslik oldu! Lütfen bilgilerinizi ve aktivasyon durumunuzu kontrol ediniz.');</script>";
        
    }
}
?>