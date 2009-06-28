<a href="<?php echo Core::url('buku/new_buku')?>">New Buku</a>
<table border="1" cellspacing="0">
	<thead>
		<tr>
			<th>ID</th>
			<th>Judul</th>
			<th>Pengarang</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($bukuList as $buku):?>
		<tr>
			<td><?php echo $buku['id']?></td>
			<td><?php echo $buku['judul']?></td>
			<td><?php echo $buku['pengarang']?></td>
			<th>
				<a href="<?php echo Core::url('buku/edit/'. $buku['id'])?>" ?>edit</a>
				<a href="<?php echo Core::url('buku/delete/'.$buku['id'])?>" onclick="if(confirm('Anda Yakin akan menghapus buku dengan judul <?php echo $buku['judul'] ?>?')){return true;} else{return false;};"?>delete</a>
			</th>
		</tr>
		<?php endforeach?>
	</tbody>
</table>
