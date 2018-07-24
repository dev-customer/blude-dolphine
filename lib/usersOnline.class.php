<?php
class usersOnline {

	var $timeout = 15000;
	var $count = 0;
	var $error;
	var $i = 0;
	
	function usersOnline () {
		$this->timestamp = time();
		$this->ip = $this->ipCheck();
		$this->new_user();
		$this->delete_user();
		$this->count_users();
	}
	
	function ipCheck() {
	/*
	This function will try to find out if user is coming behind proxy server. Why is this important?
	If you have high traffic web site, it might happen that you receive lot of traffic
	from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
	This function tryes to get real IP address.
	Note that getenv() function doesn't work when PHP is running as ISAPI module
	*/
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP'); 
		} 
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		} 
		
		return $ip;
	}
	
	function new_user() {
		$insert = mysql_query ("INSERT INTO tbl_useronline(timestamp, ip) VALUES ('$this->timestamp', '$this->ip')");
		if (!$insert) {
			$this->error[$this->i] = "Unable to record new visitor\r\n";			
			$this->i ++;
		}

		if(isset($_SESSION['counter']) && !empty($_SESSION['counter']))
		{
			$insert = mysql_query ("INSERT INTO tbl_useronline(timestamp, ip) VALUES ('$this->timestamp', '$this->ip')");
			if (!$insert) {
				$this->error[$this->i] = "Unable to record new visitor\r\n";			
				$this->i ++;
			}
		}

	}
	
	function delete_user() {
		$delete = mysql_query ("DELETE FROM tbl_useronline WHERE timestamp < ($this->timestamp - $this->timeout)");
		if (!$delete) {
			$this->error[$this->i] = "Unable to delete visitors";
			$this->i ++;
		}
	}
	
	function count_users() {
		if (count($this->error) == 0) {
			$count = mysql_num_rows ( mysql_query("SELECT DISTINCT ip FROM tbl_useronline"));
			return $count;
		}
	}

}

?>