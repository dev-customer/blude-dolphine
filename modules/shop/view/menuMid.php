<?php
    global  $mod, $cShop;
    $pid = $mod->pid;
    $id = $mod->id;
?>
<?php
$cateP = [];
foreach ($cShop as $value) {
    if ($value[5] == $pid) {
        $cateP[] = $value;
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
                <?php
                foreach ($cateP as $keyP => $menuP) {
                ?>
                    <li class="<?php echo ($menuP[0] === $id ? 'active':'') ?> info">
                        <a href="<?=LINK_MMID . $pid . '/' .$menuP[0] . '.html'; ?>">
                            <?php echo $menuP[1] ?>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="third-cate">
            <div class="third-cate-list">

                <?php
                    $cShopSub = getCategoryShop($id);
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