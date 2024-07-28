<!-- panggil file header -->
<?php include "header.php"; ?>

<?php

// uji jika tombol simpan diklik
if(isset($_POST['bsimpan'])){
    $tgl = date('Y-m-d');
    // htmlspecialchars agar inputan lebih amat dari injectio
    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES);
    $asal = htmlspecialchars($_POST['asal'], ENT_QUOTES);
    $tujuan = htmlspecialchars($_POST['tujuan'], ENT_QUOTES);
    $nohp = htmlspecialchars($_POST['nohp'], ENT_QUOTES);

    // persiapan query simpan data
    $simpan = mysqli_query($koneksi, "INSERT INTO ttamu VALUES ('', '$tgl', '$nama', '$asal', '$tujuan', '$nohp')");

    //uji jika simpan data sukses
    if ($simpan) {
        echo "<script>alert('Simpan Data SUKSES');
            document.location='?'</script>";
    }else {
        echo "<sript>alert('Simpan Data GAGAL!');
            document.location='?'</script>";
    }

}
?>
        <!-- Head -->
        <div class="head text-center">
            <h2 class="text-white">Sistem Buku Tamu <br> SD Al-Ikhsan Ambon</h2>
        </div>
        <!-- end head -->

        <!-- Awal row -->

        <div class="row mt-2">

            <!-- col-lg-7 -->
            <div class="col-lg-7 mb-3">
                <div class="card shadow bg-gradient-light">

                    <!-- card body -->
                    <div class="card-body">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Identitas Tamu!</h1>
                            </div>
                            <form class="user" method="POST" action="" >
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="nama" placeholder="Nama Tamu" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="asal" placeholder="Asal Tamu" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="tujuan" placeholder="Tujuan Tamu" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="nohp" placeholder="Nomor HP Tamu" required>
                                </div>

                                <button type="submit" name="bsimpan" class="btn btn-primary btn-user btn-block" >Simpan Data</button>
                               
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="#">by. xxeyjpg -  <?= date('Y') ?> </a>
                            </div>                        
                    </div>
                    <!-- end card body -->
                </div>
            </div>
            <!-- end col-lg-7 -->

                <!-- col-lg-5 -->
                <div class="col-lg-5 mb-3">
                    <!-- card -->
                    <div class="card shadow">

                        <!-- card body -->
                        <div class="card-body">
                            <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Statistik Pengunjung</h1>
                        </div>
                        <?php
                            // deklarasi tanggal

                            //menampilkan tanggal sekarang
                            $tgl_sekarang = date('Y-m-d');

                            // menampilkan tanggal kemarin
                            $kemarin = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));

                            // mendapatkan 6 hari sebelum tgl skrg
                            $seminggu = date('Y-m-d h:i:s', strtotime('-1 week +1 day', strtotime($tgl_sekarang)));

                            $sekarang = date('Y-m-d h:i:s');

                            // persiapan query tampilkan jumlah data pengunjung

                            $tgl_sekarang = mysqli_fetch_array(mysqli_query(
                                $koneksi, 
                                "SELECT count(*) FROM ttamu where tanggal like '%$tgl_sekarang%'"
                            ));

                            $kemarin = mysqli_fetch_array(mysqli_query(
                                $koneksi, 
                                "SELECT count(*) FROM ttamu where tanggal like '%$kemarin%'"
                            ));

                            $seminggu = mysqli_fetch_array(mysqli_query(
                                $koneksi, 
                                "SELECT count(*) FROM ttamu where tanggal BETWEEN  '$seminggu' and '$sekarang'"
                            ));
                            
                            $bulan_ini = date('m');

                            $sebulan = mysqli_fetch_array(mysqli_query(
                                $koneksi, 
                                "SELECT count(*) FROM ttamu where month(tanggal) = '$bulan_ini'"
                            ));

                            $keseluruhan = mysqli_fetch_array(mysqli_query(
                                $koneksi, 
                                "SELECT count(*) FROM ttamu"
                            ));


                            
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td>Hari ini</td>
                                <td>: <?= $tgl_sekarang[0] ?></td>
                            </tr>
                            <tr>
                                <td>Kemarin</td>
                                <td>: <?= $kemarin[0] ?></td>
                            </tr>
                            <tr>
                                <td> Minggu ini</td>
                                <td>: <?= $seminggu[0] ?></td>
                            </tr>
                            <tr>
                                <td> Bulan ini</td>
                                <td>: <?= $sebulan[0] ?></td>
                            </tr>
                            <tr>
                                <td>Keseluruhan</td>
                                <td>: <?= $keseluruhan[0] ?></td>
                            </tr>
                        </table>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col-lg-5 -->

        </div>
        <!-- end row -->

            <!-- card body-->
            <div class="card-body">
                <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Tamu Hari Ini [<?=date('d-m-Y') ?>] </h6>
                        </div>
                        <div class="card-body">
                            <a href="rekapitulasi.php" class="btn btn-success mb-3" ><i class="fa fa-table"></i> Rekapitulasi Tamu</a>
                            <a href="logout.php" class="btn btn-danger mb-3" ><i class="fa fa-sign-out-alt"></i> Log Out</a>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Tanggal</th>
                                            <th>Nama Tamu</th>
                                            <th>Asal Tamu</th>
                                            <th>Tujuan</th>
                                            <th>No. HP</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php
                                        $tgl = date('Y-m-d'); //2024-07-26
                                            $tampil = mysqli_query($koneksi,"SELECT * FROM ttamu where tanggal like '$tgl'order by id desc");
                                            $no = 1;
                                            while($data = mysqli_fetch_array($tampil)) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['tanggal'] ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['asal'] ?></td>
                                            <td><?= $data['tujuan'] ?></td>
                                            <td><?= $data['nohp'] ?></td>
                                        </tr>
                                        <?php } ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

<!-- panggil file footer -->
<?php include "footer.php"; ?>