<h1> Tabel Member</h1>
<form action="index.php?page=member" method="post">
  <div class="input-append">
    <input class="span3" id="appendedInputButton" type="text" name="cari" placeholder="Type something">
    <button class="btn" type="subit" name='btnCari'>Go!</button>
    </div>
</form>

<a href='index.php?page=member'>Vie all data</a>


<table  width="600px" border=0>
  <tr style="background-color:#F79307">
    <td width="100px">Kode User</td>
    <td width="250px">Username</td>
    <td width="90px">Operation</td>
  </tr>

<?php
/*
 * Kode untuk menghapus data
 */
if (isset($_GET['del'])) {
    $kdMember = $_GET['id'];
    $hapus = "DELETE FROM wbpl_member WHERE Kd_member='$kdMember'";
    $mysqli->query($hapus) or die(mysql_error());
}

$batas = 5;
if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
}

$posisi = null;
if (empty($halaman)) {
    $posisi = 0;
    $halaman = 1;
} else {
    $posisi = ($halaman - 1) * $batas;
}

$sql = null;

if (isset($_POST['btnCari'])) {
    $cari = $_POST['cari'];
    //ambil data dari table admin
    $sql = "SELECT * FROM  wbpl_member where username like '%$cari%'";
} else {
    $sql = "SELECT * FROM  wbpl_member
      ORDER BY kd_member ASC
      limit $posisi,$batas";
}

$result = $mysqli->query($sql);

// Proses menampilkan data
while ($rows = mysqli_fetch_array($result)) {
    ?>
  <tr>
    <td><a href="index.php?page=profile&id=<?php echo $rows['kd_member']?>"><?php echo $rows['kd_member']; ?></a></td>
    <td><a href="index.php?page=profile&id=<?php echo $rows['kd_member']?>"><?php echo $rows['username']; ?></a></td>

    <td>
      <a class="btn" href="index.php?page=profile&id=<?php echo $rows['kd_member']?>">
        <i class="icon-edit" title="Edit"></i>
      </a>
      <a class="btn btn-danger" href="index.php?page=member&del=true&id=<?php echo $rows['kd_member']?>"  onclick="return askUser()";>
        <i class="icon-remove" title="Remove"></i>
      </a>
    </td>
  </tr>
  <?php
}
  ?>

  <tr>
    <td></td>
    <td align=right colspan='1'><?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 0) {
            echo " <div style='color:blue'>Operasi data berhasil</div>";
        } else {
            echo 'operasi gagal';
        }
    }
    ?>
    </td>
  </tr>
  <tr></tr>
</table>

<?php

  //=============CUT HERE====================================
  $tampil2 = $mysqli->query('SELECT * FROM wbpl_member');
  $jmldata = mysqli_num_rows($tampil2);
  $jumlahHalaman = ceil($jmldata / $batas);
?>

  Jumlah data :<?php echo $jmldata; ?>

  <div class="pagination">
    <ul>
    <?php
    for ($i = 1; $i <= $jumlahHalaman; $i++) {
        if ($i != $halaman) {
            echo "<li><a href=index.php?page=member&halaman=$i> $i </a></li>";
        } else {
            echo '<li class='.'active'.'><a href='."> $i </a></li>";
        }
    }
    ?>
    </ul>
  </div>
