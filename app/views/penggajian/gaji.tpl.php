<h2>Penggajian Periode <?php echo $periode->start .' - '.$periode->start ?></h2>
<table class="data">
    <thead>
        <tr>
            <th>id</th>
            <th>NIK</th>
            <th>Nama Karyawan</th>
            <th>Total Gaji</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($paginate->paginate() as $gaji):?>
        <tr>
            <td align="center"><?php echo $gaji->id ?></td>
            <td>
                <a href="<?php echo Html::url('karyawan/detail',array('id'=>$gaji->karyawan->id))?>">
                    <?php echo $gaji->nik ?>
                </a>
            </td>
            <td>
                <a href="<?php echo Html::url('karyawan/detail',array('id'=>$gaji->karyawan->id))?>">
                    <?php echo $gaji->nama_lengkap ?>
                </a>
            </td>
            <td align="center">
                <?php if($gaji->total_gaji==0): ?>
                    <a href="<?php echo Html::url('penggajian/proses',array('id'=>$gaji->id))?>">Proses</a>
                <?php else:?>
                    <?php echo $gaji->total_gaji ?>
                <?php endif?>
            </td>
            <td align="center">
                <a href="<?php echo Html::url('penggajian/detail',array('id'=>$gaji->id))?>">
                    detail
                </a>
                <a href="<?php echo Html::url('penggajian/proses',array('id'=>$gaji->id))?>">edit</a>
                <a href="<?php echo Html::url('penggajian/delete',array('id'=>$gaji->id,'periode'=>$periode->id))?>">
                    delete
                </a>
            </td>
        </tr>
        <?php endforeach?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5"><?php echo $paginate->navigation() ?></td>
        </tr>
    </tfoot>
</table>
