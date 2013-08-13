<?php
	
    include "qrlib.php";    
    
	if(isset($_REQUEST['data']))
		QRcode::png($_REQUEST['data'], FALSE, 'L', 2, 0);