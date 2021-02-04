<?php
// If you installed via composer, just use this code to require autoloader on the top of your projects.
require "islem_sayfalari/medoo.php";
 
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
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Mustafa Mert Kısa</title>
</head>
<body>
<div class="inputAlani">
    <form action="islem_sayfalari/islem.php" method="post" enctype="multipart/form-data">
        <label for="kullaniciAd">Adınız:</label><input type="text" name="kullaniciAd" required><br>
        <label for="kullaniciSoyad">Soyadınız:</label><input type="text" name="kullaniciSoyad" required><br>
        <label for="kullaniciMail">E-Posta Adresiniz:</label><input type="email" name="kullaniciMail" id="" required><br>
        <label for="kullaniciParola">Parolanız:</label><input type="password" name="kullaniciParola" id="" required><br><br>
        <label for="fileToUpload">Fotoğraf Yükleyiniz (max 10 mb) &nbsp;</label><br><br><input type="file" name="fileToUpload" id="fileToUpload" required><br>
        <input type="submit" value="Kaydol" id="button"><br><br>
        <a href="islem_sayfalari/giris.php" style="font-size: small; color: aliceblue; text-decoration: none; margin-right: 36%;">Giriş Yap</a>
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