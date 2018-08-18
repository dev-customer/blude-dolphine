<?php
    global  $mod, $cShop;
?>


<div class="cate-list-page" id="cateList">
    <div class="header" id="hd">
        <h2 class="title">
            <a href="./">TRANG CHỦ
            </a>
        </h2>
    </div>
    <div class="wrapper">
        <div class="c-cont">
            <ul class="bu-list">
                <?php
                foreach($cShop as $key => $row1) {
                    if ($row1[5] == 0) {
                        $link1 = LINK_MCHILD . $row1[0] . '.html';
                        $title1 = $row1[1];
                        $img = DIR_UPLOAD . '/shop/'.$row1['6'];
                        $cShopSub = getCategoryShop($row1[0], '', '');
                        if (empty($cShopSub)) {
                            $link1 = LINK_SHOP_LIST.$row1[4].'.html';
                        }
                ?>
                        <li class="item">
                            <a href="<?=$link1?>">
                                <i class="icon icon-wuage"></i>
                                <div class="info">
                                    <h4><?=$title1?></h4>
                                </div>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?=TEMPLATE?>css/menup.css">