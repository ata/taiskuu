<h2>Detail Gaji</h2>
<table class="form">
    <tbody>
        <tr>
            <th>NIK</th><th>:</th><td><?php echo $gaji->karyawan->nik?></td>
        </tr>
        <tr>
            <th>Nama Lengkap</th><th>:</th><td><?php echo $gaji->karyawan->nama_lengkap?></td>
        </tr>
    <tbody>
    <tfoot>
        <tr>
            <td colspan="3"><a href="javascript:history.go(-1)" class="tombol"> &lt;&lt; back </a></td>
        </tr>
    </tfoot>
</table>