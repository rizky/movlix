<?php
	function encrypt($password)
	{
		return hash('whirlpool', 'm0vl1x'.$password);
	}

	function get_valid_key($username)
	{
		return hash("ripemd128", "m0vl1x".$username);
	}
?>