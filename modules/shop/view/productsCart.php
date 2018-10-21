<?php if(!defined('DIR_APP')) die('You have not permission'); 
global $json;
?>
<div class="container-fluid">
    <div class="container"> 
		<div class="panel">
			<div class="col-sm-12 col-md-12"> 
				<div class="panel panel-default"> 
				<?php

                function maxFind($arr) {
                    if (is_array($arr)) {
                        $max = 0;
                        foreach ($arr as $value) {
                            if ($value > $max) {
                                $max = $value;
                            }
                        }
                    }
                    return $max;
                }

                function sosanh($sl, $arr) {
                    $data = array();
                    if (is_array($arr)) {
                        foreach ($arr as $key => $value) {
                            if ($sl <= $key) {
                                $data[$sl] =  $value;
                                break;
                            }
                        }
                    }

                    return $data;
                }

                function subTotal($arr) {
                    foreach ($arr as $key => $value) {
                        return $key * $value;
                    }
                }

                function showGia($arr) {
                    foreach ($arr as $key => $value) {
                        return $value;
                    }
                }

				if(@$rows)
				{
				?> 
					<table class="table table-bordered">
						<thead>
							<tr class="bg-sdt1">
							  <th>Image</th>
							  <th><?=LB_PRODUCT?></th>
							  <th>Price</th>
							  <th>Number</th>
							  <th>Total</th>
							  <th>Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$total = 0;	
							foreach($data['rows'] as $row):
                                $jsSoluong = json_decode($row['jsSoluong']);
                                $soluong = array();
                                if ($jsSoluong) {
                                    foreach ($jsSoluong as $value) {
                                        $sl = explode('-', $value->soluong);
                                        $max = maxFind($sl);
                                        $soluong[$max] = $value->gia;
                                    }
                                }

                                $slGia = sosanh($_SESSION['cart'][$row['id_product']]['number'], $soluong);
                                //$rprice = $row['discount'] > 0 ? discountPrice($row['price'], $row['discount']) :
                                // $row['price'];
                                //$subTotal = $_SESSION['cart'][$row['id_product']]['number'] * $rprice;

                                $subTotal  = subTotal($slGia);

                                $total += $subTotal;
								$link= BASE_NAME.'product/'.$row['alias'].'.html';
								$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']); 
								?>
								<tr id="product-item-<?=$row['id_product']?>">
									<td> 
									<?=
									showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '100', '100', "", "", '', '');
									?>					  
									</td>
									<td><a href="<?=$link?>"><?=$title?></a> </td>
                                    <td>
                                        <span class="priceFormat">
                                        <?php
                                            echo showGia($slGia);
                                        ?>
                                        </span>
                                    </td>
<!--									<td class="">-->
<!--										--><?php
//										if($row['discount']>0){?>
<!--											<span class="priceFormat">--><?//=$rprice?><!--</span> - <del><span class="priceFormat discountPrice" style="">--><?//=$row['price']?><!--</span></del>											-->
<!--										--><?php
//										}else{?>
<!--											<span class="priceFormat">--><?//=$rprice?><!--</span>											-->
<!--										--><?php
//										}?><!-- -->
<!--									</td>-->
									<td> <?=$_SESSION['cart'][$row['id_product']]['number']?> </td>
									<td class="priceFormat txtPrice"><?=$subTotal?></td>
									<td><p class="pointer fa fa-remove delete-cart clr-sdt2" data-id="<?=$row['id_product']?>" title="Delete"></p></td>
								</tr>
								<?php
							endforeach;	?>
						</tbody>
					</table> 
					<div class="panel-body text-center">			   
						<a href="/"><span  class="btn bg-sdt1"><i class="fa fa-cart-plus" aria-hidden="true"></i> <?=BTN_SHOP_CONTINUATE?></span></a> 			   			  
						<a href="<?=LINK_SHOP_CART_PAYMENT?>"><span class="btn bg-sdt1"><i class="fa fa-usd" aria-hidden="true"></i> <?=BTN_SHOP_PAYMENT?></span></a>             			  
					</div>  
				<?php
				}else
					echo '<div class="alert alert-warning text-center"><span class="glyphicon glyphicon-shopping-cart clr-sdt1"></span> Chưa có sản phẩm  nào</div>';
				?> 
				</div>
			</div> 
		</div>
	</div>
</div>

 

