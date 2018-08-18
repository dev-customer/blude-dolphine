<?php if(!defined('DIR_APP')) die('Your have not permission'); 
class Products extends Module
{
    function __construct()
    {
        global $db, $mod;
        $this->model('shop/model/products');
    }

    function index()
    {
        global $db, $mod;
        $rowpage = 10;
        $curpage = CUR_ROWS;
        $getpage = empty($_GET['page']) ? 1 : $_GET['page'];
        $offset = ($getpage - 1) * $rowpage;
        $limit = $offset . ',' . $rowpage;

        $fieldList = " p.*, c.title AS category";
        $url = '';
        $sqlExt = " AND p.publish = 1";

        if ($_GET['alias'] != '') {
            if ($_GET['alias'] == 'sale-off') {
                $sqlExt .= " AND p.discount > 0";
                $url = BASE_NAME . 'sale-off.html';
            } else {
                $cate = $this->loadObject('SELECT * FROM #__shop_category WHERE alias = "' . $_GET['alias'] . '"');
                if (!empty($cate)) {
                    $cListID = getCategoryShop($cate['id_cat'], '', '');
                    $cList = categoryToArray($cListID);
                    $cList[] = $cate['id_cat'];
                    $sqlExt .= " AND p.id_cat IN (" . implode(',', $cList) . ")";
                    $url = LINK_SHOP_LIST . $_GET['alias'] . '.html';
                } else {
                    $this->redirect(BASE_NAME);
                }
            }

        }
        //filter manuafct
        if ($_GET['malias'] != '') {
            $man = $this->loadObject('SELECT * FROM #__shop_manuafact WHERE alias = "' . $_GET['malias'] . '"');
            if (!mpty($man)) {
                $sqlExt .= " AND m.alias = '" . $_GET['malias'] . "'";
                $url = LINK_SHOP_MANUFACT_ITEM . $_GET['malias'] . '.html';
            }
        }
        //filter location
        //if($_POST['sLocation'] != '')
        //{
        //	$sqlExt .= " AND c.jsLocationGroup LIKE '%".$_POST['sLocation']."%'";
        //}

        $key = isset($_POST['keyword']) ? addslashes($_POST['keyword']) : '';
        $sqlExt .= !empty($key) ? " AND  p.title LIKE '%" . $key . "%'" : '';
        $sqlExt .= !empty($_POST['categorySearch']) ? " AND p.id_cat = " . (int)$_POST['categorySearch'] : '';

        //echo $sqlExt;

        $data = loadListShop($fieldList, $sqlExt, '', $limit);
        $data['category'] = $db->loadObject('SELECT title FROM #__shop_category WHERE alias = "' . $_GET['alias'] . '"');

        $url = $url != '' ? $url : LINK_SHOP_ALL;
        $data['paging'] = PagingFront::load($getpage, $data['totalRecord'], $rowpage, $curpage, $url);


        if (empty($man)) {
            $cate = $this->loadObject('SELECT * FROM #__shop_category WHERE alias = "' . $_GET['alias'] . '"');
            $cShopSub = getCategoryShop($cate['id_cat'], '', '');
            $data['list_category_child'] = $cShopSub;
            $data['id_main_cat'] = $cate['id_cat'];
        }
        $this->view('shop/view/products', $data);
    }

    public function brand()
    {
        global $db, $mod;
        $rowpage = 10;
        $curpage = CUR_ROWS;
        $getpage = empty($_GET['page']) ? 1 : $_GET['page'];
        $offset = ($getpage - 1) * $rowpage;
        $limit = $offset . ',' . $rowpage;

        $data = [];

        $fieldList = " p.*, c.title AS category";
        $url = '';
        $sqlExt = " AND p.publish = 1";

        if ($_GET['alias'] != '') {
            if ($_GET['alias'] == 'sale-off') {
                $sqlExt .= " AND p.discount > 0";
                $url = BASE_NAME . 'sale-off.html';
            } else {
                $cate = $this->loadObject('SELECT * FROM #__shop_category WHERE alias = "' . $_GET['alias'] . '"');
                if (!empty($cate)) {
                    $cListID = getCategoryShop($cate['id_cat'], '', '');
                    $cList = categoryToArray($cListID);
                    $cList[] = $cate['id_cat'];
                    $sqlExt .= " AND p.id_cat IN (" . implode(',', $cList) . ")";
                    $url = LINK_SHOP_LIST . $_GET['alias'] . '.html';
                } else {
                    $this->redirect(BASE_NAME);
                }
            }

        }

        //filter manuafct
        if ($_GET['malias'] != '') {
            $man = $this->loadObject('SELECT * FROM #__shop_manuafact WHERE alias = "' . $_GET['malias'] . '"');
            if (!empty($man)) {
                $sqlExt .= " AND m.alias = '" . $_GET['malias'] . "'";
                $url = LINK_SHOP_MANUFACT_ITEM . $_GET['malias'] . '.html';
                $brandName = $man['name'];
            }
        }

        //filter location
        /*
        if($_POST['sLocation'] != '')
        {
            $sqlExt .= " AND c.jsLocationGroup LIKE '%".$_POST['sLocation']."%'";
        }
        */

        $key = isset($_POST['keyword']) ? addslashes($_POST['keyword']) : '';
        $sqlExt .= !empty($key) ? " AND  p.title LIKE '%" . $key . "%'" : '';
        $sqlExt .= !empty($_POST['categorySearch']) ? " AND p.id_cat = " . (int)$_POST['categorySearch'] : '';

        // echo $sqlExt;

        // die;
        $data = loadListShop($fieldList, $sqlExt, '', $limit);
        $data['category'] = $db->loadObject('SELECT title FROM #__shop_category WHERE alias = "' . $_GET['alias'] . '"');

        $url = $url != '' ? $url : LINK_SHOP_ALL;
        $data['paging'] = PagingFront::load($getpage, $data['totalRecord'], $rowpage, $curpage, $url);
        $data['brandName'] = $brandName;
        $this->view('shop/view/productsBrand', $data);
    }


    function home()
    {
        $this->view('shop/view/home');
    }

    function cart()
    {
        if ($_SESSION['cart']) {
            $idList = implode(',', array_keys($_SESSION['cart']));
            $fieldList = " p.*";
            $sqlExt = " AND p.publish = 1 AND id_product IN (" . $idList . ")";
            $data = loadListShop($fieldList, $sqlExt);
        }
        $this->view('shop/view/productsCart', $data);
    }

    function payment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);

            if (ModelProducts::insertOrder()) {
                $_SESSION['message'] = '<span class="glyphicon glyphicon-ok clr-sdt1"></span> Đặt hàng thành công';
                foreach ($_SESSION['cart'] as $key => $value) {
                    unset($_SESSION['cart'][$key]);
                }
            } else {
                $_SESSION['message'] = 'Có sự cố trong việc đặt hàng';
                $this->redirect($curUrl);
            }
        }

        if ($_SESSION['cart']) {
            $idList = implode(',', array_keys($_SESSION['cart']));
            $fieldList = " p.*";
            $sqlExt = " AND p.publish = 1 AND id_product IN (" . $idList . ")";
            $data = loadListShop($fieldList, $sqlExt);
        }
        $this->view('shop/view/productsPayment', $data);
    }

    function detail()
    {
        global $mod;
        $fieldList = " p.*, c.alias AS calias, c.title AS ctitle, m.alias AS malias, m.name AS mtitle";
        $sqlExt = " AND p.alias = '" . $mod->id . "'";
        $data = loadItemShop($fieldList, $sqlExt);
        if ($data['row']) {
            $this->view('shop/view/productsDetail', $data);
        } else {
            $this->redirect(BASE_NAME);
        }
    }

    function menuParent()
	{
		$data = array();
       	$this->view('shop/view/menuParent', $data);
	}

	function menuChild()
	{
        $data = array();
        $this->view('shop/view/menuChild', $data);
	}
	
}
?>	
