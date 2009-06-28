<form action="<?php echo Core::url('buku/update')?>" method="post">
	<input type="hidden" value="<?php echo $buku['id']?>" name="id"/>
	Judul : <input type="text" name="judul" value="<?php echo $buku['judul']?>"/><br/>
	Pengarang : <input type="text" name="pengarang" value="<?php echo $buku['pengarang']?>"/><br/>
	<input type="submit" value="Simpan">&nbsp;&nbsp;
	<a href="<?php echo Core::url('buku/index')?>">Cancel</a>
</form>