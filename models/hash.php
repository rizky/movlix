<?php
	function admin_pass($password)
	{
		return hash('whirlpool', 'm0vl1x'.$password);
	}

	function user_pass($password)
	{
		return hash('sha256', hash('snefru', '^&fsd+&' . $password) . 'gfd765-+');
	}

	function get_valid_key($username)
	{
		return hash("ripemd128", "m0vl1x".$username);
	}
?>