<?php
ob_start();
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



//---------------------Fotoğraf yükleme işleminin ön ayarları
//koşullar: daha önce yüklenmemiş olmalı, boyut max 10mb olmalı, dosya resim dosyası olmalı ve uzantı jpg, png ve gif olabilir

$hedef_klasor="../yuklenen_fotograflar/";
$hedef_dosya=$hedef_klasor.basename($_FILES["fileToUpload"]["name"]);
$yuklemeyeUygunluk = 1;
$durum="";

//uygunluk kontrol dosya var mı
//if(file_exists($hedef_dosya)){
    //$yuklemeyeUygunluk=0;
    //$durum.="Aynı dosya Var.";
//}

//uygunluk kontrol boyut max 10mb mı
if($_FILES["fileToUpload"]["size"]>1000000){
    $yuklemeyeUygunluk=0;
    $durum.="Dosya boyutu 10MB üstünde.";
}

//uygunluk kontrol dosya resim mi
$resimKontrol=mime_content_type($_FILES["fileToUpload"]["tmp_name"]);

if (strpos($resimKontrol, "image")!=false){
    $yuklemeyeUygunluk=0;
    $durum.="Resim dosyası değil.";
}

//dosya uzantı uygunluk
$resimDosyaTur = strtolower(pathinfo($hedef_dosya,PATHINFO_EXTENSION));
if($resimDosyaTur!="jpg" && $resimDosyaTur!="jpeg" && $resimDosyaTur!="png" && $resimDosyaTur!="gif"){
    $yuklemeyeUygunluk=0;
    $durum.="png, jpg, jpeg ve gif uzantılı olmalı.";
}



//----------------------Veri tabanı işlemleri
if (isset($_POST["kullaniciAd"]) && isset($_POST["kullaniciSoyad"]) && isset($_POST["kullaniciMail"]) && isset($_POST["kullaniciParola"])) {

	$kullaniciAd = $_POST["kullaniciAd"];
	$kullaniciSoyad = $_POST["kullaniciSoyad"];
    $kullaniciMail = $_POST["kullaniciMail"];
    $kullaniciParola = $_POST["kullaniciParola"];

	//Girdileri ilk harfleri büyük olacak şekilde veri tabanına eklemek için
	$kullaniciAd = mb_convert_case($kullaniciAd, MB_CASE_TITLE, "UTF-8");
	$kullaniciSoyad = mb_convert_case($kullaniciSoyad, MB_CASE_TITLE, "UTF-8");
}

if($yuklemeyeUygunluk==1){
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $hedef_dosya)) {

        //KOD ÜRETME
        $kodUretici1 = date("d.m.Y H:i:s");
        $kodUretici2 = rand(0,2000);
        $kodAktivasyon = hash("sha256", $kodUretici1.$kodUretici2);

        $database->insert("385168_tbl_users", ["kullaniciAd" => $kullaniciAd, "kullaniciSoyad" => $kullaniciSoyad, "kullaniciMail" => $kullaniciMail, "kullaniciParola" => $kullaniciParola, "kullaniciFotograf" => $hedef_dosya, "kullaniciAktivasyon" => $kodAktivasyon]);
        

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'mstfmrt.ybs@gmail.com';                     // SMTP username
            $mail->Password   = 'ktuybs1955';                               // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('mstfmrt.ybs@gmail.com', 'Mustafa Mert Kisa');
            $mail->addAddress($kullaniciMail, "Yeni Kullanıcı");     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Internet Tabanli Programlama Final Projesi';
            $mail->Body    = 'Merhaba, sistemimize kayit oldugunuz icin tesekkurler! <br> Hesabinizi aktif hale getirmek icin lutfen asagidaki butona <a href="localhost/385168/islem_sayfalari/islemAktivasyon.php?kullaniciMail='.$kullaniciMail.'&kodAktivasyon='.$kodAktivasyon.'">tiklayiniz</a>.';
            $mail->AltBody = 'MUSTAFA MERT KISA - 385168';
            $mail->send();
            header("Location:giris.php");
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
      } else {
        echo "Hata!";
      }

}else{
    echo "Kriterler sağlanmadı!";
    echo $durum;
}
ob_end_flush();
?>