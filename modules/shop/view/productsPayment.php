<?php if(!defined('DIR_APP')) die('You have not permission'); 
global $json, $db, $contact; 
?>
<style>
.frmPayment .input-group{ width:100%}
</style>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn-action-payment').click(function(){
		$msg = '';
		$('.requireData').each(function(index, element) {
			if($(this).val()==''){
				$msg = $msg + $(this).attr('title');
				$(this).addClass('requireRed');  
			}else {        
				$(this).removeClass('requireRed');  
			}
        });
		
		if($msg=='')
			document.frmList.submit();
			
		return false;
	});
})
</script>
<div class="container-fluid side-main side-detail">
    <div class="container">
    	
		<?php 
		if(@$_SESSION['message']):?>
			<div class="msgSys alert alert-warning text-center" role="alert"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
		<?php 
		endif; 
		?> 
		<div class="col-sm-12 col-md-12 shadow">
			<div class="panel"> 
					<div class="">
						<?php
						if(@$rows)
						{ 	?> 
							<form class="frmPayment form-horizontal" method="post">
								<div class="col-md-6"> 									
									<div class="panel panel-info clearfix">
										<div class="panel-heading bg-sdt1"><?=BTN_SHOP_ORDER_INFO?></div>
										<div class="panel-body col-md-11" style=" margin: auto; float: inherit;"> 
											<div class="form-group">
												<input name="fullname" class="form-control"  placeholder="<?=NAME?>" value="<?=$fullname?>" required>
											</div>
											<div class="form-group"> 
												<input name="address" class="form-control"  placeholder="<?=ADDRESS?>" value="<?=$email?>" required>
											</div>
											<div class="form-group"> 
												<input name="phone" class="form-control"  placeholder="<?=PHONE?>" value="<?=$phone?>" required>
											</div>
											<div class="form-group"> 
												<?php
													$dropList = $this->loadObjectList('SELECT * FROM #__shop_product_payment');
													echo dropDown('id_payment', $dropList, 'id_payment', 'title', @$row['id_payment'], 'class="requireData form-control" required','Thanh toán');
												?> 
											</div> 
											<div class="form-group"> 
												<textarea  name="description" rows="5" class="form-control" placeholder="<?=MESSAGE?>"></textarea>
											</div> 
										  
											<div class="form-group">
												<div class="col-md-6">
													<button type="submit" class="btn  bg-sdt1"><?=BTN_ACT_CONFIRM?></button>
												</div>
											</div> 
										</div>
									</div> 
								</div>
								
								<div class="col-md-6 ">   
									<div class="panel panel-info">
										<div class="panel-heading bg-sdt1">
											<?=BTN_SHOP_ORDER_REVIEW?> <div class="pull-right"><a  href="<?=LINK_SHOP_CART?>"><span class="glyphicon glyphicon-pencil clr-sdt2"></span></a></div>
										</div>
										<div class="panel-body">
											<table class="table table-bordered table-hover">
												<thead>
													<th>Image</th>
													<th>SP</th>
													<th>Giá</th>
													<th>Tổng</th>
												</thead>
												<tbody> 
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
                                                        $subTotal  = subTotal($slGia);

                                                        /*
														$rprice = $row['discount'] > 0 ? discountPrice($row['price'], $row['discount']) : $row['price'];
														$subTotal = $_SESSION['cart'][$row['id_product']]['number'] * $rprice;
														*/

														$total += $subTotal;
														$link= LINK_SHOP_ITEM.$row['alias'].'.html';
														$title = $json->getDataJson1D($row['title'], $_SESSION['dirlang']);											
														?>																							
															<tr>
																<td><?= showImg(DIR_UPLOAD.'/shop/'.$row['image'], 'shop/'.$row['image'], 'no-image.png', '', 30, "", "", '', ''); ?></td>
																<td><span><?=$title?></span>
																	<div>
																		<?php
																		if($row['discount']>0){?>
																			<span class="priceFormat"><?=$rprice?></span> - <del><span class="priceFormat discountPrice" style=""><?=$row['price']?></span></del>											
																		<?php
																		}else{?>
																			<span class="priceFormat"><?=$rprice?></span>											
																		<?php
																		}?>
																	</div>
																	<?php
																	if($_SESSION['cart'][$row['id_product']]['color'] != ''):?>
																		<p>Color: <span class="badge" style="background:<?=$_SESSION['cart'][$row['id_product']]['color']?>">color</span></p>																	
																	<?php
																	endif;
																	?>
																	
																	<?php
																	if($_SESSION['cart'][$row['id_product']]['size'] != ''):?>
																		<p>Size: <span class="badge"><?=$_SESSION['cart'][$row['id_product']]['size']?></span></p>
																	<?php
																	endif;
																	?>
																	
																</td>
																<td><?=$_SESSION['cart'][$row['id_product']]['number']?></td>
																<td><h6 class="priceFormat txtPrice"><?=$subTotal?></h6></td>
															</tr>				 										
														<?php
													endforeach;	?> 
													<tr>
														<td colspan="4" class="text-right"> 
															<div>Total: <span class="priceFormat txtPrice"><?=$total?></span></div>
														</td>
													</tr>	 
												</tbody>
											</table>  
										</div>
									</div> 
								</div>
							</form>
						<?php
						}else
						{
							echo '<div class="alert alert-danger">No data</div>';
						}?>
					</div> 
			</div> 
		</div>
	</div>
</div>
 

