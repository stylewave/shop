<?php
//zend53   
//Decode by www.dephp.cn  QQ 2859470
?>
<?php

define("IN_ECS", true);
require ("./init.php");
require_once (ROOT_PATH . "includes/lib_order.php");
require_once ("../includes/cls_json.php");
$json = new JSON();
$res = array("code" => 0, "msg" => '');

// $ID= trim($_REQUEST["ID"]) ;
// $PID= $_REQUEST["PID"];
// $money= $_REQUEST["money"];
// $time= $_REQUEST["time"];
// $token= $_REQUEST["token"];
$ID= trim($_POST["ID"]) ;
$com= trim($_POST["com"]) ;
$PID= $_POST["PID"];
$money= $_POST["money"];
$time= $_POST["time"];
$token= $_POST["token"];
$des='充值,来自结算系统账户'.$PID;
$t=-1;

$str = $time.$ID.$money.'QAZXSWEDC!@#_+_158';
$m=md5($str);

if ($m!=$token) {
	$res["code"] = 0;
	$res["msg"] = '参数错误'.$str;
}
else
{

$company_id=$db->getOne("SELECT company_id  FROM " . $ecs->table("company") . " WHERE code= '" .$com. "'");
if (!$company_id) {
	$res["code"] = 0;
	$res["msg"] = '企业不存在在';
	$val = $json->encode($res);
    exit($val);
}
$je=$db->getOne("SELECT je  FROM " . $ecs->table("company") . " WHERE code= '" .$com. "'");

if ($money>$je) {
	$res["code"] = 0;
	$res["msg"] = '企业金额不足';
	$val = $json->encode($res);
    exit($val);
}


$sql = "SELECT COUNT(*)  FROM " . $ecs->table("users") . " WHERE md5(user_id) = '" .$ID. "' and  com_code = '" .$com. "'";


$user_id=$db->getOne("SELECT user_id  FROM " . $ecs->table("users") . " WHERE md5(user_id) = '" .$ID. "'");
if ($db->getOne($sql)) {
	
	
	$sql11 = "SELECT COUNT(*)  FROM " . $ecs->table("account_log") . " WHERE token = '" .$token. "'";
	if ($db->getOne($sql11)>0) {
	$res["code"] = 0;
	$res["msg"] = 'token参数,已经被使用过';
	
	}
	else
	{

	// $s = "SELECT allowed_money  FROM " . $ecs->table("users") . " WHERE user_id = '" .$user_id. "'";
	// $s1 = "SELECT allow_money  FROM " . $ecs->table("users") . " WHERE user_id = '" .$user_id. "'";


	// $allowed_money=$db->getOne($s);
	// $allow_money=$db->getOne($s1);
	// if (!$allow_money) {
		// $allow_money=0;
	// }
	// if($allow_money)
	// {
	// $res["code"] = 0;
	// $res["msg"] = '转入限额没有设置,请联系管理员开通转入限额';
	// $val = $json->encode($res);
    // exit($val);

	// }
	// if ($allowed_money+$money>$allow_money) {
	// $res["code"] = 0;
	// $res["msg"] = '转入额度不足本次转入,请联系管理员调整转入限额';
	// $val = $json->encode($res);
    // exit($val);
	// }




	$sql2 = "UPDATE" . $ecs->table("company") . " set je=je- " .$money. "   WHERE company_id = " . $company_id;
	$sql = "UPDATE" . $ecs->table("users") . " set user_money=user_money+ " .$money. ",allowed_money=allowed_money+ " .$money. "   WHERE user_id = " . $user_id;
	$sqli= "INSERT INTO " . $ecs->table("account_log") . "  (user_id,user_money,change_time,change_desc,change_type,token) VALUES(" .$user_id. "," .$money. "," .time(). ",'" .$des. "'," .$t. ",'" .$token. "')"; 


	$db->query($sqli);
	$db->query($sql);
	$res["code"] = 1;
	$res["msg"] = '充值成功！';
	}

}
else {
	$res["code"] = 0;
	$res["msg"] = '钱包地址不存在或企业名称错误';
}
}





$val = $json->encode($res);
exit($val);

?>
