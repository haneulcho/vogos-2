<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined("_ORDERINQUIRY_")) exit; // 개별 페이지 접근 불가
?>
<?php
	// 3주전(21일 = 1814400seconds) 상품까지 주문상태 출력
	$btime = date("Y-m-d 00:00:00", G5_SERVER_TIME - 1814400);
	$sql =" select od_status from {$g5['g5_shop_order_table']} where mb_id = '{$member['mb_id']}' and od_time >= '$btime' order by od_id desc";
	$rst = sql_query($sql);
	$ct01 = $ct02 = $ct03 = $ct04 = $ct05 = 0;

	for ($i=0; $row=sql_fetch_array($rst); $i++)
	{
		switch($row['od_status']) {
			case '주문':
				$od_status = '입금대기중';
				$ct01++;
				break;
			case '입금':
				$od_status = '입금완료';
				$ct02++;
				break;
			case '준비':
				$od_status = '배송준비중';
				$ct03++;
				break;
			case '배송':
				$od_status = '배송중';
				$ct04++;
				break;
			case '완료':
				$od_status = '배송완료';
				$ct05++;
				break;
			default:
				$od_status = '주문취소';
				break;
		}
	}
?>
<ul class="status_lst">
	<li><div><h3>입금<br />대기중</h3></div><p><?=$ct01; ?></p><span><i class="ion-ios-redo"></i></span></li>
	<li><div><h3>결제<br />완료</h3></div><p><?=$ct02; ?></p><span><i class="ion-ios-redo"></i></span></li>
	<li><div><h3>배송<br />준비중</h3></div><p><?=$ct03; ?></p></li>
	<li><div><h3>배송중</h3></div><p><?=$ct04; ?></p><span><i class="ion-ios-redo"></i></span></li>
	<li><div><h3>배송<br />완료</h3></div><p><?=$ct05; ?></p></li>	
</ul>