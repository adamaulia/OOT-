<?php 
	header("Content-disposition: attachment; filename=panduan.pdf");
	header("Content-type: application/pdf");
	readfile("panduan.pdf");
?>

