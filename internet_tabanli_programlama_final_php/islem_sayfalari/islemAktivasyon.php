<?php
ob_start();// If you installed via composer, just use this code to require autoloader on the top of your projects.
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

    if (isset($_GET["kullaniciMail"]) && isset($_GET["kodAktivasyon"])) {
        $kullaniciMail = $_GET["kullaniciMail"];
        $kodAktivasyon = $_GET["kodAktivasyon"];
        $user = $database->get("385168_tbl_users", "id", ["AND" => ["kullaniciMail" => $kullaniciMail, "kullaniciAktivasyon" => $kodAktivasyon]]);
        
        if ($user>0) {
            $data = $database->update("385168_tbl_users", ["kullaniciAktifMi" => 1], ["id" => $user]);
            header("Location:giris.php");
        }
        else {
            echo "HATA";
            header("Location:index.php");
        }
    }
ob_end_flush();
 ?>