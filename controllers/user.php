<?php
	session_start();
	require_once('../models/user.php');
	require_once('../models/hash.php');

	$functions = array('login', 'register', 'update', 'validmail', 'unregister');

	function register(array $datas)
	{
		$err = NULL;

		if ($datas['username'] == "")
			$err[] = 'Username is empty';
		if ($datas['email'] == "")
			$err[] = 'Email is empty';
		if ($datas['password'] == "")
			$err[] = 'Password is empty';
		if ($datas['password'] !== $datas['password2'])
			$err[] = 'Password does not match';	
		if ($datas['firstname'] == "")
			$err[] = 'First name is empty';
		if ($datas['lastname'] == "")
			$err[] = 'Last name is empty';
		if ($err === NULL)
		{
			if (people_exist($datas['username']) === NULL)
			{
				$key = get_valid_key($datas['username']);
				return (people_create($datas['username'], $datas['email'],  $datas['password'], $datas['firstname'], $datas['lastname'], $key, 0));
			}
			else
				return (array('Username exists'));
		}
		else
			return $err;
	}

	function unregister(array $datas)
	{
		$err = NULL;
		if (!$datas['username'])
			$err[] = 'username';
		if ($err === NULL)
		{
			if (people_delete($datas['username']) === TRUE)
				return NULL;
			else
				return (array('Account could not be found'));
		}
		else
			return ($err);
	}

	function update(array $datas)
	{
		if ($_SESSION['admin']) {
			if (people_exist($datas['username']))
				return (people_update2($datas['username'], $datas['firstname'], $datas['lastname'], $datas['password'], $datas['address']));
			else
				return (array('Account does not exist'));
		} else {
			if (people_exist($_SESSION['username']))
				return (people_update2($_SESSION['username'], $datas['firstname'], $datas['lastname'], $datas['password'], $datas['address']));
			else
				return (array('Account does not exist'));
		}
	}

	function login_bycookie(array $datas)
	{
		$err = NULL;

		if (!$datas['username'])
			$err[] = 'username';
		if (!$datas['cookie'])
			$err[] = 'cookie';
		if ($err !== NULL)
		{
			$datas = people_get($datas['username'], $datas['pasrd']);
			if ($datas === NULL)
				return (array('User not found'));
			$_SESSION['username'] = $datas['username'];
			return NULL;
		}
		else
			return ($err);
	}

	function login(array $datas)
	{
		$err = NULL;
		if (!isset($datas['username']))
			$err[] = 'username';
		if (!isset($datas['password']))
			$err[] = 'password';
		if ($err === NULL)
		{
			$datas = people_get($datas['username'], $datas['password']);
			if ($datas === NULL)
				return (array('User not found'));
			$_SESSION['username'] = $datas['username'];
			return NULL;
		}
		else
			return ($err);
	}

	if ($_POST['from'] && in_array($_POST['from'], $functions)) {
		$err = $_POST['from']($_POST);
		$datas = $_POST;
		if (!($err === TRUE || $err === null)) {
			$str_error = implode('&', $err);
			if ($_POST['error']){
				header('Location: ../' . $_POST['error'] . '.php?' . 'toast=' . $str_error . '&username=' . $datas['username']);
				exit();
			}
			header('Location: ../' . $_POST['from'] . '.php?' . 'toast=' .  $str_error . '&username=' . $datas['username']. '&email=' . $datas['email']. '&lastname=' . $datas['lastname']. '&firstname=' . $datas['firstname']. '&address=' . $datas['address']);
			exit();
		}
		header('Location: ../' . $_POST['success'] . '.php');
		exit();
	}
?>
