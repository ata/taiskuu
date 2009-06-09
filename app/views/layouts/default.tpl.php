<html>
    <head>
        <title>Payrol System</title>
        <link rel="stylesheet" type="text/css" href="<?php echo Html::media('css/main.css')?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo Html::media('css/datepicker.css')?>"/>
        <script type="text/javascript" src="<?php echo Html::media('js/prototype.js')?>"></script>
        <script type="text/javascript" src="<?php echo Html::media('js/main.js')?>"></script>
        <script type="text/javascript" src="<?php echo Html::media('js/datepicker.js')?>"></script>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Pay Roll System</h1>
            </div>
            <ul class="top-menu">
                <li><a href="<?php echo Html::url('karyawan')?>">Karyawan</a></li>
                <li><a href="<?php echo Html::url('penggajian')?>">Penggajian</a></li>
            </ul>
            <div class="body">
                <div class="sidebar">
                    <h3><?php echo $this->controller?> menu</h3>
                    <ul>
                       <?php foreach($this->menu as $m):?>
                       <li><a href="<?php echo Html::url($m['url']) ?>"><?php echo $m['label'] ?></a></li>
                       <?php endforeach?>
                    </ul>
                </div>
                <div class="content">
                    <?php echo $this->getContent()?>
                </div>  
            </div>
            
            <div class="footer">
                &copy;Ahmad Tanwir<br/>
                powered by <b>Ostric Taiskuu 0.1 </b>
            </div>
        </div>
        
    </body>
</html>