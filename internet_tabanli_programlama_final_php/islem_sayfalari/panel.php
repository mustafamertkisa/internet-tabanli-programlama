<?php
ob_start();
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

//-----------------Session ile oturum yönetimi için veri çekme işlemleri
$sessionID = $_SESSION['user'];
$sessionDatas = $database->select("385168_tbl_users", ["kullaniciAd","kullaniciSoyad","kullaniciFotograf"], ["id" => $sessionID]);

foreach($sessionDatas as $sessionData)
{
    $sessionAd = $sessionData["kullaniciAd"];
    $sessionSoyad = $sessionData["kullaniciSoyad"];
    $sessionFotograf = $sessionData["kullaniciFotograf"];
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

<div class="kullaniciBilgileri">
	<h3 id="personelAdH3">Personel: <i><?php echo "$sessionAd"." "."$sessionSoyad" ?></i></h3>
	<img src="<?php echo "$sessionFotograf" ?>" alt="personel_fotograf">
	<a href="cikisYap.php"><button id="cikisButton">Çıkış Yap</button></a>
</div>

<div class="musteriBilgileri">
	<h4>Müşteri Bilgileri</h4>
	<form action="" method="post">
		<label for="musteriAdSoyad">Ad-Soyad:</label><input type="text" name="musteriAdSoyad" id="" required><br><br>
		<label for="musteriMail">E-Posta:</label><input type="email" name="musteriMail" id="" required><br><br>
		<label for="musteriAdres">Adres:</label><input type="text" name="musteriAdres" id="" required><br><br>
		<input type="submit" value="Gönder" id="button"><br><br>
	</form>
</div>


<div class="siparisBilgileri">
	<h4>Sipariş Bilgileri</h4>
	<form action="" method="post">
		<label for="siparisTuru">Tür:</label><input type="text" name="siparisTuru" id="" required><br><br>
		<label for="siparisTutar">Tutar (<span>&#8378;</span>):</label><input type="number" name="siparisTutar" id="" required><br><br><br><br>
        <input type="submit" value="Gönder" id="button"><br><br>
	</form>
</div>


<div class="musteriSiparisEslestir">
	<h4>Müşteri & Sipariş Eşleştirme</h4>
	<form action="" method="post">
		<label for="musteriEslestir">Müşteri:</label>
			<select name="musteriEslestir" id="musteriEslestir">
				<?php
					$musteriler=$database->select("385168_tbl_customers","*");
					foreach($musteriler as $musteri){
						echo "<option value=".$musteri["musteriID"].">".$musteri["musteriAdSoyad"]."</option>";
					}?>
			</select><br><br>

			<label for="siparisEslestir">Sipariş:</label>
			<select name="siparisEslestir" id="siparisEslestir">
				<?php
					$siparisler=$database->select("385168_tbl_orders","*");
					foreach($siparisler as $siparis){
						echo "<option value=".$siparis["siparisID"].">".$siparis["siparisTuru"]." ".$siparis["siparisID"]."</option>";
					}?>
			</select><br><br><br>

        <input type="submit" value="Eşleştir" id="button"><br><br>
	</form>
</div>


<table class="redTable">
	<caption><b>Müşteri Bilgileri</b></caption>
	<thead>
	<tr>
	<th>Numara</th>
	<th>Ad-Soyad</th>
	<th>E-Posta</th>
	<th>Adres</th>
	<th> </th>
	</tr>
	</thead>
	<tbody>
	<?php 
		$kayitlar=$database->select("385168_tbl_customers","*");
		foreach ($kayitlar as $kayit) {
			echo "<tr>
			<td>".$kayit["musteriID"]."</td>
			<td>".$kayit["musteriAdSoyad"]."</td>
			<td>".$kayit["musteriMail"]."</td>
			<td>".$kayit["musteriAdres"]."</td>
			<td>
			<form action='' method='POST'>
				<input type='hidden' name='musteriSil' value=".$kayit["musteriID"].">
				<input type='submit' name='sil' value='Sil'>
			</form>
			</td>
			</tr>";
		};
	?>
	</tbody>
</table>

<table class="redTable2">
	<caption><b>Sipariş Bilgileri</b></caption>
	<thead>
	<tr>
	<th>Numara</th>
	<th>Türü</th>
	<th>Tutar</th>
	<th>Tarih</th>
	<th> </th>
	</tr>
	</thead>
	<tbody>
	<?php 
		$kayitlar=$database->select("385168_tbl_orders","*");
		foreach ($kayitlar as $kayit) {
			echo "<tr>
			<td>".$kayit["siparisID"]."</td>
			<td>".$kayit["siparisTuru"]."</td>
			<td>".$kayit["siparisTutar"]."</td>
			<td>".$kayit["siparisTarih"]."</td>
			<td>
			<form action='' method='POST'>
				<input type='hidden' name='siparisSil' value=".$kayit["siparisID"].">
				<input type='submit' name='sil' value='Sil'>
			</form>
			</td>
			</tr>";
		};
	?>
	</tbody>
</table>

<div class="musteriGuncelle">
	<h4>Müşteri Bilgilerini Güncelle</h4>
	<form action="" method="post">
		<label for="musteriNo">Güncellenecek Müşteri No</label><input type="number" name="musteriNo" id="" required><br><br>
		<label for="adSoyadGuncelle">Ad-Soyad:</label><input type="text" name="adSoyadGuncelle" id="" required><br><br>
		<label for="mailGuncelle">E-Posta:</label><input type="email" name="mailGuncelle" id="" required><br><br>
		<label for="adresGuncelle">Adres:</label><input type="text" name="adresGuncelle" id="" required><br><br>
		<input type="submit" value="Güncelle" id="button"><br><br>
	</form>
</div>

<div class="siparisGuncelle">
	<h4>Müşteri Bilgilerini Güncelle</h4>
	<form action="" method="post">
		<label for="siparisNo">Güncellenecek Sipariş No</label><input type="number" name="siparisNo" id="" required><br><br>
		<label for="turGuncelle">Tür:</label><input type="text" name="turGuncelle" id="" required><br><br>
		<label for="tutarGuncelle">Tutar:</label><input type="number" name="tutarGuncelle" id="" required><br><br>
		<input type="submit" value="Güncelle" id="button"><br><br>
	</form>
</div>

<!-- Master detail ekleme -->
<div class="masterdetail">
	<form action="" method="post">
		<label for="masterDetailMusteri">Müşteri Filtrele:</label>
			<select name="masterDetailMusteri" id="masterDetailMusteri">
				<?php
					$musteriler=$database->select("385168_tbl_customers","*");
					foreach($musteriler as $musteri){
						echo "<option value=".$musteri["musteriID"].">".$musteri["musteriAdSoyad"]."</option>";
					}?>
					<input type="submit" value="ARA" id="araButton">
			</select>
	</form>
</div>

	<table class="redTable3">
		<caption><b>Filtreleme Sonuçları</b></caption>
		<thead>
		<tr>
		<th>Sipariş No</th>
		<th>Sipariş Türü</th>
		<th>Sipariş Tutarı</th>
		<th>Sipariş Tarihi</th>
		</tr>
		</thead>
		<tbody>
		<?php
			if (isset($_POST["masterDetailMusteri"])) {
				$masterDetailMusteri = $_POST["masterDetailMusteri"];
				$kayitlar = $database->query("SELECT * FROM 385168_tbl_orders WHERE siparisID in(SELECT siparisID FROM 385168_tbl_eslestirme WHERE musteriID=$masterDetailMusteri)")->fetchAll();
				foreach ($kayitlar as $kayit) {
					echo "<tr>
					<td>".$kayit["siparisID"]."</td>
					<td>".$kayit["siparisTuru"]."</td>
					<td>".$kayit["siparisTutar"]."</td>
					<td>".$kayit["siparisTarih"]."</td>
					</tr>";
				};
			}
		?>
		</tbody>
	</table>


<!-- Sayfa yenilendiğinde bir önceki veriyi tekrardan eklemesini engellemek için -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>

<?php

//----------------------Veri tabanı işlemleri
if (isset($_POST["musteriAdSoyad"]) && isset($_POST["musteriMail"]) && isset($_POST["musteriAdres"])) {
	$musteriAdSoyad = $_POST["musteriAdSoyad"];
	$musteriMail = $_POST["musteriMail"];
	$musteriAdres= $_POST["musteriAdres"];
	//Girdileri ilk harfleri büyük olacak şekilde veri tabanına eklemek için
	$musteriAdSoyad = mb_convert_case($musteriAdSoyad, MB_CASE_TITLE, "UTF-8");

	$database->insert("385168_tbl_customers", ["musteriAdSoyad" => $musteriAdSoyad, "musteriMail" => $musteriMail, "musteriAdres" => $musteriAdres]);      
	header("Refresh: 0;");
}

if (isset($_POST["siparisTuru"]) && isset($_POST["siparisTutar"])) {
	$siparisTuru = $_POST["siparisTuru"];
	$siparisTutar = $_POST["siparisTutar"];

	//Girdileri ilk harfleri büyük olacak şekilde veri tabanına eklemek için
	$siparisTuru = mb_convert_case($siparisTuru, MB_CASE_TITLE, "UTF-8");

	$database->insert("385168_tbl_orders", ["siparisTuru" => $siparisTuru, "siparisTutar" => $siparisTutar]);      
	header("Refresh: 0;");
} 
    
if (isset($_POST["musteriEslestir"]) && isset($_POST["siparisEslestir"])) {
	$musteriID = $_POST["musteriEslestir"];
	$siparisID = $_POST["siparisEslestir"];

	$database->insert("385168_tbl_eslestirme", ["musteriID" => $musteriID, "siparisID" => $siparisID]);
	echo "<script>alert('Eşleştirme başarılı.');</script>";
	header("Refresh: 0;");
}

//Veri silme işlemleri
if (isset($_POST["musteriSil"])) {
	$musteriID = $_POST["musteriSil"];

	$database->delete("385168_tbl_customers", ["musteriID" => $musteriID]);
	echo "<script>alert('Müşteri kaydı silinmiştir.');</script>";
	header("Refresh: 0;");
}
if (isset($_POST["siparisSil"])) {
	$siparisID = $_POST["siparisSil"];

	$database->delete("385168_tbl_orders", ["siparisID" => $siparisID]);
	echo "<script>alert('Sipariş kaydı silinmiştir.');</script>";
	header("Refresh: 0;");
}

//Veri güncelleme işlemleri
if (isset($_POST["musteriNo"])) {
	$musteriID = $_POST["musteriNo"];

	if (isset($_POST["adSoyadGuncelle"]) || isset($_POST["mailGuncelle"]) || isset($_POST["adresGuncelle"])) {
		$adSoyadGuncelle = $_POST["adSoyadGuncelle"];
		$mailGuncelle = $_POST["mailGuncelle"];
		$adresGuncelle = $_POST["adresGuncelle"];
		//Girdileri ilk harfleri büyük olacak şekilde veri tabanına eklemek için
		$adSoyadGuncelle = mb_convert_case($adSoyadGuncelle, MB_CASE_TITLE, "UTF-8");
		
		$data = $database->update("385168_tbl_customers", ["musteriAdSoyad" => $adSoyadGuncelle,"musteriMail" => $mailGuncelle,"musteriAdres" => $adresGuncelle], ["musteriID" => $musteriID]);

		echo "<script>alert('Müşteri verileri güncellendi!');</script>";
		header("Refresh: 0;");
	}

}
if (isset($_POST["siparisNo"])) {
	$siparisID = $_POST["siparisNo"];

	if (isset($_POST["turGuncelle"]) || isset($_POST["tutarGuncelle"])) {
		$turGuncelle = $_POST["turGuncelle"];
		$tutarGuncelle = $_POST["tutarGuncelle"];
		//Girdileri ilk harfleri büyük olacak şekilde veri tabanına eklemek için
		$turGuncelle = mb_convert_case($turGuncelle, MB_CASE_TITLE, "UTF-8");

		$data = $database->update("385168_tbl_orders", ["siparisTuru" => $turGuncelle,"siparisTutar" => $tutarGuncelle,], ["siparisID" => $siparisID]);

		echo "<script>alert('Sipariş verileri güncellendi!');</script>";
		header("Refresh: 0;");
	}

}
ob_end_flush();
?>