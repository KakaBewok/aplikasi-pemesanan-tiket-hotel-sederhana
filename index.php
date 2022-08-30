<?php
    function durasi($cekIn, $cekOut){
        $date1 = date_create($cekIn);
        $date2 = date_create($cekOut);
        $diff = date_diff($date1, $date2);
        $durasi = $diff->format("%d%");

        return $durasi;
    }

    $harga = 500000;

    function tagihan($durasi, $harga){
        $tagihan = $durasi * $harga;

        return $tagihan;
    }

    $cabang = ["Bogor", "Bandung", "Bekasi","Jakarta", "Aceh", "Makasar", "Lampung"];
    sort($cabang);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APLIKASI HOTEL</title>
    <link rel="stylesheet" href="./bootstap/bootstrap.css"/>
</head>
<body>
    <div class="container">   
        <br/>
        <h3>DATA PEMESANAN TIKET HOTEL</h3>   
        <br/>
        <form action="index.php" method="post" style='border: 2px solid black; padding: 10px; border-radius: 7px'>
            <div class="row">
                <div class="col-lg-2"><label for="cekIn">Tanggal Check In   :</label></div>
                <div class="col-lg-2"><input type="date" id="cekIn" name="cekIn"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2"><label for="cekOut">Tanggal Check Out    :</label></div>
                <div class="col-lg-2"><input type="date" id="cekOut" name="cekOut"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2"><label for="cabang">Cabang Hotel    :</label></div>
                <div class="col-lg-2">
                    <select id="cabang" name="cabang">
                        <option value="">---Pilih Cabang---</option>

                        <?php
                            foreach($cabang as $cbg){
                                echo "<option value=$cbg>$cbg</option>";
                            }
                        ?>

                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2"><label for="nama">Nama Lengkap    :</label></div>
                <div class="col-lg-2"><input type="text" id="nama" name="nama"/></div>
            </div>
            <div class="row">
                <div class="col-lg-2"><label for="jk">Jenis Kelamin    :</label></div>
                <div class="col-lg-3"><input type="radio" id="jk" name="jk" value="Laki-laki"/>Laki-Laki</div>
                <div class="col-lg-3"><input type="radio" id="jk" name="jk" value="Perempuan"/>Perempuan</div>
            </div>
            <div class="row">
                <div class="col-lg-2"><label for="noid">No. ID (KTP)    :</label></div>
                <div class="col-lg-2"><input type="number" id="noid" name="noid"/></div>
            </div>
            </br>
            <div class="row">
                <div class="col-lg-6"><button style="border-radius: 5px" class="col-lg-4 btn-primary" id="submit" type="submit" name="submit">SUBMIT</button></div>
            </div>
        </form>

        <?php

        if(isset($_POST['submit'])){

            echo '<script type="text/JavaScript">';  
            echo 'alert("Data anda tersimpan")';  
            echo '</script>';

            $dataPesanan = array(
                "cekIn" => $_POST['cekIn'],
                "cekOut" => $_POST['cekOut'],
                "cabang" => $_POST['cabang'],
                "nama" => $_POST['nama'],
                "jk" => $_POST['jk'],
                "noid" => $_POST['noid'],
            );
            
            $db = "rizal.json";

            $dataJSON = json_encode($dataPesanan, JSON_PRETTY_PRINT);

            file_put_contents($db, $dataJSON);

            // ...

            $dataJSON = file_get_contents($db);

            $dataPesanan = json_decode($dataJSON, true);

            $durasiInap = durasi($dataPesanan['cekIn'], $dataPesanan['cekOut']);

            $tagihanAwal = tagihan($durasiInap, $harga);

            if($tagihanAwal >= 1500000){
                $diskon = $tagihanAwal * 0.1;
            } 
            else {
                $diskon = $tagihanAwal * 0.05;
            }

            $tagihanAkhir = $tagihanAwal - $diskon;

            echo "

            <br/>

            <br/>

            <div style='border: 2px solid black; padding: 10px; border-radius: 7px'>
                <div class='row'>
                    <div class='col-lg-2'><label>Tanggal Check In</label></div>
                    <div class='col-lg-2'><label>" .$dataPesanan['cekIn']. "</label></div>
                </div>
                <div class='row'>
                    <div class='col-lg-2'><label>Tanggal Check Out</label></div>
                    <div class='col-lg-2'><label>". $dataPesanan['cekOut'] . "</label></div>
                </div>
                <div class='row'>
                    <div class='col-lg-2'><label>Kota Cabang Hotel</label></div>
                    <div class='col-lg-2'><label>" . $dataPesanan['cabang'] . "</label></div>
                </div>
                <div class='row'>
                    <div class='col-lg-2'><label>Nama Pemesan</label></div>
                    <div class='col-lg-2'><label>" . $dataPesanan['nama'] . "</label></div>
                </div>
                <div class='row'>
                    <div class='col-lg-2'><label>Jenis Kelamin</label></div>
                    <div class='col-lg-2'><label>" . $dataPesanan['jk'] . "</label></div>
                </div>
                <div class='row'>
                    <div class='col-lg-2'><label>No. Id Pemesan</label></div>
                    <div class='col-lg-2'><label>" . $dataPesanan['noid'] . "</label></div>
                </div>
                <div class='row'>
                    <div class='col-lg-2'><label>Durasi Inap</label></div>
                    <div class='col-lg-2'><label>" . $durasiInap . " Hari</label></div>
                </div>
                 <div class='row'>
                    <div class='col-lg-2'><label>Tagihan Awal</label></div>
                    <div class='col-lg-2'><label> Rp. " . number_format($tagihanAwal, 0, ".",".") . ",-</label></div>
                </div>
                <div class='row'>
                    <div class='col-lg-2'><label>Diskon Sejumlah</label></div>
                    <div class='col-lg-2'><label> Rp. " . number_format($diskon, 0, ".",".") . ",-</label></div>
                </div>
                <div class='row'>
                    <div class='col-lg-2'><label>Tagihan Akhir</label></div>
                    <div class='col-lg-2'><label> <strong> Rp. " . number_format($tagihanAkhir, 0, ".",".") . ",- </strong></label></div>
                </div>
            </div>
            
            <br/>

            <br/>

            ";

        }
        ?>
    </div>
</body>
</html>