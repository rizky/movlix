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
				return array("Order does not exist");
		}
		else
			return array("Username does not exist");
	}

	function add_order(int $product_id, int $quantity, string $order_id)
	{
		$stock = stock_get_byid($product_id);
		if ($stock >= $quantity)
		{
			$prod = prod_add_toord($product_id, $order_id, $quantity);
			if ($prod === TRUE)
			{
				product_updatestock_byid($product_id, $stock - $quantity);
				return (NULL);
			}
			else
				return (array("Add order fail"));
		}
			else
				return (array("One of the movie is out of stock"));
	}

	function cart()
	{
		$basket = unserialize($_SESSION['basketMovie']);

		if ($_SESSION['username'])
		{
			$people = people_exist($_SESSION['username']);
			if ($people)
			{
				$order_id = order_create($people['id']);
				foreach($basket as $k => $v)
				{
					$ret = add_order($k, $v, $order_id);
					if ($ret !== NULL)
						$err[] = $ret;
				}
				return $err;
			}
			else
				return array("No user found");
		}
		return array('No connections');
	}

	if ($_POST['from'] && in_array($_POST['from'], $functions)) {
		if (($err = $_POST['from']($_POST))) {
			$str_error = http_build_query($err);
			header('Location: ../' . $_POST['from'] . '.php?' . 'toast=' . $str_error);
		} else
		{
			$_SESSION['basketMovie'] = null;
			$_SESSION['basketPrice'] = null;
			$_SESSION['basketCount'] = null;
			header('Location: ../' . $_POST['success'] . '.php');
		}
	}
?>
