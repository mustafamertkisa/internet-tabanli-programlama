<?php
// If you installed via composer, just use this code to require autoloader on the top of your projects.
require "medoo.php";
 
// Using Medoo namespace
use Medoo\Medoo;
 
$database = new Medoo([
	// required
	"database_type" => "mysql",
	"database_name" => "itp_vt",
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
    <title>Reklam Atölyesi</title>
	<style>
		body{
			background-color: #eeb904;
			background-size: cover;
			background-image: url("https://images.unsplash.com/photo-1472289065668-ce650ac443d2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80");
			font-family: Arial, Helvetica, sans-serif;
		}

		.inputAlani{
			color: #8DE8F2;
			background-color: #1B62BF;
			width: 320px;
			padding: 40px;
			text-align: right;
			margin: auto;
			margin-top: 3%;
    		letter-spacing: 3px;
		}

		#button{
			background-color: #BF0B0B;
			color: white;
			width: 100px;
			height: 30px;
			margin-top: 5%;
			margin-right: 33%;
		}
		.redTable{
			margin-left: 29%;
			margin-right: 29%;
			background-color: rgb(248, 223, 111);
		}
		h5{
			font-size: 14px;
			margin-bottom: -30px;
			text-align: center;
			color: rgba(245, 245, 245, 0.377);
		}

		<!--tablo stil özellikleri-->
		table.redTable {
		border: 2px solid #A40808;
		background-color: #FFFFFF;
		width: 100%;
		text-align: center;
		border-collapse: collapse;
		}
		table.redTable td, table.redTable th {
		border: 1px solid #AAAAAA;
		padding: 3px 2px;
		}
		table.redTable tbody td {
		font-size: 13px;
		}
		table.redTable tr:nth-child(even) {
		background: #EFDCDC;
		}
		table.redTable thead {
		background: #BF0B0B;
		}
		table.redTable thead th {
		font-size: 19px;
		font-weight: bold;
		color: #FFFFFF;
		text-align: center;
		border-left: 2px solid #A40808;
		}
		table.redTable thead th:first-child {
		border-left: none;
		}

		table.redTable tfoot td {
		font-size: 13px;
		}
		table.redTable tfoot .links {
		text-align: right;
		}
		table.redTable tfoot .links a{
		display: inline-block;
		background: #FFFFFF;
		color: #A40808;
		padding: 2px 8px;
		border-radius: 5px;
		}
	</style>
</head>
<body>

<div class="inputAlani">

    <form action="" method="post">
		<label for="adSoyad">Ad-Soyad </label><input type="text" name="adSoyad" required><br>
		<label for="reklamTuru">Reklam Türü </label><input type="text" name="reklamTuru" required><br>
		<label for="siparisTutar">Sipariş Tutarı </label><input type="text" name="siparisTutar" required><br>
		<input type="submit" value="Kaydet" id="button"><br>
	</form>
	<h5>Mustafa Mert Kısa</h5>

</div>
<br>

<?php
$adSoyad = "";
$reklamTuru = "";
$siparisTutar = "";

if (isset($_POST["adSoyad"]) && isset($_POST["reklamTuru"]) && isset($_POST["siparisTutar"])) {

	$adSoyad = $_POST["adSoyad"];
	$reklamTuru = $_POST["reklamTuru"];
	$siparisTutar = $_POST["siparisTutar"];

	//Girdileri ilk harfleri büyük olacak şekilde veri tabanına eklemek için
	$adSoyad = mb_convert_case($adSoyad, MB_CASE_TITLE, "UTF-8");
	$reklamTuru = mb_convert_case($reklamTuru, MB_CASE_TITLE, "UTF-8");

	$database->insert("tbl_385168", ["musteriAdSoyad" => $adSoyad, "reklamTuru" => $reklamTuru, "siparisTutar" => $siparisTutar]);
	
	$kayitsay = 0;
	$kayitsay = $database->id();
	
	if ($kayitsay > 0) {
		echo "<script>alert('Tebrikler işleminiz başarıyla gerçekleşti.');</script>";
	}else {
		echo "<script>alert('Üzgünüz, bir terslik oldu! Lütfen tekrar deneyiniz.');</script>";
	}
}
?>

<!-- Sayfa yenilendiğinde bir önceki veriyi tekrardan eklemesini engellemek için -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<table class="redTable">
	<thead>
	<tr>
	<th>Sıra</th>
	<th>Müşteri Ad-Soyad</th>
	<th>Reklam Türü</th>
	<th>Sipariş Tutarı</th>
	<th>Sipariş Tarihi</th>
	</tr>
	</thead>
	<tbody>

<?php 
	$kayitlar = $database->select("tbl_385168","*");
	$sira = 1;
	foreach ($kayitlar as $kayit) {
		echo "<tr>
		<td>".$sira."</td>
		<td>".$kayit["musteriAdSoyad"]."</td>
		<td>".$kayit["reklamTuru"]."</td>
		<td>".$kayit["siparisTutar"]."</td>
		<td>".$kayit["siparisTarihi"]."</td>
		</tr>";
		$sira++;
	};
?>
	
	</tbody>
</table>

</body>
</html>