<html>
    <head>
        <title><?php echo $this->getTitle() ?></title>
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
                <li><a href="#">Karyawan</a></li>
                <li><a href="#">Gaji</a></li>
                <li><a href="#">Jam Lembur</a></li>
                <li><a href="#">Periode</a></li>
                <li><a href="#">Presensi</a></li>
            </ul>
            <div class="body">
                <div class="content">
                    <?php echo $this->getContent()?>
                </div>
                
            </div>
            
            <div class="footer">
                &copy;Ahmad Tanwir<br/>
                with Ostric Taiskuu 0.1 
            </div>
        </div>
        
    </body>
</html>