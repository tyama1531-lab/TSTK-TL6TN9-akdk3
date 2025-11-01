<?php
  $DSN        = "Xacti_resource_database";	//データソース名
  $DBUSER     = "Xacti";					//ログインユーザー名
  $DBPASSWORD = "5346";						//パスワード
  
  //Accessデータベースに接続
  error_reporting(0);
  
  //Accessデータベースに接続
  if (! $con = odbc_connect($DSN, $DBUSER, $DBPASSWORD))
  {
    exit("メンテナンス中です。\nしばらくお待ちください...");
  }
  
  error_reporting(-1);
  
  
  // システム日付を取得する。 
  $today = date("Y-m-d 00:00:00");
  //日付情報の読込み
  $sql_calendar = "SELECT Q_Calendar_list.Date_CD, Q_Calendar_list.Date_list, Q_Calendar_list.Workday FROM Q_Calendar_list";
  $rst_calendar = odbc_exec($con, $sql_calendar);
  $nCnt = 0;
  $nCnt_workday = 0;
  $resoult_judge = 0;
  while ($resoult_judge==0)
  {
    odbc_fetch_row($rst_calendar);
    $nCnt_workday += odbc_result($rst_calendar, "Workday");
    If (odbc_result($rst_calendar, "Date_list")==$today)
      $resoult_judge = 1;
    else
      $resoult_judge = 0;
  }
  
  odbc_fetch_row($rst_calendar, 0);
  while ($nCnt<>$nCnt_workday)
  {
    odbc_fetch_row($rst_calendar);
    $nCnt += odbc_result($rst_calendar, "Workday");
  }
//$workdate = '"' . odbc_result($rst_calendar, "Date_list") . '"';
  $workdate = '"' . $today . '"';
  
  odbc_free_result($rst_calendar);
  
  //Accessデータベースとの接続を解除
    odbc_close($con);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML lang="ja">
  <HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <META http-equiv="Content-Style-Type" content="text/css">
    <title>実績入力ログイン</title>
  </HEAD>
  <BODY>
    <script>
      var d = new Date();
      var today = new Date();
      
      // 年月日・曜日・時分秒の取得
      var month  = d.getMonth() + 1;
      var day    = d.getDate();
      
      // 1桁を2桁に変換する
      if (month < 10) {month = "0" + month;}
      if (day < 10) {day = "0" + day;}
       
      // 整形して返却
      var Inputdate = month + day + d.getFullYear();
      
      var temp = <?php echo $workdate; ?>;
      year  = temp.substr(0, 4);
      month = temp.substr(5, 2);
      day   = temp.substr(8, 2);
      Inputdate = month + day + year;
      
      document.write('<form name="Form1" action="jisseki_input-test.php" method="get" onsubmit="return chk1(this)">');
        document.write('<p style="font-size:13px">氏名コード：');
        document.write('<input type="text" id="shaincode" name="code" size="6" maxlength="5"></p>');
        document.write('<input type="hidden" name="indate" value='+ Inputdate +'>');
        document.write('<input type="hidden" name="updt" value=1>');
        document.write('<input type="hidden" name="am1" value=0>');
        document.write('<input type="hidden" name="am2" value=0>');
        document.write('<input type="hidden" name="am3" value=0>');
        document.write('<input type="hidden" name="am4" value=0>');
        document.write('<input type="hidden" name="pm1" value=0>');
        document.write('<input type="hidden" name="pm2" value=0>');
        document.write('<input type="hidden" name="pm3" value=0>');
        document.write('<input type="hidden" name="pm4" value=0>');
        document.write('<input type="hidden" name="pm5" value=0>');
        document.write('<input type="hidden" name="ot1" value=0>');
        document.write('<input type="hidden" name="ot2" value=0>');
        document.write('<input type="hidden" name="al1" value=0>');
        document.write('<input type="hidden" name="al2" value=0>');
        document.write('<input type="hidden" name="al3" value=0>');
        document.write('<input type="hidden" name="pl1" value=0>');
        document.write('<input type="hidden" name="pl2" value=0>');
        document.write('<input type="hidden" name="pl3" value=0>');
        document.write('<input type="hidden" name="ol1" value=0>');
        document.write('<input type="hidden" name="ol2" value=0>');
        document.write('<p><input type="submit" name="loginbutton" value="Login"></p>');
      document.write('</form>');
    </script>
    
    <script type="text/javascript">
      function chk1(frm)
      {
        /* 空欄判定 */
        if(frm.elements["code"].value=="")
        {
          alert("氏名コード入力してください");
          /* FALSEを返してフォームは送信しない */
          return false;
        }
        else
        {
          /* 桁数判定 */
          var input_code_length = document . Form1 . code . value . length;
          if ( input_code_length < 5 )
          {
            alert("5桁の氏名コードを入力してください");
            /* FALSEを返してフォームは送信しない */
            return false;
          }
          else
          {
            /* TRUEを返してフォーム送信 */
            return true;
          }
        }
      }
    </script>
<!--
    <B><p style=   "font-size:16px; position:absolute; left:12px; top:70px; left:20px; color: #c20000;">※個人別に設定した休業日は「有休・代休・早退」で登録してください。</p></B> 
-->
    <B><p style="font-size:16px; position:absolute; left:12px; top: 60px; color: #c20000;">更新情報：</p></B>
    <p style=   "font-size:16px; position:absolute; left:12px; top: 85px; left:20px; color: #c20000;">更新：Edge、Chromeに対応しました（IEモードへの切り替えは不要）</p>
    <p style=   "font-size:16px; position:absolute; left:12px; top:110px; left:20px; color: #000000;">追加：Xacti_遠隔_XBP_日立ビル個別仕様対応</p>
    <p style=   "font-size:16px; position:absolute; left:12px; top:135px; left:20px; color: #000000;">追加：OEM_GV社_NER3A_機構系開発[CET32_縦グリップ_機構系開発]</p>
    <p style=   "font-size:16px; position:absolute; left:12px; top:160px; left:20px; color: #000000;">追加：OEM_GV社_NER3A_回路系開発[CET32_縦グリップ_回路系開発]</p>
    <p style=   "font-size:16px; position:absolute; left:12px; top:185px; left:20px; color: #000000;">名称変更：Xacti_建設_UE10O→Xacti_建設_UE10U[フォクレコ(AI基板変更)]</p>
   
    <B><p style="font-size:13px; position:absolute; left:12px; top:250px; color: #000000;">注意事項：</p></B>
    <p style=   "font-size:13px; position:absolute; left:12px; top:270px; left:20px; color: #000000;">ブラウザはMicrosoft Edge、Google Chromeをご使用ください。（IEモードへの切り替えは不要）</p>
    <p style=   "font-size:13px; position:absolute; left:12px; top:290px; left:20px">ログイン後、部署名が異なる場合は<a href="https://teams.microsoft.com/l/channel/19%3A4WJMGM-cVNNI2RMfELwXiqBYWW7Bp-kPgKKeltMmN6Y1%40thread.tacv2/%E4%B8%80%E8%88%AC?groupId=897ff081-4025-4086-905f-10fa61e1b528&tenantId=52d3f7c5-0ee1-45a4-9404-acd57e38f44f">管理者</a>まで連絡をお願いします。<br></p>
    <p style=   "font-size:13px; position:absolute; left: 7px; top:310px; left:20px">※先頭の0を除く5桁の氏名コードを入力</p>
    <p style=   "font-size:13px; position:absolute; left:12px; top:330px; left:20px">　派遣社員はX00*****の*部5桁を入力</p>
    <p style=   "font-size:13px; position:absolute; left:12px; top:370px;"><a href="http://172.21.110.106/resource/実績収集システム_マニュアル.pdf" target="_blank">マニュアルを開く</a></p>
  </BODY>
</HTML>	
