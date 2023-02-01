<?php
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $absen = $_POST["absen"];
    $kelas = $_POST["kelas"];

    include "koneksi.php";
    if (    $foto = baseNama($_FILES["foto"]["Nama"])) {
        $temp = $_FILES['foto']['tmp_Nama'];
        $type = $_FILES['foto']['type'];
        $size = $_FILES['foto']['size'];
        $Nama = rand(0,9999).$_FILES['foto']['Nama'];
        $folder = "images/";
        $target_file = $folder . baseNama($_FILES["foto"]["Nama"]);

        if ($size < 2048000 and ($type =='image/jpeg' or $type == 'image/png'))
        {
            $query_foto = mysqli_query($konn, "SELECT * FROM siswa where id = '".$_POST['id']."'");
            $data_foto = mysqli_fetch_array($query_foto);
            unlink('images/'.$data_foto['foto']);

            move_uploaded_file($_FILES["foto"]["tmp_Nama"], $target_file);
            $input = mysqli_query($konn, "UPDATE siswa SET 
            nama='".$nama."', absen='".$absen."',
            kelas='".$kelas."', foto='".$foto."'
            where id='".$id."'");
 mysqli_error($konn);
             if ($input) {

                 echo "<script>alert('Sukses mengubah siswa');location.href='siswa.php';</script>";
             }
             else {
                 echo "<script>alert('Gagal mengubah siswa');location.href='siswa.php';</script>";
             }
        }
    }
    else{
        $input = mysqli_query($konn, "UPDATE `siswa` (`nama`, `absen`, `kelas`,) VALUES ('$nama', '$absen', '$kelas')");

         if ($input) {
             echo "<script>alert('Sukses mengubah siswa');location.href='siswa.php';</script>";
         }
         else {
             echo "<script>alert('Gagal mengubah siswa');location.href='siswa.php';</script>";
         }
    }

?>