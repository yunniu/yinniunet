<?php
 return array(
    /* 数据库设置 */
	'LOAD_EXT_CONFIG'=>'db', // 加载数据库配置文件

     /*订单的状态*/
     'ORDER_STATUS' => array(
         0 => '待确认',
         1 => '已确认',
         2 => '已收货',
         3 => '已取消',
         4 => '已完成',//评价完
         5 => '已作废',
     ),
     'SHIPPING_STATUS' => array(
         0 => '未发货',
         1 => '已发货',
         2 => '部分发货'
     ),
     'PAY_STATUS' => array(
         0 => '未支付',
         1 => '已支付',
     ),
);