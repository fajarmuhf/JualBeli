<?php
	//memanggil library
	include("../../../../jpgraph/src/jpgraph.php");
	include("../../../../jpgraph/src/jpgraph_bar.php");
	
	//membuat data mahasiswa IT
	//membuat data untuk ditampilkan pada sumbu X
	include "../include/koneksi.php";
	
	
	$koneksi = new Hubungi();
	$koneksi->Konek("bolu_pisang");
	
	$tglawal = $_GET['tglbefore'];
	$tglakhir = $_GET['tglafter'];
	
	$query = "SELECT * FROM Penjualan WHERE Tanggal >= '$tglawal' AND Tanggal <= '$tglakhir' ORDER BY Tanggal ";
	$exquery = mysqli_query($koneksi->getKonek(),$query);
	
	$sumbux = array();
	$sumbuy = array();
	$sumbuy2 = array();
	
	
	$i=0;
	if($exquery){
		while($hasil = mysqli_fetch_array($exquery)){
			$sumbux[$i] = $hasil['Tanggal'];
			$sumbuy[$i] = $hasil['Jumlah'];
			$sumbuy2[$i] = $hasil['Id_Barang'];
			$i++;
		}
	//Slice Color
	$colorslice = array('#1E90FF','#2E8B57','#ADFF2F','#BA55D3');
	
	
	//Menentukan Area Grapfik dengan membuat Object dari Class Graph
	$tampil = new Graph(500,450,"auto");
	//Menentukan Jenis Grafik yang akan ditampilkan,library harus didefinisikan dahulu di include
	$tampil->SetScale("textint",0,0,0,0);
	
	//Membuat Judul dari Grafik
	$tampil->title->Set('Data Data Penjualan');
	
	//Menampilkan grid untuk sumbu X
	$tampil->xgrid->Show();
	//Menampilkan jenis garisnya dot atau solid atau yang lain
	$tampil->xgrid->SetLineStyle("solid");
	//Menampilkan data dari sumbu X
	$tampil->xaxis->SetTickLabels($sumbux);
	//Mengeset Warna
	$tampil->xgrid->SetColor('white');
	
	//Mengeplot Grafik
	$garis = new BarPlot($sumbuy);
	//Menambahkan plot ke dalam grafik dengan cara menambahkan object garis ke dalam object tampil
	//Mengeset warna untuk sumbu y
	$garis->SetColor("red");
	//Mengeset Slice Color 
	//$garis->SetSliceColors($colorslice);
	//Membuat Legend untuk garis
	$garis->SetLegend('Jumlah');
	
	//Mengeplot Grafik
	$garis2 = new BarPlot($sumbuy2);
	//Menambahkan plot ke dalam grafik dengan cara menambahkan object garis ke dalam object tampil
	//Mengeset warna untuk sumbu y
	$garis2->SetColor("blue");
	//Mengeset Slice Color 
	//$garis->SetSliceColors($colorslice);
	//Membuat Legend untuk garis
	$garis2->SetLegend('Id_Barang');
	
	$tampil->Add($garis);
	$tampil->Add($garis2);
	
	
	//Menampilkan grafik
	$tampil->Stroke();
	$fileName = "bargraph.png";
    $tampil->img->Stream($fileName);
	
	}
	
	mysqli_close($koneksi->getKonek());
	
?>
