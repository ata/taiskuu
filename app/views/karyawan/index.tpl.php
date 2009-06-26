<h2>List Karyawan</h2>
<a href="<?php echo Html::url('karyawan/add')?>"><h3>Add Karyawan</h3></a>
<table class="data">
    <thead>
        <tr>
            <th>Id</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Golongan</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($paginate->paginate() as $karyawan):?>
        <tr>
            <td align="center"><?php echo $karyawan->id?></td>
            <td><?php echo $karyawan->nik?></td>
            <td><?php echo $karyawan->nama_lengkap?></td>
            <td align="center"><?php echo $karyawan->golongan?></td>
            <td align="center"><?php echo $karyawan->aktif?'Aktif':'Non Aktif'?></td>
            <td align="center">
                <a href="<?php echo Html::url('karyawan/detail',array('id' => $karyawan->id))?>">detail</a>
                <a href="<?php echo Html::url('karyawan/edit',array('id' => $karyawan->id))?>">edit</a>
                <a href="<?php echo Html::url('karyawan/delete',array('id' => $karyawan->id))?>">delete</a>
            </td>    
        </tr>
        <?php endforeach?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6"><?php echo $paginate->navigation() ?></td>
        </tr>
    </tfoot>
</table>