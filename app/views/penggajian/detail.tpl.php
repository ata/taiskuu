<h2>Detail Gaji</h2>
<table class="form">
    <tbody>
        <tr>
            <th>NIK</th>
            <th>:</th>
            <td><?php echo $gaji->karyawan->nik?></td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <th>:</th>
            <td><?php echo $gaji->karyawan->nama_lengkap?></td>
        </tr>
        <tr>
            <th>Jumlah Kehadiran</th>
            <th>:</th>
            <td><?php echo $gaji->jumlah_kehadiran?></td>
        </tr>
        <tr>
            <th>Jumlah Sakit</th>
            <th>:</th>
            <td><?php echo $gaji->jumlah_sakit?></td>
        </tr>
        <tr>
            <th>Jumlah Izin</th>
            <th>:</th>
            <td><?php echo $gaji->jumlah_izin?></td>
        </tr>
        <tr>
            <th>Jumlah Jam Lembur biasa</th>
            <th>:</th>
            <td><?php echo $gaji->jumlah_jam_lembur_biasa?></td>
        </tr>
        <tr>
            <th>Jumlah Jam Lembur Libur</th>
            <th>:</th>
            <td><?php echo $gaji->jumlah_jam_lembur_libur?></td>
        </tr>
        <tr>
            <th>Jumlah Jam Lembur Minggu</th>
            <th>:</th>
            <td><?php echo $gaji->jumlah_jam_lembur_minggu?></td>
        </tr>
        <tr>
            <th>Gaji Pokok</th>
            <th>:</th>
            <td><?php echo $gaji->gaji_pokok?></td>
        </tr>
        <tr>
            <th>Tunjangan Jabatan</th>
            <th>:</th>
            <td><?php echo $gaji->tunjangan_jabatan?></td>
        </tr>
        <tr>
            <th>Tunjangan Keluarga</th>
            <th>:</th>
            <td><?php echo $gaji->tunjangan_keluarga?></td>
        </tr>
        <tr>
            <th>Tunjangan Lain</th>
            <th>:</th>
            <td><?php echo $gaji->tunjangan_lain?></td>
        </tr>
        <tr>
            <th>Uang Lembur</th>
            <th>:</th>
            <td><?php echo $gaji->uang_lembur?></td>
        </tr>
        <tr>
            <th>Uang Makan</th>
            <th>:</th>
            <td><?php echo $gaji->uang_makan?></td>
        </tr>
        <tr>
            <th>Uang Transport</th>
            <th>:</th>
            <td><?php echo $gaji->uang_transport?></td>
        </tr>
        <tr>
            <th>Bonus</th>
            <th>:</th>
            <td><?php echo $gaji->bonus?></td>
        </tr>
        <tr>
            <th>Potongan</th>
            <th>:</th>
            <td><?php echo $gaji->potongan?></td>
        </tr>
        <tr>
            <th>Total Gaji</th>
            <th>:</th>
            <td><?php echo $gaji->total_gaji?></td>
        </tr>
    <tbody>
    <tfoot>
        <tr>
            <td colspan="3"><a href="javascript:history.go(-1)" class="tombol"> &lt;&lt; back </a></td>
        </tr>
    </tfoot>
</table>