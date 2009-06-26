<h2>Periode</h2>
<a href="<?php echo Html::url('penggajian/periode_add') ?>"><h3>Open New Periode</h3></a>
<table class="data">
    <thead>
        <th>id</th>
        <th>start</th>
        <th>end</th>
        <th>status</th>
        <th>gaji</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php foreach($paginate->paginate() as $periode):?>
        <tr>
            <td align="center"><?php echo $periode->id?></td>
            <td align="center"><?php echo $periode->start?></td>
            <td align="center"><?php echo $periode->end?></td>
            <td align="center"><?php echo $periode->aktif?'Aktif':'Lewat' ?></td>
            <td align="center">
                <a href="<?php echo Html::url('penggajian/gaji',array('periode_id'=>$periode->id)) ?>">lihat gaji</a>
            </td>
            <td align="center">
                <a href="<?php echo Html::url('penggajian/periode_delete',array('id'=>$periode->id)) ?>">delete</a>
                <a href="<?php echo Html::url('penggajian/periode_edit',array('id'=>$periode->id)) ?>">edit</a>
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