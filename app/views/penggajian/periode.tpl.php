<h2>Periode</h2>
<table class="data">
    <thead>
        <th>id</th>
        <th>From</th>
        <th>To</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php foreach($listPeriode as $periode):?>
        <tr>
            <td align="center"><?php echo $periode->id?></td>
            <td align="center"><?php echo $periode->from?></td>
            <td align="center"><?php echo $periode->to?></td>
            <td align="center">
                <a href="<?php echo Html::url('penggajian/periode_delete',array('id'=>$periode->id)) ?>">delete</a>
                <a href="<?php echo Html::url('penggajian/periode_edit',array('id'=>$periode->id)) ?>">edit</a>
            </td>
        </tr>
        <?php endforeach?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"><a href="<?php echo Html::url('penggajian/periode_add') ?>">Add</a></td>
        </tr>
    </tfoot>
</table>