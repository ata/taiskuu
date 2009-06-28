<form action="<?php echo Core::url('buku/add')?>" method="post">
	Judul : <input type="text" name="judul"/><br/>
	Pengarang : <input type="text" name="pengarang"/><br/>
	<input type="submit" value="Simpan"> &nbsp;&nbsp;
	<a href="<?php echo Core::url('buku/index')?>">Cancel</a>
</form>