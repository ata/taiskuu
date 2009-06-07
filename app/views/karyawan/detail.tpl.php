<h2>Detail Karyawan</h2>
<table class="form">
    <tbody>
        <tr>
            <th>NIK</th><th>:</th><td><?php echo $karyawan->nik?></td>
        </tr>
        <tr>
            <th>Nama Lengkap</th><th>:</th><td><?php echo $karyawan->nama_lengkap?></td>
        </tr>
        <tr>
            <th>Tempat Lahir</th><th>:</th><td><?php echo $karyawan->tempat_lahir?></td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th><th>:</th><td><?php echo $karyawan->tanggal_lahir?></td>
        </tr>
        <tr>
            <th>Golongan</th><th>:</th><td><?php echo $karyawan->golongan?></td>
        </tr>
        <tr>
            <th>Gaji Pokok</th><th>:</th><td><?php echo $karyawan->gaji_pokok?></td>
        </tr>
        <tr>
            <th>Tunjangan Jabatan</th><th>:</th><td><?php echo $karyawan->tunjangan_jabatan?></td>
        </tr>
        <tr>
            <th>Tunjangan keluarga</th><th>:</th><td><?php echo $karyawan->tunjangan_keluarga?></td>
        </tr>
        <tr>
            <th>Tunjangan Lain</th><th>:</th><td><?php echo $karyawan->tunjangan_keluarga?></td>
        </tr>
        <tr>
            <th>Transport Per hari</th><th>:</th><td><?php echo $karyawan->transport_per_hari?></td>
        </tr>
    <tbody>
    <tfoot>
        <tr>
            <td colspan="3"><a href="javascript:history.go(-1)" class="tombol"> &lt;&lt; back </a></td>
        </tr>
    </tfoot>
</table>