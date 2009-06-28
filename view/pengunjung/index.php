<form action="<?php echo Core::url('pengunjung/add')?>" method="post">
	Nama : <input type="text" name="nama"/><br/>
	Email: <input type="text" name="email"/><br/>
	Situs: <input type="text" name="situs"/><br/>
	<input type="submit" value="submit"/><br/>
</form>
	
</form>

<table border="1" cellspacing="0">
    <thead>
		<tr>
			<th>Nama</th>
			<th>Email</th>
			<th>Pengunjung</th>
			<th>Action</th>
		</tr>
    </thead>
    <tbody>
    	<?php foreach($listPengunjung as $pengunjung):?>
    	<tr>
    		<td><?php echo $pengunjung['nama']?></td>
    		<td><?php echo $pengunjung['email']?></td>
    		<td><?php echo $pengunjung['situs']?></td>
    		<td>
    			<a href="<?php echo Core::url('pengunjung/delete/'.$pengunjung['id'])?>" onclick="if(confirm('Anda Yakin?')){return true;} else{return false;};"?>delete</a>
    		</td>
    	</tr>
    	<?php endforeach?>
    </tbody>
</table>
