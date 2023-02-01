<?php
if($_POST) {
    $nama=$_POST['nama'];
    $absen=$_POST['absen'];
    $kelas=$_POST['kelas'];
    $foto = basename($_FILES["foto"]["name"]);
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(empty($nama)){
        echo "<script>alert('nama tidak boleh kosong');location.href='tambah_siswa.php';</script>";
    } elseif(empty($absen)){
        echo "<script>alert('absen tidak boleh kosong');location.href='tambah_siswa.php';</script>";
    } elseif(empty($kelas)){
        echo "<script>alert('kelas tidak boleh kosong');location.href='tambah_siswa.php';</script>"; 
    } elseif(empty($foto)){
        echo "<script>alert('foto tidak boleh kosong');location.href='tambah_siswa.php';</script>"; 
    } else {
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if($check == false) {
            echo "<script>alert('File yang dipilih bukan foto.');location.href='tambah_siswa.php';</script>";
            $uploadOk = 0;
        } else {
            $uploadOk = 1;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "<script>alert('File foto sudah ada.');location.href='tambah_siswa.php';</script>";
        $uploadOk = 0;
        }

        

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "<script>alert('Hanya menerima file foto JPG, JPEG, PNG & GIF');location.href='tambah_siswa.php';</script>";
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>alert('File foto tidak terupload');location.href='tambah_siswa.php';</script>";  
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                
                include "koneksi.php";
                
                $sql = "INSERT INTO `siswa` (`nama`, `absen`, `kelas`, `foto`) VALUES ('$nama', '$absen', '$kelas', '$foto')";
                
                $insert=mysqli_query($konn, $sql);

                if($insert) {
          
                     echo "<script>alert('Sukses menambahkan siswa');location.href='siswa.php';</script>";
                 } else {
                    echo "<script>alert('Gagal menambahkan siswa');location.href='siswa.php';</script>";
                }
            } else {
                echo "<script>alert('Error saat upload file foto');location.href='siswa.php';</script>";
            }
        }

    }

}
?>