<?php
    global  $mod, $cShop;
    $id = $mod->id;
?>
<?php
$cShopSub = getCategoryShop($id);
$cateP = [];
foreach ($cShop as $value) {
    if ($value[0] = $id) {
        $cateP = $value;
        break;
    }
}
?>

<div class="cate-list-page" id="cateList">
    <div class="header" id="hd">
    <h2 class="title">
        <a href="./">TRANG CHỦ
        </a>
    </h2>
    </div>
    <div class="c-cont flex-box">
        <div class="second-cate">
            <ul class="sub-cate-list ">
                <li class=" active info">
                    <a href="<?=LINK_SHOP_LIST.$cateP[4].'.html';?>">
                        <?php echo $cateP[1] ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="third-cate">
            <div class="third-cate-list">

                <?php
                    foreach ($cShopSub as $row2) {
                        $link2  =  LINK_SHOP_LIST.$row2[4].'.html';
                        $title2 = $row2[1];
                ?>
                        <a href="<?php echo $link2; ?>" class="item">
                            <?php echo $title2 ?>
                        </a>
                <?php
                    }
                ?>


            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?=TEMPLATE?>css/menuc.css">