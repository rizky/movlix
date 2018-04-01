<?php
session_start();
	require_once('../models/user.php');
	require_once('../models/orders.php');
	require_once('../models/products.php');
	require_once('../models/ord_has_prod.php');

	$functions = array('get_order', 'del_orders', 'add_order', 'cart');

	function get_order(array $datas)
	{
		if (!$datas['order_id'] || !is_numeric($datas['order_id']))
			return (array('order_id'));
		$order_id = intval('order_id');
		return (prod_get_byord($order_id));
	}

	function del_orders(array $datas)
	{
		if (!$datas['username'])
			return (array('username'));
		$user = people_exist($datas['username']);
		if ($user)
		{
			if (del_order($user['id']) === TRUE)
				return NULL;
			else
				return array("order" => "notexist");
		}
		else
			return array("username" => "notexist");
	}

	function add_order(int $product_id, int $quantity, string $username)
	{
		$people = people_exist($username);
		if ($people)
		{
			$stock = stock_get_byid($product_id);
			if ($stock >= $quantity)
			{
				if (order_get_bypid($people['id']) === NULL)
					order_create($people['id']);
				$order = order_get_bypid($people['id']);
				if ($order)
				{
					$prod = prod_add_toord($product_id, $order['id'], $quantity);
					if ($prod === TRUE)
					{
						product_updatestock_byid($product_id, $stock - $quantity);
						return (NULL);
					}
					else
						return (array("add_order" => "fail"));
				}
				return array("commandfound");
			}
				else
					return (array("outofstock" => $stock));
		}
		else
			return array("username" => "notexist");
	}

	function cart()
	{
		$basket = unserialize($_SESSION['basketMovie']);

		if ($_SESSION['username'])
		{
			foreach($basket as $k => $v)
			{
				$ret = add_order($k, $v, $_SESSION['username']);
				if ($ret !== NULL)
					$err[] = $ret;
			}
			return $err;
		}
		return array('notconnected');
	}

	if ($_POST['from'] && in_array($_POST['from'], $functions)) {
		if (($err = $_POST['from']($_POST))) {
			$str_error = http_build_query($err);
			header('Location: ../' . $_POST['from'] . '.php?' . $str_error);
		} else
		{
			$_SESSION['basketMovie'] = null;
			$_SESSION['basketPrice'] = null;
			$_SESSION['basketCount'] = null;
			header('Location: ../' . $_POST['success'] . '.php');
		}
	}
?>
