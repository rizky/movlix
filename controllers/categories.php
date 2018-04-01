<?php
  session_start();
    require_once('../models/categories.php');
    require_once('../models/products.php');
    require_once('../models/prod_has_cat.php');

    $functions = array('removecategory', 'addcategorie', 'updatecategorie');

    function addcategorie(array $data)
    {
      $err = NULL;
      if (!$data['name'])
        $err[] = 'name';
      if ($err !== NULL)
        return $err;
      if (!category_get($data['name']))
      {
        if (category_create($data['name']) === TRUE)
          return NULL;
        else
          return array('Unknown Error');
      }
      else
        return array('Category is already exist');
    }

    function updatecategorie(array $data)
    {
      $err = NULL;
      if (!$data['oldname'])
        $err[] = 'oldname';
      if (!$data['name'])
        $err[] = 'name';
      if ($err !== NULL)
        return $err;
      if (!category_get($data['name']))
      {
        if (category_update($data['oldname'], $data['name']) === TRUE)
          return NULL;
        else
          return array('Unknow Error');
      }
      else
        return array('Category is already exist');
    }

    function removecategory(array $data)
    {

        if ($data['name']) {
            $cat = category_get($data['name']);
            if ($cat) {
                $prods = product_get_bycat($data['name']);
                if ($prods) {
                    foreach ($prods as $k => $v) {
                        product_clear_byid(intval($v['products_id']));
                    }
                }
                link_prodcat_delete_bycat($cat['id']);
                category_delete($data['name']);
            }

        } else
            return array("Category is not exist");
    }

    if ($_POST['from'] && in_array($_POST['from'], $functions)) {
        if (($err = $_POST['from']($_POST))) {
            $str_error = http_build_query($err);
            header('Location: ../' . $_POST['success'] . '.php?' . 'toast=' . $str_error);
        } else
            header('Location: ../' . $_POST['success'] . '.php');
    }
?>
