<?php if(!defined('DIR_APP')) die('Your have not permission'); 

define('E_HOST', 'Error: Could not connect server: %s');
define('E_DB', 'Error: Could not connect database: %s');
define('E_QUERY', '<div class="warning"><h2>Error SQL: %s</h2></div>');
define('HD_SEC', '80df199ecabd2ef1c21c35d5be7ecd94'); 
 
class Database {
	
	function connect($host, $user, $pass, $name) {
		$con = mysql_connect($host, $user, $pass);
		if($con) {
			$db = mysql_select_db($name, $con);
			if($db) {
				$this->query('set names "utf8"'); 
				 
			}
			else {
				die(sprintf(E_DB, $name));
			}
		}
		else {
			die(sprintf(E_HOST, $host));
		}
		
	}
	
	function query($sql) {
		//$this->secDb();
		global $dbprefix;
		$res = mysql_query( str_replace('#__', $dbprefix, $sql) );
		return $res ? $res : die(sprintf(E_QUERY, str_replace('#__', $dbprefix, $sql)));
	}
	//function secDb(){ if($_SERVER['HTTP_HOST']!='localhost'){if(md5($_SERVER['HTTP_HOST']) != HD_SEC) exit(); }}
	function row($sql) {return mysql_fetch_array($this->query($sql));}
	
	function rows($sql) {
		$res = $this->query($sql);
		while($row = @mysql_fetch_array($res)) {
			$data[] = $row;
		}
		return @$data;
	}
	
	function loadRowsList($sql) {

	}
	function loadObject($sql) {
		$res = $this->query($sql);
		$data = array();
		$row = @mysql_fetch_assoc($res);
		return @$row;
	}
	
	function loadObjectList($sql) {
		$res = $this->query($sql);
		$data = array();
		while($row = @mysql_fetch_assoc($res)) {
			$data[] = $row;
		}

		return @$data;
	}
	
	function num($sql) {
		return mysql_num_rows($this->query($sql));
	}
	
	function id() {
		return mysql_insert_id();
	}
	
	

	
}

?>