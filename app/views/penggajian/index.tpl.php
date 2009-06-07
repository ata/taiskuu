<h2>Penggajian Periode <?php echo $periode->periode ?></h2>
<form action="<?php echo Html::url('penggajian') ?>">
    <input type="hidden" value="<?php echo $_GET['c']?>" name="c"/>
    Periode:
    <select name="periode" onchange="this.form.submit()">
        <?php foreach($listPeriode as $p):?>
            <option <?php echo $periode->id == $p->id ? "selected":"" ?> value="<?php echo $p->id?>"><?php echo $p->periode?></option>
        <?php endforeach?>
    </select>
</form>
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
        <?php foreach($periode->listGaji as $gaji):?>
        <tr>
            <td align="center"><?php echo $gaji->id ?></td>
            <td>
                <a href="<?php echo Html::url('karyawan/detail',array('id'=>$gaji->karyawan->id))?>">
                    <?php echo $gaji->karyawan->nik ?>
                </a>
            </td>
            <td>
                <a href="<?php echo Html::url('karyawan/detail',array('id'=>$gaji->karyawan->id))?>">
                    <?php echo $gaji->karyawan->nama_lengkap ?>
                </a>
            </td>
            <td align="right"><?php echo $gaji->total_gaji ?></td>
            <td align="center">
                <a href="<?php echo Html::url('penggajian/detail',array('id'=>$gaji->id))?>">
                    detail
                </a>
                <a href="<?php echo Html::url('penggajian/delete',array('id'=>$gaji->id,'periode'=>$periode->id))?>">
                    delete
                </a>
            </td>
        </tr>
        <?php endforeach?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">
                <a href="<?php echo Html::url('penggajian/add',array('periode'=>$periode->id))?>">
                    Add Gaji
                </a>
            </td>
        </tr>
    </tfoot>
</table>
