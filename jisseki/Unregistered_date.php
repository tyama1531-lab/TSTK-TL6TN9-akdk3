<?php
  $DSN        = "Xacti_resource_database";	//データソース名
  $DBUSER     = "Xacti";					//ログインユーザー名
  $DBPASSWORD = "5346";						//パスワード
  
  //Accessデータベースに接続
  if (! $con = odbc_connect($DSN, $DBUSER, $DBPASSWORD)){
    exit("Accessデータベースに接続できませんでした！");}
  
  $name_code = $_GET["code"];
  
  $sql_unregisterd = "SELECT Q_Unregisterd_resoult.Unregisterd_namecode, Q_Unregisterd_resoult.Unregesterd_date FROM Q_Unregisterd_resoult WHERE (((Q_Unregisterd_resoult.Unregisterd_namecode)=" . $name_code . "))";
  $rst_unregisterd = odbc_exec($con, $sql_unregisterd);
  $body_unregisterd = "";
  $nCnt = 0;
  while (odbc_fetch_row($rst_unregisterd))
  {
    $body_unregisterd .= date('Y/n/j', strtotime(odbc_result($rst_unregisterd, "Unregesterd_date"))) . "<br>";
    $nCnt += 1;
  }
  
  If ($nCnt==0)
    $body_unregisterd = "未登録日はありません";
  
  //Accessデータベースとの接続を解除
  odbc_close($con);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML lang="ja">
  <HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <META http-equiv="Content-Style-Type" content="text/css">
    <title>未登録日一覧</title>
  </HEAD>
  <BODY>
    <p style="font-size:14px;"><B><U>未登録日一覧</U></B> ※未登録日の更新は翌日反映されます</p>
    <p style="font-size:14px;"><?=$body_unregisterd?></p>
  </BODY>
</HTML>	