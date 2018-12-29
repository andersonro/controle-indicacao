<?php
spl_autoload_register(function($class_name){
	$dir = 'class';
	$filename = $dir.DIRECTORY_SEPARATOR.$class_name.'.php';
	if (file_exists($filename)) {
		require_once($filename);
	}
});
?>