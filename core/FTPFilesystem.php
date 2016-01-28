<?php 


class FTPFilesystem {
protected $ftp = array();


protected $conn_id;

// making this singleton 
private static $instance;
    
	

public static function getInstance()
{
	if (null === static::$instance) {
		static::$instance = new static();
	}
	
	return static::$instance;
}


// private because its singleton. is there a way to make in singleton and use new?
private function __construct (){
	// this might be bad practice but w/e the script is kind of static anyway
	$this->ftp['host'] = 'wdbook';
	$this->ftp['name'] = 'lan';
	$this->ftp['pass'] = 'lan';
	
	
	$this->conn_id = ftp_connect($this->ftp['host']);
	
	$login_result = ftp_login($this->conn_id, $this->ftp['name'], $this->ftp['pass']); 


	if ((!$this->conn_id) || (!$login_result)) { 
		echo "FTP connection has failed!";
		exit; 
	}


}
// return: folder names in a directory, basedirectory is /Filme
// param: direcotory to scan
public function getDirNames($dir ){
	$direcotryContent = array_map('basename', ftp_nlist($this->conn_id, './Filme/'.$dir));
	$direcotoryFolders = array_filter($direcotryContent, function($var){
		return (strpos($var, '.') === false);
	});
	return $direcotoryFolders;
}

// could make a file class to have some convenience when paths and stuff is needed
// return: file names in a directory
// param: direcoty to scan
public function getFileNames($dir) {
	
}


}