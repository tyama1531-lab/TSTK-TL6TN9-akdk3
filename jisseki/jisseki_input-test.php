<?php
session_start();
  
  $DSN        = "Xacti_resource_database";	//データソース名
  $DBUSER     = "Xacti";					//ログインユーザー名
  $DBPASSWORD = "5346";						//パスワード
  
  //Accessデータベースに接続
  if (! $con = odbc_connect($DSN, $DBUSER, $DBPASSWORD)){
    // 詳細をログに残す（デバッグ用）。ブラウザには詳細を表示しない。
    $err_msg = "";
    if (function_exists('odbc_errormsg')) $err_msg = odbc_errormsg();
    $err_code = "";
    if (function_exists('odbc_error')) $err_code = odbc_error();
    $info = date('c') . "\tODBC_CONNECT_FAILED\tDSN={$DSN}\tuser=" . get_current_user() . "\tpid=" . getmypid() . "\tsapi=" . php_sapi_name() . "\terr=" . str_replace("\n"," ",$err_msg) . "\tcode=" . $err_code . "\tfile=" . __FILE__ . PHP_EOL;
    @file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'odbc_connect_error.log', $info, FILE_APPEND | LOCK_EX);
    // 本番同等の汎用エラーメッセージで終了（詳細はサーバログ参照）
    exit("アクセスエラー（しばらく時間を置いてから再度ログインをお願いします）");
  }

  // helper: execute ODBC with retry and logging to mitigate transient Access/ODBC errors
  function odbc_exec_with_retry($con, $sql, $maxRetries = 5, $initialDelayMs = 200)
  {
    $attempt = 0;
    $logfile = __DIR__ . DIRECTORY_SEPARATOR . 'odbc_retry.log';
    while ($attempt < $maxRetries) {
      $attempt++;
      $res = @odbc_exec($con, $sql);
      if ($res !== false) {
        return $res;
      }
      // log a short message for diagnostics
      $err = '';
      if (function_exists('odbc_errormsg')) {
        $err = odbc_errormsg($con);
      }
      $short = mb_substr($sql, 0, 200);
      $msg = date('c') . "\tattempt={$attempt}\terr=" . str_replace("\n", ' ', $err) . "\tsql=" . str_replace("\n", ' ', $short) . PHP_EOL;
      @file_put_contents($logfile, $msg, FILE_APPEND | LOCK_EX);
      // exponential backoff-ish sleep (ms -> us)
      usleep($initialDelayMs * 1000 * $attempt);
    }
    return false;
  }
  
//$name_code = $_POST['name_code'];
  $name_code = $_GET['code'];
  $Input_date = "'" . $_GET['indate'] . "'";
  $Update = $_GET['updt'];
  
  If ($Update==0)
  {
//    $am1_radio = $_GET['am1'];
//    $am2_radio = $_GET['am2'];
//    $am3_radio = $_GET['am3'];
//    $pm1_radio = $_GET['pm1'];
//    $pm2_radio = $_GET['pm2'];
//    $pm3_radio = $_GET['pm3'];
//    $ot1_radio = $_GET['ot1'];
//    $ot2_radio = $_GET['ot2'];
//    $am1_list  = $_GET['al1'];
//    $am2_list  = $_GET['al2'];
//    $am3_list  = $_GET['al3'];
//    $pm1_list  = $_GET['pl1'];
//    $pm2_list  = $_GET['pl2'];
//    $pm3_list  = $_GET['pl3'];
//    $ot1_list  = $_GET['ol1'];
//    $ot2_list  = $_GET['ol2'];
    
    if(isset($_COOKIE['moderadio0'])) $am1_radio = $_COOKIE['moderadio0']; else $am1_radio = 0;
    if(isset($_COOKIE['moderadio1'])) $am2_radio = $_COOKIE['moderadio1']; else $am2_radio = 0;
    if(isset($_COOKIE['moderadio2'])) $am3_radio = $_COOKIE['moderadio2']; else $am3_radio = 0;
    if(isset($_COOKIE['moderadio3'])) $pm1_radio = $_COOKIE['moderadio3']; else $pm1_radio = 0;
    if(isset($_COOKIE['moderadio4'])) $pm2_radio = $_COOKIE['moderadio4']; else $pm2_radio = 0;
    if(isset($_COOKIE['moderadio5'])) $pm3_radio = $_COOKIE['moderadio5']; else $pm3_radio = 0;
    if(isset($_COOKIE['moderadio6'])) $ot1_radio = $_COOKIE['moderadio6']; else $ot1_radio = 0;
    if(isset($_COOKIE['moderadio7'])) $ot2_radio = $_COOKIE['moderadio7']; else $ot2_radio = 0;
    
    if(isset($_COOKIE['modellist0'])) $am1_list = $_COOKIE['modellist0']; else $am1_list = 0;
    if(isset($_COOKIE['modellist1'])) $am2_list = $_COOKIE['modellist1']; else $am2_list = 0;
    if(isset($_COOKIE['modellist2'])) $am3_list = $_COOKIE['modellist2']; else $am3_list = 0;
    if(isset($_COOKIE['modellist3'])) $pm1_list = $_COOKIE['modellist3']; else $pm1_list = 0;
    if(isset($_COOKIE['modellist4'])) $pm2_list = $_COOKIE['modellist4']; else $pm2_list = 0;
    if(isset($_COOKIE['modellist5'])) $pm3_list = $_COOKIE['modellist5']; else $pm3_list = 0;
    if(isset($_COOKIE['modellist6'])) $ot1_list = $_COOKIE['modellist6']; else $ot1_list = 0;
    if(isset($_COOKIE['modellist7'])) $ot2_list = $_COOKIE['modellist7']; else $ot2_list = 0;
    
    if(isset($_COOKIE['timebox0'])) $am1_time = $_COOKIE['timebox0']; else $am1_time = 0;
    if(isset($_COOKIE['timebox1'])) $am2_time = $_COOKIE['timebox1']; else $am2_time = 0;
    if(isset($_COOKIE['timebox2'])) $am3_time = $_COOKIE['timebox2']; else $am3_time = 0;
    if(isset($_COOKIE['timebox3'])) $pm1_time = $_COOKIE['timebox3']; else $pm1_time = 0;
    if(isset($_COOKIE['timebox4'])) $pm2_time = $_COOKIE['timebox4']; else $pm2_time = 0;
    if(isset($_COOKIE['timebox5'])) $pm3_time = $_COOKIE['timebox5']; else $pm3_time = 0;
    if(isset($_COOKIE['timebox6'])) $ot1_time = $_COOKIE['timebox6']; else $ot1_time = 0;
    if(isset($_COOKIE['timebox7'])) $ot2_time = $_COOKIE['timebox7']; else $ot2_time = 0;
    
    if(isset($_COOKIE['timeboxflg0'])) $am1_time_flg = $_COOKIE['timeboxflg0']; else $am1_time_flg = 0;
    if(isset($_COOKIE['timeboxflg1'])) $am2_time_flg = $_COOKIE['timeboxflg1']; else $am2_time_flg = 0;
    if(isset($_COOKIE['timeboxflg2'])) $am3_time_flg = $_COOKIE['timeboxflg2']; else $am3_time_flg = 0;
    if(isset($_COOKIE['timeboxflg3'])) $pm1_time_flg = $_COOKIE['timeboxflg3']; else $pm1_time_flg = 0;
    if(isset($_COOKIE['timeboxflg4'])) $pm2_time_flg = $_COOKIE['timeboxflg4']; else $pm2_time_flg = 0;
    if(isset($_COOKIE['timeboxflg5'])) $pm3_time_flg = $_COOKIE['timeboxflg5']; else $pm3_time_flg = 0;
    if(isset($_COOKIE['timeboxflg6'])) $ot1_time_flg = $_COOKIE['timeboxflg6']; else $ot1_time_flg = 0;
    if(isset($_COOKIE['timeboxflg7'])) $ot2_time_flg = $_COOKIE['timeboxflg7']; else $ot2_time_flg = 0;
    
    if(isset($_COOKIE['clientlist0'])) $am1_cltlist = $_COOKIE['clientlist0']; else $am1_cltlist = 0;
    if(isset($_COOKIE['clientlist1'])) $am2_cltlist = $_COOKIE['clientlist1']; else $am2_cltlist = 0;
    if(isset($_COOKIE['clientlist2'])) $am3_cltlist = $_COOKIE['clientlist2']; else $am3_cltlist = 0;
    if(isset($_COOKIE['clientlist3'])) $pm1_cltlist = $_COOKIE['clientlist3']; else $pm1_cltlist = 0;
    if(isset($_COOKIE['clientlist4'])) $pm2_cltlist = $_COOKIE['clientlist4']; else $pm2_cltlist = 0;
    if(isset($_COOKIE['clientlist5'])) $pm3_cltlist = $_COOKIE['clientlist5']; else $pm3_cltlist = 0;
    if(isset($_COOKIE['clientlist6'])) $ot1_cltlist = $_COOKIE['clientlist6']; else $ot1_cltlist = 0;
    if(isset($_COOKIE['clientlist7'])) $ot2_cltlist = $_COOKIE['clientlist7']; else $ot2_cltlist = 0;
    
    if(isset($_COOKIE['aftmpchk0'])) $am1_aftmpchk = $_COOKIE['aftmpchk0']; else $am1_aftmpchk = 0;
    if(isset($_COOKIE['aftmpchk1'])) $am2_aftmpchk = $_COOKIE['aftmpchk1']; else $am2_aftmpchk = 0;
    if(isset($_COOKIE['aftmpchk2'])) $am3_aftmpchk = $_COOKIE['aftmpchk2']; else $am3_aftmpchk = 0;
    if(isset($_COOKIE['aftmpchk3'])) $pm1_aftmpchk = $_COOKIE['aftmpchk3']; else $pm1_aftmpchk = 0;
    if(isset($_COOKIE['aftmpchk4'])) $pm2_aftmpchk = $_COOKIE['aftmpchk4']; else $pm2_aftmpchk = 0;
    if(isset($_COOKIE['aftmpchk5'])) $pm3_aftmpchk = $_COOKIE['aftmpchk5']; else $pm3_aftmpchk = 0;
    if(isset($_COOKIE['aftmpchk6'])) $ot1_aftmpchk = $_COOKIE['aftmpchk6']; else $ot1_aftmpchk = 0;
    if(isset($_COOKIE['aftmpchk7'])) $ot2_aftmpchk = $_COOKIE['aftmpchk7']; else $ot2_aftmpchk = 0;
  }
  else
  {
    $am1_radio = 0;
    $am2_radio = 0;
    $am3_radio = 0;
    $pm1_radio = 0;
    $pm2_radio = 0;
    $pm3_radio = 0;
    $ot1_radio = 0;
    $ot2_radio = 0;
    
    $am1_list  = 0;
    $am2_list  = 0;
    $am3_list  = 0;
    $pm1_list  = 0;
    $pm2_list  = 0;
    $pm3_list  = 0;
    $ot1_list  = 0;
    $ot2_list  = 0;
    
    $am1_time  = 0;
    $am2_time  = 0;
    $am3_time  = 0;
    $pm1_time  = 0;
    $pm2_time  = 0;
    $pm3_time  = 0;
    $ot1_time  = 0;
    $ot2_time  = 0;
    
    $am1_time_flg = 0;
    $am2_time_flg = 0;
    $am3_time_flg = 0;
    $pm1_time_flg = 0;
    $pm2_time_flg = 0;
    $pm3_time_flg = 0;
    $ot1_time_flg = 0;
    $ot2_time_flg = 0;
    
    $am1_cltlist = 0;
    $am2_cltlist = 0;
    $am3_cltlist = 0;
    $pm1_cltlist = 0;
    $pm2_cltlist = 0;
    $pm3_cltlist = 0;
    $ot1_cltlist = 0;
    $ot2_cltlist = 0;
    
    $am1_aftmpchk = 0;
    $am2_aftmpchk = 0;
    $am3_aftmpchk = 0;
    $pm1_aftmpchk = 0;
    $pm2_aftmpchk = 0;
    $pm3_aftmpchk = 0;
    $ot1_aftmpchk = 0;
    $ot2_aftmpchk = 0;
  }
  
  //社員情報の読込み
  $sql_member = "SELECT * FROM T_Employee_list";
  if (@odbc_exec($con, $sql_member))
    $rst_member = odbc_exec($con, $sql_member);
  else{
    print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_member";
    exit;}
  
  $code_judge=0;
  while (odbc_fetch_row($rst_member))
  {
    If (odbc_result($rst_member, "employee_cd")==$name_code)
    {
      $employee_name = mb_convert_encoding(odbc_result($rst_member, "employee_name"), 'UTF8', 'SJIS-win');
      $dept_code = odbc_result($rst_member, "dept_cd");
      $code_judge = 1;
    }
  }
  
  odbc_free_result($rst_member);
  
  //不明
  If ($code_judge == 0)
  {
    $body_employee = "Databaseに氏名コードが登録されていません。<br>管理者までお問い合わせください。<br><br>";
    //Accessデータベースとの接続を解除
    odbc_close($con);
  }
  else
  {
    $month_data = substr($Input_date,1,2);
    $day_data   = substr($Input_date,3,2);
    $year_data  = substr($Input_date,5,4);
    $Indate = $month_data . "/" . $day_data . "/" . $year_data;
    
//  $sql_indata = "SELECT T_ResourceTB.Model_ID, T_ResourceTB.Employee_CD, T_ResourceTB.Dept_CD, T_ResourceTB.Position_CD, T_ResourceTB.Time_input, T_ResourceTB.FTE, T_ResourceTB.Work_time_CD, T_ResourceTB.Month_CD, T_ResourceTB.InputDate FROM T_ResourceTB WHERE (((T_ResourceTB.Employee_CD)=" . $name_code .") AND ((T_ResourceTB.InputDate)=#" . $Indate . "#))";
//  $sql_indata = "SELECT T_ResourceTB.Model_ID, T_ResourceTB.Employee_CD, T_ResourceTB.Dept_CD, T_ResourceTB.Position_CD, T_ResourceTB.Time_input, T_ResourceTB.FTE, T_ResourceTB.Time_input_flg, T_ResourceTB.Work_time_CD, T_ResourceTB.Month_CD, T_ResourceTB.InputDate FROM T_ResourceTB WHERE (((T_ResourceTB.Employee_CD)=" . $name_code .") AND ((T_ResourceTB.InputDate)=#" . $Indate . "#))";
//  $sql_indata = "SELECT T_ResourceTB.Model_ID, T_ResourceTB.Employee_CD, T_ResourceTB.Dept_CD, T_ResourceTB.Position_CD, T_ResourceTB.Time_input, T_ResourceTB.FTE, T_ResourceTB.Time_input_flg, T_ResourceTB.Work_time_CD, T_ResourceTB.Month_CD, T_ResourceTB.InputDate, T_ResourceTB.Client_CD, T_ResourceTB.AfterMp_task_check FROM T_ResourceTB WHERE (((T_ResourceTB.Employee_CD)=" . $name_code .") AND ((T_ResourceTB.InputDate)=#" . $Indate . "#))";
    $sql_indata = "SELECT T_ResourceTB.Model_ID, T_ResourceTB.Employee_CD, T_ResourceTB.Dept_CD, T_ResourceTB.Position_CD, T_ResourceTB.Time_input, T_ResourceTB.FTE, T_ResourceTB.Time_input_flg, T_ResourceTB.Work_time_CD, T_ResourceTB.Month_CD, T_ResourceTB.InputDate, T_ResourceTB.Client_CD, T_ResourceTB.AfterMp_task_check, T_ResourceTB.Slide_data_flg FROM T_ResourceTB WHERE (((T_ResourceTB.Employee_CD)=" . $name_code .") AND ((T_ResourceTB.InputDate)=#" . $Indate . "#) AND ((T_ResourceTB.Slide_data_flg)=False))";
    
    $rst_indata = odbc_exec_with_retry($con, $sql_indata);
    if ($rst_indata === false) {
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_indata";
      exit;
    }
    
    //機種リストの読込み
//  $sql_model_latest = "SELECT T_ResourceTB.Model_ID, Q_Oem_code.Client_code, Q_Model_list.model_code, Q_Model_list.Feature, T_ResourceTB.Employee_CD, Sum(T_ResourceTB.FTE) AS FTE_all FROM Q_Oem_code RIGHT JOIN (Q_Model_list RIGHT JOIN T_ResourceTB ON Q_Model_list.Model_ID = T_ResourceTB.Model_ID) ON Q_Oem_code.OEM_CD = Q_Model_list.OEM WHERE (((T_ResourceTB.InputDate)>=Date()-90) AND ((Q_Model_list.Common_task_check)=False)) GROUP BY T_ResourceTB.Model_ID, Q_Oem_code.Client_code, Q_Model_list.model_code, Q_Model_list.Feature, T_ResourceTB.Employee_CD HAVING (((T_ResourceTB.Employee_CD)=" . $name_code . ")) ORDER BY Sum(T_ResourceTB.FTE) DESC";
//    $sql_model_latest = "SELECT T_ResourceTB.Model_ID, Q_Oem_code.Client_code, Q_Model_list.model_code, Q_Model_list.Feature, T_ResourceTB.Employee_CD, Sum(T_ResourceTB.FTE) AS FTE_all FROM Q_Oem_code RIGHT JOIN (Q_Model_list RIGHT JOIN T_ResourceTB ON Q_Model_list.Model_ID = T_ResourceTB.Model_ID) ON Q_Oem_code.OEM_CD = Q_Model_list.OEM WHERE (((T_ResourceTB.InputDate)>=Date()-90) AND ((Q_Model_list.Common_task_check)=False) AND ((Q_Model_list.Supply_type)<>0)) GROUP BY T_ResourceTB.Model_ID, Q_Oem_code.Client_code, Q_Model_list.model_code, Q_Model_list.Feature, T_ResourceTB.Employee_CD HAVING (((T_ResourceTB.Employee_CD)=" . $name_code . ")) ORDER BY Sum(T_ResourceTB.FTE) DESC";
    $sql_model_latest = "SELECT T_ResourceTB.Model_ID, Q_Oem_code.Client_code, Q_Model_list_JiInput.model_code, Q_Model_list_JiInput.Feature, T_ResourceTB.Employee_CD, Sum(T_ResourceTB.FTE) AS FTE_all FROM Q_Oem_code RIGHT JOIN (Q_Model_list_JiInput RIGHT JOIN T_ResourceTB ON Q_Model_list_JiInput.Model_ID = T_ResourceTB.Model_ID) ON Q_Oem_code.OEM_CD = Q_Model_list_JiInput.OEM WHERE (((T_ResourceTB.InputDate)>=Date()-90) AND ((Q_Model_list_JiInput.Common_task_check)=False) AND ((Q_Model_list_JiInput.Supply_type)<>0)) GROUP BY T_ResourceTB.Model_ID, Q_Oem_code.Client_code, Q_Model_list_JiInput.model_code, Q_Model_list_JiInput.Feature, T_ResourceTB.Employee_CD HAVING (((T_ResourceTB.Employee_CD)=" . $name_code . ")) ORDER BY Sum(T_ResourceTB.FTE) DESC";
    $rst_model_latest = odbc_exec_with_retry($con, $sql_model_latest);
    if ($rst_model_latest === false) {
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_model_latest";
      exit;
    }
    
//  $sql_model_other  = "SELECT Q_Model_list.*, Q_Oem_code.Client_code, Q_Model_list.model_code, Q_Model_list.Overtime_check, Q_Model_list.Possibility FROM Q_Oem_code RIGHT JOIN Q_Model_list ON Q_Oem_code.OEM_CD = Q_Model_list.OEM WHERE (((Q_Model_list.Overtime_check)=True) AND ((Q_Model_list.Possibility)=1)) ORDER BY Q_Model_list.model_code";
//    $sql_model_other  = "SELECT Q_Model_list.*, Q_Oem_code.Client_code, Q_Model_list.model_code, Q_Model_list.Overtime_check, Q_Model_list.Possibility FROM Q_Oem_code RIGHT JOIN Q_Model_list ON Q_Oem_code.OEM_CD = Q_Model_list.OEM WHERE (((Q_Model_list.Overtime_check)=True)) ORDER BY Q_Model_list.model_code";
    $sql_model_other  = "SELECT Q_Model_list_JiInput.*, Q_Oem_code.Client_code, Q_Model_list_JiInput.model_code, Q_Model_list_JiInput.Overtime_check, Q_Model_list_JiInput.Possibility FROM Q_Oem_code RIGHT JOIN Q_Model_list_JiInput ON Q_Oem_code.OEM_CD = Q_Model_list_JiInput.OEM WHERE (((Q_Model_list_JiInput.Overtime_check)=True)) ORDER BY Q_Model_list_JiInput.model_code";
    
    
    $rst_model_other = odbc_exec_with_retry($con, $sql_model_other);
    if ($rst_model_other === false) {
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_model_other";
      exit;
    }
    
    
    $model_list = array();
    $model_id_list = array();
    $cnt = 1;
    $model_list[0] = "---";
    $model_id_list[0] = 0;
    while (odbc_fetch_row($rst_model_latest))
    {
      $feature_comment = mb_convert_encoding(odbc_result($rst_model_latest, "Feature"), 'UTF8', 'SJIS-win');
      if ($feature_comment == "")
        $feature_comment2 = "";
      else
        $feature_comment2 = "[" . $feature_comment . "]";
      
//      $model_list[$cnt] = mb_convert_encoding(odbc_result($rst_model_latest, "Client_code"), 'UTF8', 'SJIS-win') . "社　" . mb_convert_encoding(odbc_result($rst_model_latest, "model_code"), 'UTF8', 'SJIS-win') . "　" . $feature_comment2;
      $model_list[$cnt] = mb_convert_encoding(odbc_result($rst_model_latest, "model_code"), 'UTF8', 'SJIS-win') . "　" . $feature_comment2;
      $model_id_list[$cnt] = odbc_result($rst_model_latest, "Model_ID");
      $cnt += 1;
    }
    while (odbc_fetch_row($rst_model_other))
    {
      odbc_fetch_row($rst_model_latest, 0);
      $bAddModelJudge = False;
      while (odbc_fetch_row($rst_model_latest))
      {
        If (odbc_result($rst_model_latest, "Model_ID") == odbc_result($rst_model_other, "Model_ID"))
          $bAddModelJudge = True;
      }
      If ($bAddModelJudge == False)
      {
        $feature_comment = mb_convert_encoding(odbc_result($rst_model_other, "Feature"), 'UTF8', 'SJIS-win');
        if ($feature_comment == "")
          $feature_comment2 = "";
        else
          $feature_comment2 = "[" . $feature_comment . "]";
        
//        $model_list[$cnt] = mb_convert_encoding(odbc_result($rst_model_other, "Client_code"), 'UTF8', 'SJIS-win') . "社　" . mb_convert_encoding(odbc_result($rst_model_other, "model_code"), 'UTF8', 'SJIS-win') . "　" . $feature_comment2;
        $model_list[$cnt] = mb_convert_encoding(odbc_result($rst_model_other, "model_code"), 'UTF8', 'SJIS-win') . "　" . $feature_comment2;
        $model_id_list[$cnt] = odbc_result($rst_model_other, "Model_ID");
        $cnt += 1;
      }
    }
    odbc_free_result($rst_model_other);
    odbc_free_result($rst_model_latest);
    
    $model_list_cnt = $cnt;
    $json_model_list = json_encode($model_list);
    $json_model_id_list = json_encode($model_id_list);
    
    //共通業務リスト読込み
//    $sql_common = "SELECT T_Common_task_master.*, T_Common_task_master.Common_task_order FROM T_Common_task_master ORDER BY T_Common_task_master.Common_task_order";
    $sql_common = "SELECT T_Common_task_230601Rule.*, T_Common_task_230601Rule.Common_task_order FROM T_Common_task_230601Rule ORDER BY T_Common_task_230601Rule.Common_task_order";
    $rst_common = odbc_exec_with_retry($con, $sql_common);
    if ($rst_common === false) {
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_common";
      exit;
    }
    
    $common_list = array();
    $common_id_list = array();
    $cnt = 1;
    $common_list[0] = "---";
    $common_id_list[0] = 0;
    while (odbc_fetch_row($rst_common)) 
    {
      $common_list[$cnt] = mb_convert_encoding(odbc_result($rst_common, "Common_task"), 'UTF8', 'SJIS-win');
      $common_id_list[$cnt] = odbc_result($rst_common, "Model_ID");
      $cnt += 1;
    }
    odbc_free_result($rst_common);
    
    $common_list_cnt = $cnt;
    $json_common_list = json_encode($common_list);
    $json_common_id_list = json_encode($common_id_list);
    
    $sel_id_list = array();
    $nWorkCnt_am = 0;
    $nWorkCnt_pm = 0;
    $nWorkCnt_ot = 0;
    
    
    //OEMリスト読込み
    $sql_client = "SELECT Q_Client_list.* FROM Q_Client_list";
    $rst_client = odbc_exec_with_retry($con, $sql_client);
    if ($rst_client === false) {
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_client";
      exit;
    }
    
    $client_list = array();
    $client_id_list = array();
    $cnt = 1;
    $client_list[0] = "---";
    $client_id_list[0] = 0;
    while (odbc_fetch_row($rst_client)) 
    {
      $client_list[$cnt] = mb_convert_encoding(odbc_result($rst_client, "OEM"), 'UTF8', 'SJIS-win');
      $client_id_list[$cnt] = odbc_result($rst_client, "OEM_CD");
      $cnt += 1;
    }
    $client_list_cnt = $cnt;
    $json_client_list = json_encode($client_list);
    $json_client_id_list = json_encode($client_id_list);
    
    
    while (odbc_fetch_row($rst_indata))
    {
      $inmodel =  odbc_result($rst_indata, "Model_ID");
      $wroktimecd = odbc_result($rst_indata, "Work_time_CD");
      $dTimeValue = odbc_result($rst_indata, "Time_input");
      $bTimeflg   = odbc_result($rst_indata, "Time_input_flg");
      $bAftMpChk  = odbc_result($rst_indata, "AfterMp_task_check");
      $nClientCd  = odbc_result($rst_indata, "Client_CD");
      
      If ($wroktimecd==1) // AM
        $nWorkCnt_am += 1;
      elseif ($wroktimecd==2) // PM
        $nWorkCnt_pm += 1;
      else // Overtime
        $nWorkCnt_ot += 1;
      
      $sql_model_id = "SELECT Q_Model_list.Model_ID, Q_Model_list.Common_task_check FROM Q_Model_list WHERE (((Q_Model_list.Model_ID)=" . $inmodel . "))";
//      $sql_model_id = "SELECT Q_Model_list_JiInput.Model_ID, Q_Model_list_JiInput.Common_task_check FROM Q_Model_list_JiInput WHERE (((Q_Model_list_JiInput.Model_ID)=" . $inmodel . "))";
      $rst_model_id = odbc_exec_with_retry($con, $sql_model_id);
      if ($rst_model_id === false) {
        print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_model_id";
        exit;
      }
      
      $common_check = odbc_result($rst_model_id, "Common_task_check");
      odbc_free_result($rst_model_id);
      
      If ($common_check==1)
      {
//      $sql_model_list = "SELECT T_Common_task_master.*, T_Common_task_master.Common_task_order FROM T_Common_task_master ORDER BY T_Common_task_master.Common_task_order";
        for ($i=0; $i<$common_list_cnt; $i++)
          $sel_id_list[$i] = $common_id_list[$i];
        
        $model_loop = $common_list_cnt;
      }
      else
      {
//      $sql_model_list = "SELECT Q_Model_list.*, Q_Model_list.model_code, Q_Model_list.Overtime_check, Q_Model_list.Possibility FROM Q_Model_list WHERE (((Q_Model_list.Overtime_check)=True) AND ((Q_Model_list.Possibility)=1)) ORDER BY Q_Model_list.model_code";
        for ($i=0; $i<$model_list_cnt; $i++)
          $sel_id_list[$i] = $model_id_list[$i];
        
        $model_loop = $model_list_cnt;
      }
      
//    $rst_model_list = odbc_exec($con, $sql_model_list);
      $nModelCnt = 0;
//    while (odbc_fetch_row($rst_model_list))
      while($nModelCnt<$model_loop)
      {
        If ($sel_id_list[$nModelCnt] == $inmodel)
          break;
        $nModelCnt += 1;
      }
      
      $rst_client = odbc_exec_with_retry($con, $sql_client);
      if ($rst_client === false) {
        print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_client";
        exit;
      }
      
      $nClientCnt = 0;
      while(odbc_fetch_row($rst_client))
      {
        If ($nClientCd==odbc_result($rst_client, "OEM_CD") || $nClientCd==0)
          break;
        $nClientCnt += 1;
      }
      
      odbc_free_result($rst_client);
      
      If ($Update==1)
      {
        If ($wroktimecd==1 && $nWorkCnt_am==1)
        {
          $am1_radio=$common_check;
          $am1_list =$nModelCnt;
          If($nClientCd==0)
            $am1_cltlist = 0;
          else
            $am1_cltlist = $nClientCnt + 1;
          $am1_aftmpchk = $bAftMpChk;
          if($am1_list==0){$am1_time=0;} else {if($bTimeflg==false) $am1_time=0; else {$am1_time=$dTimeValue; $am1_time_flg=1;}}
        }
        if ($wroktimecd==1 && $nWorkCnt_am==2)
        {
          $am2_radio=$common_check;
          $am2_list =$nModelCnt;
          If($nClientCd==0)
            $am2_cltlist = 0;
          else
            $am2_cltlist = $nClientCnt + 1;
          $am2_aftmpchk = $bAftMpChk;
          if($am2_list==0){$am2_time=0;} else {if($bTimeflg==false) $am2_time=0; else {$am2_time=$dTimeValue; $am2_time_flg=1;}}
        }
        if ($wroktimecd==1 && $nWorkCnt_am==3)
        {
          $am3_radio=$common_check;
          $am3_list =$nModelCnt;
          If($nClientCd==0)
            $am3_cltlist = 0;
          else
            $am3_cltlist = $nClientCnt + 1;
          $am3_aftmpchk = $bAftMpChk;
          
          if($am3_list==0){$am3_time=0;} else {if($bTimeflg==false) $am3_time=0; else {$am3_time=$dTimeValue; $am3_time_flg=1;}}
        }
        if ($wroktimecd==2 && $nWorkCnt_pm==1)
        {
          $pm1_radio=$common_check;
          $pm1_list =$nModelCnt;
          If($nClientCd==0)
            $pm1_cltlist = 0;
          else
            $pm1_cltlist = $nClientCnt + 1;
          $pm1_aftmpchk = $bAftMpChk;
          if($pm1_list==0){$pm1_time=0;} else {if($bTimeflg==false) $pm1_time=0; else {$pm1_time=$dTimeValue; $pm1_time_flg=1;}}
        }
        if ($wroktimecd==2 && $nWorkCnt_pm==2)
        {
          $pm2_radio=$common_check;
          $pm2_list =$nModelCnt;
          If($nClientCd==0)
            $pm2_cltlist = 0;
          else
            $pm2_cltlist = $nClientCnt + 1;
          $pm2_aftmpchk = $bAftMpChk;
          if($pm2_list==0){$pm2_time=0;} else {if($bTimeflg==false) $pm2_time=0; else {$pm2_time=$dTimeValue; $pm2_time_flg=1;}}
        }
        if ($wroktimecd==2 && $nWorkCnt_pm==3)
        {
          $pm3_radio=$common_check;
          $pm3_list =$nModelCnt;
          If($nClientCd==0)
            $pm3_cltlist = 0;
          else
            $pm3_cltlist = $nClientCnt + 1;
          $pm3_aftmpchk = $bAftMpChk;
          if($pm3_list==0){$pm3_time=0;} else {if($bTimeflg==false) $pm3_time=0; else {$pm3_time=$dTimeValue; $pm3_time_flg=1;}}
        }
        if ($wroktimecd==3 && $nWorkCnt_ot==1)
        {
          $ot1_radio=$common_check;
          $ot1_list =$nModelCnt;
          If($nClientCd==0)
            $ot1_cltlist = 0;
          else
            $ot1_cltlist = $nClientCnt + 1;
          $ot1_aftmpchk = $bAftMpChk;
          if($ot1_list==0){$ot1_time=0;} else {if($bTimeflg==false) $ot1_time=0; else {$ot1_time=$dTimeValue; $ot1_time_flg=1;}}
        }
        if ($wroktimecd==3 && $nWorkCnt_ot==2)
        {
          $ot2_radio=$common_check;
          $ot2_list =$nModelCnt;
          If($nClientCd==0)
            $ot2_cltlist = 0;
          else
            $ot2_cltlist = $nClientCnt + 1;
          $ot2_aftmpchk = $bAftMpChk;
          if($ot2_list==0){$ot2_time=0;} else {if($bTimeflg==false) $ot2_time=0; else {$ot2_time=$dTimeValue; $ot2_time_flg=1;}}
        }
      }
    }
    
    odbc_free_result($rst_indata);
    
    $body_employee = "氏名： " . $employee_name . "<br>";
    
    //部署情報の読込み
    $sql_dept = "SELECT * FROM T_Official_dept_cd";
    $rst_dept = odbc_exec_with_retry($con, $sql_dept);
    if ($rst_dept === false) {
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_dept";
      exit;
    }
    
    $judge=0;
    while (odbc_fetch_row($rst_dept) Or $judge=0)
    {
       If (odbc_result($rst_dept, "Official_dept_CD")==$dept_code)
       {
         $dept_name = mb_convert_encoding(odbc_result($rst_dept, "Official_dept_name"), 'UTF8', 'SJIS-win');
         $judge = 1;
       }
    }
    odbc_free_result($rst_dept);
    
    $body_employee .= "所属： " . $dept_name . "<br><br>";
    
    
    //Accessデータベースとの接続を解除
    odbc_close($con);
  }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="jp">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>実績入力</title>
    <link rel="shortcut icon" href="favicon2.ico">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Fallbacks for intranet / IE-mode: load local copies if CDN blocked -->
    <script>
      if (typeof window.jQuery === 'undefined') {
        document.write('<script src="jquery/jquery.min.js"><\/script>');
      }
      // if jQuery UI not loaded (no $.datepicker), load local copies
      if (typeof $.datepicker === 'undefined') {
        // local paths: jisseki/jquery-ui/jquery-ui.min.js and jisseki/jquery-ui/jquery-ui.css
        document.write('<link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">');
        document.write('<script src="jquery-ui/jquery-ui.min.js"><\/script>');
      }
    </script>
    <script>
      $( function() {
    
        // set Japanese regional defaults if available
        try { if ($.datepicker && $.datepicker.regional && $.datepicker.regional['ja']) {
            $.datepicker.setDefaults($.datepicker.regional['ja']);
          }
        } catch(e) { /* ignore */ }
        // ensure consistent format
        if ($.datepicker) {
          $("#datepicker").datepicker({dateFormat: 'mm/dd/yy'});
        }
      });
    </script>
  </head>
  <body>
    
    <script>
      var code_judge = <?php echo $code_judge; ?>;
      if (code_judge == 0)
      {
        document.write('<?=$body_employee?>');
        document.write('<a href="mailto:tomohiro.yamamoto@xacti-co.com">管理者へ連絡</a>');
      }
      else
      {
        var tmpInputDate = <?php echo $Input_date; ?>;
        var month = tmpInputDate.substr(0,2);
        var day   = tmpInputDate.substr(2,2);
        var year  = tmpInputDate.substr(4,4);
        
        var today = month + "/" + day  + "/" + year;
        var Inputdate = month + day + year;
        
  // use type="text" so jQuery UI datepicker always attaches (IE/native date input can interfere)
  var input_doc = '<input type="text" name="date_picker" style="width:100px" value="' + today + '" id="datepicker" onchange="datepickerchange()"></p>'
        var input_namecode = '<input id="namecode" type="hidden" name="namecode" value="' + <?php echo $name_code; ?> + '" />'
        var am1   = <?php echo $am1_radio; ?>;
        var am2   = <?php echo $am2_radio; ?>;
        var am3   = <?php echo $am3_radio; ?>;
        var pm1   = <?php echo $pm1_radio; ?>;
        var pm2   = <?php echo $pm2_radio; ?>;
        var pm3   = <?php echo $pm3_radio; ?>;
        var ot1   = <?php echo $ot1_radio; ?>;
        var ot2   = <?php echo $ot2_radio; ?>;
        var al1   = <?php echo $am1_list; ?>;
        var al2   = <?php echo $am2_list; ?>;
        var al3   = <?php echo $am3_list; ?>;
        var pl1   = <?php echo $pm1_list; ?>;
        var pl2   = <?php echo $pm2_list; ?>;
        var pl3   = <?php echo $pm3_list; ?>;
        var ol1   = <?php echo $ot1_list; ?>;
        var ol2   = <?php echo $ot2_list; ?>;
        var amt1  = <?php echo $am1_time; ?>;
        var amt2  = <?php echo $am2_time; ?>;
        var amt3  = <?php echo $am3_time; ?>;
        var pmt1  = <?php echo $pm1_time; ?>;
        var pmt2  = <?php echo $pm2_time; ?>;
        var pmt3  = <?php echo $pm3_time; ?>;
        var ott1  = <?php echo $ot1_time; ?>;
        var ott2  = <?php echo $ot2_time; ?>;
        var amtf1 = <?php echo $am1_time_flg; ?>;
        var amtf2 = <?php echo $am2_time_flg; ?>;
        var amtf3 = <?php echo $am3_time_flg; ?>;
        var pmtf1 = <?php echo $pm1_time_flg; ?>;
        var pmtf2 = <?php echo $pm2_time_flg; ?>;
        var pmtf3 = <?php echo $pm3_time_flg; ?>;
        var ottf1 = <?php echo $ot1_time_flg; ?>;
        var ottf2 = <?php echo $ot2_time_flg; ?>;
        
        var bClient_am1 = "disabled";
        var bClient_am2 = "disabled";
        var bClient_am3 = "disabled";
        var bClient_pm1 = "disabled";
        var bClient_pm2 = "disabled";
        var bClient_pm3 = "disabled";
        var bClient_ot1 = "disabled";
        var bClient_ot2 = "disabled";
        
        if(am1==1 && (al1==1 || al1==2))
          bClient_am1 = "";
        if(am2==1 && (al2==1 || al2==2))
          bClient_am2 = "";
        if(am3==1 && (al3==1 || al3==2))
          bClient_am3 = "";
        if(pm1==1 && (pl1==1 || pl1==2))
          bClient_pm1 = "";
        if(pm2==1 && (pl2==1 || pl2==2))
          bClient_pm2 = "";
        if(pm3==1 && (pl3==1 || pl3==2))
          bClient_pm3 = "";
        if(ot1==1 && (ol1==1 || ol1==2))
          bClient_ot1 = "";
        if(ot2==1 && (ol2==1 || ol2==2))
          bClient_ot2 = "";
        
        if(amtf1==0) amt1="";
        if(amtf2==0) amt2="";
        if(amtf3==0) amt3="";
        if(pmtf1==0) pmt1="";
        if(pmtf2==0) pmt2="";
        if(pmtf3==0) pmt3="";
        if(ottf1==0) ott1="";
        if(ottf2==0) ott2="";
        
        var sRegJudge = "";
        var list_am1 = <?php echo $am1_list; ?>;
        var list_am2 = <?php echo $am2_list; ?>;
        var list_am3 = <?php echo $am3_list; ?>;
        var list_pm1 = <?php echo $pm1_list; ?>;
        var list_pm2 = <?php echo $pm2_list; ?>;
        var list_pm3 = <?php echo $pm3_list; ?>;
        if ( (list_am1==0 && list_am2==0 && list_am3==0) && (list_pm1==0 && list_pm2==0 && list_pm3==0) )
          sRegJudge = "disabled";
        else
          sRegJudge = "";
        
        document.write('<form id="fm_input" name="f_model_list" method="post" action="result.php?indate='+Inputdate+'&am1='+am1+'&am2='+am2+'&am3='+am3+'&pm1='+pm1+'&pm2='+pm2+'&pm3='+pm3+'&ot1='+ot1+'&ot2='+ot2+'&al1='+al1+'&al2='+al2+'&al3='+al3+'&pl1='+pl1+'&pl2='+pl2+'&pl3='+pl3+'&ol1='+ol1+'&ol2='+ol2+'">');
          document.write('<p>日付：');
          document.write(input_doc);
          document.write('<input type="submit" id="reg_button"    style="position:absolute; left:  5px; top:370px;" value="登録" onClick="return regist_data()"/>');
          document.write('<input type="button" id="un_reg_button" style="position:absolute; left:100px; top:370px;" value="実績抽出(期間)" onClick="registed_date_period()" />');
          document.write('<input type="button" id="un_reg_button" style="position:absolute; left:220px; top:370px;" value="実績抽出(機種)" onClick="registed_date_model()" />');
//          document.getElementById("reg_button").disabled = sRegJudge;
          document.write('<?=$body_employee?>');
          // MINIMAL_HIDE_PATCH: clientlist を CSS で非表示（最小変更）
          document.write('<style>select[id^="clientlist"]{display:none !important;}</style>');
          document.write('<label for="radio_model1" style="position:absolute; top:108px; left: 50px;">［機種］</label>');
          document.write('<label for="radio_model1" style="position:absolute; top:108px; left:105px;">［共通］</label>');
          document.write('<label for="radio_model1" style="position:absolute; top:108px; left:175px;">［時間］</label>');
          document.write('<label for="radio_model1" style="position:absolute; top:108px; left:265px;">［業務］</label>');
// HIDDEN_BY_PATCH: 非表示化（テスト） - アカウント列ラベル（非表示で出力、DOMは維持）
          document.write('<label for="radio_model1" style="position:absolute; top:108px; left:885px;">［アカウント］</label>');
          // move the '量産後の不具合対応' label closer to the modellist selects
          document.write('<label for="radio_model1" style="position:absolute; top:108px; left:835px;">［量産後の不具合対応］</label>');
          
          document.write('<label for="radio_model1" style="position:absolute; top: 90px; left:194px; color:#C00000; font-size:12px;">↓ [時間]を単位:hで入力（任意）できます。入力例は<a href="http://172.21.110.106/resource/時間入力例.pdf" target="_blank">こちら</a></label>');
          
          document.write('<input type="button" id="un_reg_button" style="position:absolute; left:160px; top:10px;" value="未登録日抽出" onClick="unregisted_date()" />');
          
          
          document.write('<p style="position:absolute; left:5px; top:111px;">午前：</p>');
          
          document.write('<input id="radio_model1_0" type="radio" name="radio_category_1" value="0" style="position:absolute; left: 74px; top:131px;" onchange="categorychange1()" <?php if($am1_radio==0){echo "checked";}?> />');
          document.write('<input id="radio_model1_1" type="radio" name="radio_category_1" value="1" style="position:absolute; left:117px; top:131px;" onchange="categorychange1()" <?php if($am1_radio==1){echo "checked";}?> />');
          document.write('<input type="text" id="timebox1" name="timebox1" style="position:absolute; left:187px; top:131px; width:43px; text-align:right;" value="' + amt1 + '" />'); document.write('<label for="radio_model1" style="position:absolute; top:131px; left:232px;">h</label>');
          document.write('<select id="modellist1" name="modellist1" style="margin-bottom:3px; position:absolute; top:131px; left:260px;" onchange="listchange1()"></select>');
// HIDDEN_BY_PATCH: 非表示化（テスト） - clientlist1（非表示で出力、DOMは維持）
          document.write('<select id="clientlist1" name="clientlist1" style="margin-bottom:3px; position:absolute; top:131px; left:880px;"' + bClient_am1 + '></select>');
          document.write('<input type="checkbox" id="after_mp_task1" name="after_mp_task1" value="1" style="position:absolute; left:910px; top:131px;" <?php if($am1_radio==1){echo "disabled";}?> <?php if($am1_aftmpchk==true){echo "checked";}?>>');
          
          document.write('<input id="radio_model2_0" type="radio" name="radio_category_2" value="0" style="position:absolute; left: 74px; top:154px;" onchange="categorychange2()" <?php if($am2_radio==0){echo "checked";}?> />');
          document.write('<input id="radio_model2_1" type="radio" name="radio_category_2" value="1" style="position:absolute; left:117px; top:154px;" onchange="categorychange2()" <?php if($am2_radio==1){echo "checked";}?> />');
          document.write('<input type="text" id="timebox2" name="timebox2" style="position:absolute; left:187px; top:154px; width:43px; text-align:right;" value="' + amt2 + '" />'); document.write('<label for="radio_model1" style="position:absolute; top:154px; left:232px;">h</label>');
          document.write('<select id="modellist2" name="modellist2" style="margin-bottom:3px; position:absolute; top:154px; left:260px;" onchange="listchange2()"></select>');
// HIDDEN_BY_PATCH: 非表示化（テスト） - clientlist2（非表示で出力、DOMは維持）
          document.write('<select id="clientlist2" name="clientlist2" style="margin-bottom:3px; position:absolute; top:154px; left:880px;"' + bClient_am2 + '></select>');
          document.write('<input type="checkbox" id="after_mp_task2" name="after_mp_task2" value="2" style="position:absolute; left:910px; top:154px;" <?php if($am2_radio==1){echo "disabled";}?> <?php if($am2_aftmpchk==true){echo "checked";}?>>');
          
          document.write('<input id="radio_model3_0" type="radio" name="radio_category_3" value="0" style="position:absolute; left: 74px; top:177px;" onchange="categorychange3()" <?php if($am3_radio==0){echo "checked";}?> />');
          document.write('<input id="radio_model3_1" type="radio" name="radio_category_3" value="1" style="position:absolute; left:117px; top:177px;" onchange="categorychange3()" <?php if($am3_radio==1){echo "checked";}?> />');
          document.write('<input type="text" id="timebox3" name="timebox3" style="position:absolute; left:187px; top:177px; width:43px; text-align:right;" value="' + amt3 + '" />'); document.write('<label for="radio_model1" style="position:absolute; top:177px; left:232px;">h</label>');
          document.write('<select id="modellist3" name="modellist3" style="margin-bottom:3px; position:absolute; top:177px; left:260px;" onchange="listchange3()"></select>');
// HIDDEN_BY_PATCH: 非表示化（テスト） - clientlist3（非表示で出力、DOMは維持）
          document.write('<select id="clientlist3" name="clientlist3" style="margin-bottom:3px; position:absolute; top:177px; left: 880px;"' + bClient_am3 + '></select>');
          document.write('<input type="checkbox" id="after_mp_task3" name="after_mp_task3" value="3" style="position:absolute; left:910px; top:177px;" <?php if($am3_radio==1){echo "disabled";}?> <?php if($am3_aftmpchk==true){echo "checked";}?>>');
          
          
          document.write('<p style="position:absolute; left:5px; top:205px;">午後：</p>');
          
          
          document.write('<input id="radio_model4_0" type="radio" name="radio_category_4" value="0" style="position:absolute; left: 74px; top:224px;" onchange="categorychange4()" <?php if($pm1_radio==0){echo "checked";}?> />');
          document.write('<input id="radio_model4_1" type="radio" name="radio_category_4" value="1" style="position:absolute; left:117px; top:224px;" onchange="categorychange4()" <?php if($pm1_radio==1){echo "checked";}?> />');
          document.write('<input type="text" id="timebox4" name="timebox4" style="position:absolute; left:187px; top:224px; width:43px; text-align:right;" value="' + pmt1 + '" />'); document.write('<label for="radio_model1" style="position:absolute; top:224px; left:232px;">h</label>');
          document.write('<select id="modellist4" name="modellist4" style="margin-bottom:3px; position:absolute; top:224px; left:260px;" onchange="listchange4()"></select>');
// HIDDEN_BY_PATCH: 非表示化（テスト） - clientlist4（非表示で出力、DOMは維持）
          document.write('<select id="clientlist4" name="clientlist4" style="margin-bottom:3px; position:absolute; top:224px; left:880px;"' + bClient_pm1 + '></select>');
          document.write('<input type="checkbox" id="after_mp_task4" name="after_mp_task4" value="4" style="position:absolute; left:910px; top:224px;" <?php if($pm1_radio==1){echo "disabled";}?> <?php if($pm1_aftmpchk==true){echo "checked";}?>>');
          
          document.write('<input id="radio_model5_0" type="radio" name="radio_category_5" value="0" style="position:absolute; left: 74px; top:247px;" onchange="categorychange5()" <?php if($pm2_radio==0){echo "checked";}?> />');
          document.write('<input id="radio_model5_1" type="radio" name="radio_category_5" value="1" style="position:absolute; left:117px; top:247px;" onchange="categorychange5()" <?php if($pm2_radio==1){echo "checked";}?> />');
          document.write('<input type="text" id="timebox5" name="timebox5" style="position:absolute; left:187px; top:247px; width:43px; text-align:right;" value="' + pmt2 + '" />'); document.write('<label for="radio_model1" style="position:absolute; top:247px; left:232px;">h</label>');
          document.write('<select id="modellist5" name="modellist5" style="margin-bottom:3px; position:absolute; top:247px; left:260px;" onchange="listchange5()"></select>');
// HIDDEN_BY_PATCH: 非表示化（テスト） - clientlist5（非表示で出力、DOMは維持）
          document.write('<select id="clientlist5" name="clientlist5" style="margin-bottom:3px; position:absolute; top:247px; left:880px;"' + bClient_pm2 + '></select>');
          document.write('<input type="checkbox" id="after_mp_task5" name="after_mp_task5" value="5" style="position:absolute; left:910px; top:247px;" <?php if($pm2_radio==1){echo "disabled";}?> <?php if($pm2_aftmpchk==true){echo "checked";}?>>');
          
          document.write('<input id="radio_model6_0" type="radio" name="radio_category_6" value="0" style="position:absolute; left: 74px; top:270px;" onchange="categorychange6()" <?php if($pm3_radio==0){echo "checked";}?> />');
          document.write('<input id="radio_model6_1" type="radio" name="radio_category_6" value="1" style="position:absolute; left:117px; top:270px;" onchange="categorychange6()" <?php if($pm3_radio==1){echo "checked";}?> />');
          document.write('<input type="text" id="timebox6" name="timebox6" style="position:absolute; left:187px; top:270px; width:43px; text-align:right;" value="' + pmt3 + '" />'); document.write('<label for="radio_model1" style="position:absolute; top:270px; left:232px;">h</label>');
          document.write('<select id="modellist6" name="modellist6" style="margin-bottom:3px; position:absolute; top:270px; left:260px;" onchange="listchange6()"></select>');
// HIDDEN_BY_PATCH: 非表示化（テスト） - clientlist6（非表示で出力、DOMは維持）
          document.write('<select id="clientlist6" name="clientlist6" style="margin-bottom:3px; position:absolute; top:270px; left:880px;"' + bClient_pm3 + '></select>');
          document.write('<input type="checkbox" id="after_mp_task6" name="after_mp_task6" value="6" style="position:absolute; left:910px; top:270px;" <?php if($pm3_radio==1){echo "disabled";}?> <?php if($pm3_aftmpchk==true){echo "checked";}?>>');
          
          
          document.write('<p style="position:absolute; left:5px; top:297px;">残業：</p>');
          
          
          document.write('<input id="radio_model7_0" type="radio" name="radio_category_7" value="0" style="position:absolute; left: 74px; top:317px;" onchange="categorychange7()" <?php if($ot1_radio==0){echo "checked";}?> />');
          document.write('<input id="radio_model7_1" type="radio" name="radio_category_7" value="1" style="position:absolute; left:117px; top:317px;" onchange="categorychange7()" <?php if($ot1_radio==1){echo "checked";}?> />');
          document.write('<input type="text" id="timebox7" name="timebox7" style="position:absolute; left:187px; top:317px; width:43px; text-align:right;" value="' + ott1 + '" />'); document.write('<label for="radio_model1" style="position:absolute; top:317px; left:232px;">h</label>');
          document.write('<select id="modellist7" name="modellist7" style="margin-bottom:3px; position:absolute; top:317px; left:260px;" onchange="listchange7()"></select>');
// HIDDEN_BY_PATCH: 非表示化（テスト） - clientlist7（非表示で出力、DOMは維持）
          document.write('<select id="clientlist7" name="clientlist7" style="margin-bottom:3px; position:absolute; top:317px; left:880px;"' + bClient_ot1 + '></select>');
          document.write('<input type="checkbox" id="after_mp_task7" name="after_mp_task7" value="7" style="position:absolute; left:910px; top:317px;" <?php if($ot1_radio==1){echo "disabled";}?> <?php if($ot1_aftmpchk==true){echo "checked";}?>>');
          
          document.write('<input id="radio_model8_0" type="radio" name="radio_category_8" value="0" style="position:absolute; left: 74px; top:340px;" onchange="categorychange8()" <?php if($ot2_radio==0){echo "checked";}?> />');
          document.write('<input id="radio_model8_1" type="radio" name="radio_category_8" value="1" style="position:absolute; left:117px; top:340px;" onchange="categorychange8()" <?php if($ot2_radio==1){echo "checked";}?> />');
          document.write('<input type="text" id="timebox8" name="timebox8" style="position:absolute; left:187px; top:340px; width:43px; text-align:right;" value="' + ott2 + '" />'); document.write('<label for="radio_model1" style="position:absolute; top:340px; left:232px;">h</label>');
          document.write('<select id="modellist8" name="modellist8" style="margin-bottom:3px; position:absolute; top:340px; left:260px;" onchange="listchange8()"></select>');
// HIDDEN_BY_PATCH: 非表示化（テスト） - clientlist8（非表示で出力、DOMは維持）
          document.write('<select id="clientlist8" name="clientlist8" style="margin-bottom:3px; position:absolute; top:340px; left:880px;"' + bClient_ot2 + '></select>');
          document.write('<input type="checkbox" id="after_mp_task8" name="after_mp_task8" value="8" style="position:absolute; left:910px; top:340px;" <?php if($ot2_radio==1){echo "disabled";}?> <?php if($ot2_aftmpchk==true){echo "checked";}?>>');
          
          document.write(input_namecode);
          
  document.write('</form>');
  
  
      }
    </script>
    
    <!-- Fix: modellist selects fixed width after selection, show full on focus and set title for tooltip -->
    <script>
      (function(){
        function applyFixedWidth(px){
          try{
            var sels = document.querySelectorAll('select[id^="modellist"]');
            for(var i=0;i<sels.length;i++){
              var s = sels[i];
              // set initial fixed width
              s.style.width = px + 'px';
              // set tooltip to full text
              try{ if(s.options && s.selectedIndex>=0) s.title = s.options[s.selectedIndex].text; }catch(e){}
              // update title on change
              s.addEventListener('change', (function(sel){ return function(){ try{ sel.title = sel.options[sel.selectedIndex].text; }catch(e){} }; })(s), false);
              // expand width when focused (so user can see more when opening)
              s.addEventListener('focus', (function(sel,pxv){ return function(){ try{ sel.style.width = 'auto'; }catch(e){} }; })(s,px), false);
              // restore fixed width on blur
              s.addEventListener('blur', (function(sel,pxv){ return function(){ try{ sel.style.width = pxv + 'px'; }catch(e){} }; })(s,px), false);
            }
          }catch(e){}
        }
    if(window.addEventListener) window.addEventListener('load', function(){ applyFixedWidth(500); }, false);
    else window.attachEvent('onload', function(){ applyFixedWidth(500); });
      })();
    </script>

    <div style="position:absolute; left:10px; top:420px; font-size:14px;">※機種リストへの追加や不具合は<a href="https://teams.microsoft.com/l/channel/19%3A4WJMGM-cVNNI2RMfELwXiqBYWW7Bp-kPgKKeltMmN6Y1%40thread.tacv2/%E4%B8%80%E8%88%AC?groupId=897ff081-4025-4086-905f-10fa61e1b528&tenantId=52d3f7c5-0ee1-45a4-9404-acd57e38f44f">管理者</a>までご連絡ください。</div>
    <div style="position:absolute; left:10px; top:445px; font-size:14px;"><u>登録手順</u></div>
    <div style="position:absolute; left:15px; top:465px; font-size:14px;">1) 日付で登録日を選択(初期値は本日)　※日付を変更することで過去入力データが表示されます</div>
    <div style="position:absolute; left:15px; top:485px; font-size:14px;">2) 午前,午後,残業時間それぞれで［機種］or［共通］業務を選択</div>
    <div style="position:absolute; left:15px; top:505px; font-size:14px;">3) ドロップダウンリストから機種 or 共通業務を選択（午前,午後は最低1項目を選択）</div>
    <div style="position:absolute; left:15px; top:525px; font-size:14px; color:#C00000;">4) 必要に応じて[時間]を単位:hで入力（任意）　※<a href="http://172.21.110.106/resource/時間入力例.pdf" target="_blank">入力例</a>を参照ください</div>
    <div style="position:absolute; left:15px; top:545px; font-size:14px;">5) 登録ボタンを押して完了</div>
    <div style="position:absolute; left:10px; top:570px; font-size:14px;"><u>注意事項</u></div>
    <div style="position:absolute; left:15px; top:590px; font-size:14px;">・同日で複数回登録しても、最後のデータで上書きされます</div>
    <div style="position:absolute; left:15px; top:620px; font-size:14px;">・有休の場合は共通→有休を選択してください（全休の場合は午前,午後ともに有休を設定）</div>
    <div style="position:absolute; left:15px; top:640px; font-size:14px;"><a href="http://172.21.110.106/resource/実績収集システム_マニュアル.pdf" target="_blank">マニュアルを開く</a></div>

    <script type="text/javascript">
      // グローバルにPHP生成のJSON配列を割当（IEモードでの文字列埋め込み問題を回避）
      var commonidlist  = <?php echo  $json_common_id_list; ?>;
      var commonlist    = <?php echo  $json_common_list; ?>;
      var modelidlist   = <?php echo  $json_model_id_list; ?>;
      var modellist     = <?php echo  $json_model_list; ?>;
      var clientidlist  = <?php echo  $json_client_id_list; ?>;
      var clientlist    = <?php echo  $json_client_list; ?>;

      function regist_data()
      {
        var limityear  = 2025;
        var limitmonth = 10;
        var limitday   = 1;
        
        var limitdaycode = limityear * 12 * 31 + limitmonth * 31 + limitday * 1;
        
    // (modellist 等はグローバル変数として上部で定義済み)
        
        var model_list_no = new Array(8);
        var model_id_list = new Array(8);
        var client_list_no = new Array(8);
        var client_id_list = new Array(8);
        var after_mp_task = new Array(8);
        
        var timebox = new Array(8);
        var timebox_flg = new Array(8);
        
        var radio_model = new Array(8);
        var indate = <?php echo $Input_date; ?>;
        
        var inmonth = indate.substr(0,2);
        var inday   = indate.substr(2,2);
        var inyear  = indate.substr(4,4);
        var indaycode = inyear * 12 * 31 + inmonth * 31 + inday * 1;
        
        
        if(indaycode < limitdaycode)
        {
          alert("指定した日付は工数登録締め日を過ぎているため登録できません。\n登録必要な場合は管理者までご連絡ください。\n\n登録可能日:" + limityear + "年" + limitmonth + "月" + limitday + "日以降");
          return false;
        }
        
        
        var hiduke = new Date();
        var toyear  = hiduke.getFullYear();
        var tomonth = hiduke.getMonth()+1;
        var today   = hiduke.getDate();
        var todaycode = toyear * 12 * 31 + tomonth * 31 + today;
        
        var regist_flg = false;
        var listin_flg = false;
        var clientin_flg = true;
        
        model_list_no[0] = document.forms.f_model_list.modellist1.selectedIndex;
        model_list_no[1] = document.forms.f_model_list.modellist2.selectedIndex;
        model_list_no[2] = document.forms.f_model_list.modellist3.selectedIndex;
        model_list_no[3] = document.forms.f_model_list.modellist4.selectedIndex;
        model_list_no[4] = document.forms.f_model_list.modellist5.selectedIndex;
        model_list_no[5] = document.forms.f_model_list.modellist6.selectedIndex;
        model_list_no[6] = document.forms.f_model_list.modellist7.selectedIndex;
        model_list_no[7] = document.forms.f_model_list.modellist8.selectedIndex;
        
        client_list_no[0] = document.forms.f_model_list.clientlist1.selectedIndex;
        client_list_no[1] = document.forms.f_model_list.clientlist2.selectedIndex;
        client_list_no[2] = document.forms.f_model_list.clientlist3.selectedIndex;
        client_list_no[3] = document.forms.f_model_list.clientlist4.selectedIndex;
        client_list_no[4] = document.forms.f_model_list.clientlist5.selectedIndex;
        client_list_no[5] = document.forms.f_model_list.clientlist6.selectedIndex;
        client_list_no[6] = document.forms.f_model_list.clientlist7.selectedIndex;
        client_list_no[7] = document.forms.f_model_list.clientlist8.selectedIndex;
        
        after_mp_task[0] = document.getElementById('after_mp_task1').checked;
        after_mp_task[1] = document.getElementById('after_mp_task2').checked;
        after_mp_task[2] = document.getElementById('after_mp_task3').checked;
        after_mp_task[3] = document.getElementById('after_mp_task4').checked;
        after_mp_task[4] = document.getElementById('after_mp_task5').checked;
        after_mp_task[5] = document.getElementById('after_mp_task6').checked;
        after_mp_task[6] = document.getElementById('after_mp_task7').checked;
        after_mp_task[7] = document.getElementById('after_mp_task8').checked;
        
        
        var isnum_check = 0;
        if(document.forms.f_model_list.timebox1.value=="" || document.forms.f_model_list.timebox1.value.match(/^[+]?([1-9]\d*|0)(\.\d+)?$/)) isnum_check=1;
        if(document.forms.f_model_list.timebox2.value=="" || document.forms.f_model_list.timebox2.value.match(/^[+]?([1-9]\d*|0)(\.\d+)?$/)) isnum_check=1;
        if(document.forms.f_model_list.timebox3.value=="" || document.forms.f_model_list.timebox3.value.match(/^[+]?([1-9]\d*|0)(\.\d+)?$/)) isnum_check=1;
        if(document.forms.f_model_list.timebox4.value=="" || document.forms.f_model_list.timebox4.value.match(/^[+]?([1-9]\d*|0)(\.\d+)?$/)) isnum_check=1;
        if(document.forms.f_model_list.timebox5.value=="" || document.forms.f_model_list.timebox5.value.match(/^[+]?([1-9]\d*|0)(\.\d+)?$/)) isnum_check=1;
        if(document.forms.f_model_list.timebox6.value=="" || document.forms.f_model_list.timebox6.value.match(/^[+]?([1-9]\d*|0)(\.\d+)?$/)) isnum_check=1;
        if(document.forms.f_model_list.timebox7.value=="" || document.forms.f_model_list.timebox7.value.match(/^[+]?([1-9]\d*|0)(\.\d+)?$/)) isnum_check=1;
        if(document.forms.f_model_list.timebox8.value=="" || document.forms.f_model_list.timebox8.value.match(/^[+]?([1-9]\d*|0)(\.\d+)?$/)) isnum_check=1;
        
        timebox[0] = Number(document.forms.f_model_list.timebox1.value);
        timebox[1] = Number(document.forms.f_model_list.timebox2.value);
        timebox[2] = Number(document.forms.f_model_list.timebox3.value);
        timebox[3] = Number(document.forms.f_model_list.timebox4.value);
        timebox[4] = Number(document.forms.f_model_list.timebox5.value);
        timebox[5] = Number(document.forms.f_model_list.timebox6.value);
        timebox[6] = Number(document.forms.f_model_list.timebox7.value);
        timebox[7] = Number(document.forms.f_model_list.timebox8.value);
        
        if(timebox[0]=="") {timebox[0]=0; timebox_flg[0]=false;}else{timebox_flg[0]=true;}
        if(timebox[1]=="") {timebox[1]=0; timebox_flg[1]=false;}else{timebox_flg[1]=true;}
        if(timebox[2]=="") {timebox[2]=0; timebox_flg[2]=false;}else{timebox_flg[2]=true;}
        if(timebox[3]=="") {timebox[3]=0; timebox_flg[3]=false;}else{timebox_flg[3]=true;}
        if(timebox[4]=="") {timebox[4]=0; timebox_flg[4]=false;}else{timebox_flg[4]=true;}
        if(timebox[5]=="") {timebox[5]=0; timebox_flg[5]=false;}else{timebox_flg[5]=true;}
        if(timebox[6]=="") {timebox[6]=0; timebox_flg[6]=false;}else{timebox_flg[6]=true;}
        if(timebox[7]=="") {timebox[7]=0; timebox_flg[7]=false;}else{timebox_flg[7]=true;}
        
        var timebox_sum_am = timebox[0] + timebox[1] + timebox[2];
        var timebox_sum_pm = timebox[3] + timebox[4] + timebox[5];
        var timebox_sum_ot = timebox[6] + timebox[7];
        
        if(isnum_check==0)
        {
          alert("時間は正の半角数値で入力してください");
          return false;
        }
        else
        {
          if(model_list_no[0]==0 && model_list_no[1]==0 && model_list_no[2]==0 && model_list_no[3]==0 && model_list_no[4]==0 && model_list_no[5]==0 && model_list_no[6]==0 && model_list_no[7]==0)
          {
            alert("業務を選択してください。");
          }
          else
          {
            if( (model_list_no[0]==0&&timebox[0]!=0) || (model_list_no[1]==0&&timebox[1]!=0) || (model_list_no[2]==0&&timebox[2]!=0) || (model_list_no[3]==0&&timebox[3]!=0) || (model_list_no[4]==0&&timebox[4]!=0) || (model_list_no[5]==0&&timebox[5]!=0) || (model_list_no[6]==0&&timebox[6]!=0) || (model_list_no[7]==0&&timebox[7]!=0) )
            {
              alert("[業務]リスト未選択項目に時間がセットされています。");
              regist_flg = false;
            }
            else
            {
              if( (model_list_no[6]!=0 && model_list_no[7]!=0 ) && ( (timebox[6]==0 && timebox[7]!=0) || (timebox[6]!=0 && timebox[7]==0) ))
              {
                alert("残業は、2項とも時間入力有り or 時間入力無しに統一してください")
                regist_flg = false;
              }
              else
                listin_flg = true;
            }
          }
          
          
          if(listin_flg==true)
          {
            if(timebox_sum_am > 3 || timebox_sum_pm > 4.75)
            {
              alert("合計時間は、午前 3.0h・午後 4.75h以内で入力してください");
              regist_flg = false;
            }
            else
            {
              if(timebox_sum_ot <= 2)
              {
                if(todaycode < indaycode)
                {
                  if(confirm("明日以降の日付を登録しようとしています\n続けますか？"))
                    regist_flg = true;
                  else
                    regist_flg = false;
                }
                else
                  regist_flg = true;
              }
              else
              {
                if(confirm("残業時間が合計2h以上入力されています\n続けますか？"))
                {
                  if(todaycode < indaycode)
                  {
                    if(confirm("明日以降の日付を登録しようとしています\n続けますか？"))
                      regist_flg = true;
                    else
                      regist_flg = false;
                  }
                  else
                    regist_flg = true;
                }
                else
                  regist_flg = false;
              }
            }
            
            if (document.forms.f_model_list.radio_model1_1.checked)
            {
              model_id_list[0] = commonidlist[model_list_no[0]];
              if( (model_id_list[0]==174 || model_id_list[0]==175) && client_list_no[0]==0 )
                clientin_flg = false;
            }
            if (document.forms.f_model_list.radio_model2_1.checked)
            {
              model_id_list[1] = commonidlist[model_list_no[1]];
              if( (model_id_list[1]==174 || model_id_list[1]==175) && client_list_no[1]==0 )
                clientin_flg = false;
            }
            if (document.forms.f_model_list.radio_model3_1.checked)
            {
              model_id_list[2] = commonidlist[model_list_no[2]];
              if( (model_id_list[2]==174 || model_id_list[2]==175) && client_list_no[2]==0 )
                clientin_flg = false;
            }
            if (document.forms.f_model_list.radio_model4_1.checked)
            {
              model_id_list[3] = commonidlist[model_list_no[3]];
              if( (model_id_list[3]==174 || model_id_list[3]==175) && client_list_no[3]==0 )
                clientin_flg = false;
            }
            if (document.forms.f_model_list.radio_model5_1.checked)
            {
              model_id_list[4] = commonidlist[model_list_no[4]];
              if( (model_id_list[4]==174 || model_id_list[4]==175) && client_list_no[4]==0 )
                clientin_flg = false;
            }
            if (document.forms.f_model_list.radio_model6_1.checked)
            {
              model_id_list[5] = commonidlist[model_list_no[5]];
              if( (model_id_list[5]==174 || model_id_list[5]==175) && client_list_no[5]==0 )
                clientin_flg = false;
            }
            if (document.forms.f_model_list.radio_model7_1.checked)
            {
              model_id_list[6] = commonidlist[model_list_no[6]];
              if( (model_id_list[6]==174 || model_id_list[6]==175) && client_list_no[6]==0 )
                clientin_flg = false;
            }
            if (document.forms.f_model_list.radio_model8_1.checked)
            {
              model_id_list[7] = commonidlist[model_list_no[7]];
              if( (model_id_list[7]==174 || model_id_list[7]==175) && client_list_no[7]==0 )
                clientin_flg = false;
            }
            
            if(clientin_flg == false)
            {
              alert("開発費･コスト見積り、先行開発･商材開発･商品提案の場合は\nアカウントを指定してください");
              regist_flg = false;
            }
          }
          
          
          
          if (regist_flg == true)
          {
            if (document.forms.f_model_list.radio_model1_0.checked)
            {
              model_id_list[0] = modelidlist [model_list_no[0]];
              radio_model[0] = 0;
            }
            else
            {
              model_id_list[0] = commonidlist[model_list_no[0]];
              radio_model[0] = 1;
            }
            if (document.forms.f_model_list.radio_model2_0.checked)
            {
              model_id_list[1] = modelidlist [model_list_no[1]];
              radio_model[1] = 0;
            }
            else
            {
              model_id_list[1] = commonidlist[model_list_no[1]];
              radio_model[1] = 1;
            }
            if (document.forms.f_model_list.radio_model3_0.checked)
            {
              model_id_list[2] = modelidlist [model_list_no[2]];
              radio_model[2] = 0;
            }
            else
            {
              model_id_list[2] = commonidlist[model_list_no[2]];
              radio_model[2] = 1;
            }
            if (document.forms.f_model_list.radio_model4_0.checked)
            {
              model_id_list[3] = modelidlist [model_list_no[3]];
              radio_model[3] = 0;
            }
            else
            {
              model_id_list[3] = commonidlist[model_list_no[3]];
              radio_model[3] = 1;
            }
            if (document.forms.f_model_list.radio_model5_0.checked)
            {
              model_id_list[4] = modelidlist [model_list_no[4]];
              radio_model[4] = 0;
            }
            else
            {
              model_id_list[4] = commonidlist[model_list_no[4]];
              radio_model[4] = 1;
            }
            if (document.forms.f_model_list.radio_model6_0.checked)
            {
              model_id_list[5] = modelidlist [model_list_no[5]];
              radio_model[5] = 0;
            }
            else
            {
              model_id_list[5] = commonidlist[model_list_no[5]];
              radio_model[5] = 1;
            }
            if (document.forms.f_model_list.radio_model7_0.checked)
            {
              model_id_list[6] = modelidlist [model_list_no[6]];
              radio_model[6] = 0;
            }
            else
            {
              model_id_list[6] = commonidlist[model_list_no[6]];
              radio_model[6] = 1;
            }
            if (document.forms.f_model_list.radio_model8_0.checked)
            {
              model_id_list[7] = modelidlist [model_list_no[7]];
              radio_model[7] = 0;
            }
            else
            {
              model_id_list[7] = commonidlist[model_list_no[7]];
              radio_model[7] = 1;
            }
            
            client_id_list[0] = clientidlist [client_list_no[0]];
            client_id_list[1] = clientidlist [client_list_no[1]];
            client_id_list[2] = clientidlist [client_list_no[2]];
            client_id_list[3] = clientidlist [client_list_no[3]];
            client_id_list[4] = clientidlist [client_list_no[4]];
            client_id_list[5] = clientidlist [client_list_no[5]];
            client_id_list[6] = clientidlist [client_list_no[6]];
            client_id_list[7] = clientidlist [client_list_no[7]];
            
            document.cookie = 'modelid0=' + model_id_list[0];
            document.cookie = 'modelid1=' + model_id_list[1];
            document.cookie = 'modelid2=' + model_id_list[2];
            document.cookie = 'modelid3=' + model_id_list[3];
            document.cookie = 'modelid4=' + model_id_list[4];
            document.cookie = 'modelid5=' + model_id_list[5];
            document.cookie = 'modelid6=' + model_id_list[6];
            document.cookie = 'modelid7=' + model_id_list[7];
            
//            document.cookie = 'modellist0=' + model_list_no[0];
//            document.cookie = 'modellist1=' + model_list_no[1];
//            document.cookie = 'modellist2=' + model_list_no[2];
//            document.cookie = 'modellist3=' + model_list_no[3];
//            document.cookie = 'modellist4=' + model_list_no[4];
//            document.cookie = 'modellist5=' + model_list_no[5];
//            document.cookie = 'modellist6=' + model_list_no[6];
//            document.cookie = 'modellist7=' + model_list_no[7];
            
            document.cookie = 'moderadio0=' + radio_model[0];
            document.cookie = 'moderadio1=' + radio_model[1];
            document.cookie = 'moderadio2=' + radio_model[2];
            document.cookie = 'moderadio3=' + radio_model[3];
            document.cookie = 'moderadio4=' + radio_model[4];
            document.cookie = 'moderadio5=' + radio_model[5];
            document.cookie = 'moderadio6=' + radio_model[6];
            document.cookie = 'moderadio7=' + radio_model[7];
            
            document.cookie = 'timebox0=' + timebox[0];
            document.cookie = 'timebox1=' + timebox[1];
            document.cookie = 'timebox2=' + timebox[2];
            document.cookie = 'timebox3=' + timebox[3];
            document.cookie = 'timebox4=' + timebox[4];
            document.cookie = 'timebox5=' + timebox[5];
            document.cookie = 'timebox6=' + timebox[6];
            document.cookie = 'timebox7=' + timebox[7];
            
            document.cookie = 'timeboxflg0=' + timebox_flg[0];
            document.cookie = 'timeboxflg1=' + timebox_flg[1];
            document.cookie = 'timeboxflg2=' + timebox_flg[2];
            document.cookie = 'timeboxflg3=' + timebox_flg[3];
            document.cookie = 'timeboxflg4=' + timebox_flg[4];
            document.cookie = 'timeboxflg5=' + timebox_flg[5];
            document.cookie = 'timeboxflg6=' + timebox_flg[6];
            document.cookie = 'timeboxflg7=' + timebox_flg[7];         
   
//            document.cookie = 'clientlist0=' + client_list_no[0];
//            document.cookie = 'clientlist1=' + client_list_no[1];
//            document.cookie = 'clientlist2=' + client_list_no[2];
//            document.cookie = 'clientlist3=' + client_list_no[3];
//            document.cookie = 'clientlist4=' + client_list_no[4];
//            document.cookie = 'clientlist5=' + client_list_no[5];
//            document.cookie = 'clientlist6=' + client_list_no[6];
//            document.cookie = 'clientlist7=' + client_list_no[7];
            
            document.cookie = 'clientid0=' + client_id_list[0];
            document.cookie = 'clientid1=' + client_id_list[1];
            document.cookie = 'clientid2=' + client_id_list[2];
            document.cookie = 'clientid3=' + client_id_list[3];
            document.cookie = 'clientid4=' + client_id_list[4];
            document.cookie = 'clientid5=' + client_id_list[5];
            document.cookie = 'clientid6=' + client_id_list[6];
            document.cookie = 'clientid7=' + client_id_list[7];
            
            document.cookie = 'aftmpchk0=' + after_mp_task[0];
            document.cookie = 'aftmpchk1=' + after_mp_task[1];
            document.cookie = 'aftmpchk2=' + after_mp_task[2];
            document.cookie = 'aftmpchk3=' + after_mp_task[3];
            document.cookie = 'aftmpchk4=' + after_mp_task[4];
            document.cookie = 'aftmpchk5=' + after_mp_task[5];
            document.cookie = 'aftmpchk6=' + after_mp_task[6];
            document.cookie = 'aftmpchk7=' + after_mp_task[7];
            
            
            return true;
          }
          else
            return false;
        }
      }
      
      function datepickerchange()
      {
        var datepickervalue = document.forms.f_model_list.date_picker.value;
        var month = datepickervalue.substr(0,2);
        var day   = datepickervalue.substr(3,2);
        var year  = datepickervalue.substr(6,4);
        var datepickervalue = month + day + year;
        
        var namecode = <?php echo $name_code; ?>;
        var inputdate = datepickervalue;
        var updt = 1;
        var radio_am1 = <?php echo $am1_radio; ?>;
        var radio_am2 = <?php echo $am2_radio; ?>;
        var radio_am3 = <?php echo $am3_radio; ?>;
        var radio_pm1 = <?php echo $pm1_radio; ?>;
        var radio_pm2 = <?php echo $pm2_radio; ?>;
        var radio_pm3 = <?php echo $pm3_radio; ?>;
        var radio_ot1 = <?php echo $ot1_radio; ?>;
        var radio_ot2 = <?php echo $ot2_radio; ?>;
        var list_am1 = <?php echo $am1_list; ?>;
        var list_am2 = <?php echo $am2_list; ?>;
        var list_am3 = <?php echo $am3_list; ?>;
        var list_pm1 = <?php echo $pm1_list; ?>;
        var list_pm2 = <?php echo $pm2_list; ?>;
        var list_pm3 = <?php echo $pm3_list; ?>;
        var list_ot1 = <?php echo $ot1_list; ?>;
        var list_ot2 = <?php echo $ot2_list; ?>;
        window.open('jisseki_input-test.php?code='+namecode+'&indate='+inputdate+'&updt='+updt+'&am1='+radio_am1+'&am2='+radio_am2+'&am3='+radio_am3+'&pm1='+radio_pm1+'&pm2='+radio_pm2+'&pm3='+radio_pm3+'&ot1='+radio_ot1+'&ot2='+radio_ot2+'&al1='+list_am1+'&al2='+list_am2+'&al3='+list_am3+'&pl1='+list_pm1+'&pl2='+list_pm2+'&pl3='+list_pm3+'&ol1='+list_ot1+'&ol2='+list_ot2, '_self');
      }
      
      function listchange1()
      {
        var modellistElement1 = document.getElementById("modellist1");
        var result = modellistElement1.value;
        
        if(result=="開発費･コスト見積り" || result=="先行開発･商材開発･商品提案")
        {
          document.getElementById("clientlist1").disabled = false;
        }
        else
        {
          document.getElementById("clientlist1").disabled = true;
          document.getElementById("clientlist1").selectedIndex  = 0;
        }
      }
      function listchange2()
      {
        var modellistElement2 = document.getElementById("modellist2");
        var result = modellistElement2.value;
        
        if(result=="開発費･コスト見積り" || result=="先行開発･商材開発･商品提案")
        {
          document.getElementById("clientlist2").disabled = false;
        }
        else
        {
          document.getElementById("clientlist2").disabled = true;
          document.getElementById("clientlist2").selectedIndex  = 0;
        }
      }
      function listchange3()
      {
        var modellistElement3 = document.getElementById("modellist3");
        var result = modellistElement3.value;
        
        if(result=="開発費･コスト見積り" || result=="先行開発･商材開発･商品提案")
        {
          document.getElementById("clientlist3").disabled = false;
        }
        else
        {
          document.getElementById("clientlist3").disabled = true;
          document.getElementById("clientlist3").selectedIndex  = 0;
        }
      }
      function listchange4()
      {
        var modellistElement4 = document.getElementById("modellist4");
        var result = modellistElement4.value;
        
        if(result=="開発費･コスト見積り" || result=="先行開発･商材開発･商品提案")
        {
          document.getElementById("clientlist4").disabled = false;
        }
        else
        {
          document.getElementById("clientlist4").disabled = true;
          document.getElementById("clientlist4").selectedIndex  = 0;
        }
      }
      function listchange5()
      {
        var modellistElement5 = document.getElementById("modellist5");
        var result = modellistElement5.value;
        
        if(result=="開発費･コスト見積り" || result=="先行開発･商材開発･商品提案")
        {
          document.getElementById("clientlist5").disabled = false;
        }
        else
        {
          document.getElementById("clientlist5").disabled = true;
          document.getElementById("clientlist5").selectedIndex  = 0;
        }
      }
      function listchange6()
      {
        var modellistElement6 = document.getElementById("modellist6");
        var result = modellistElement6.value;
        
        if(result=="開発費･コスト見積り" || result=="先行開発･商材開発･商品提案")
        {
          document.getElementById("clientlist6").disabled = false;
        }
        else
        {
          document.getElementById("clientlist6").disabled = true;
          document.getElementById("clientlist6").selectedIndex  = 0;
        }
      }
      function listchange7()
      {
        var modellistElement7 = document.getElementById("modellist7");
        var result = modellistElement7.value;
        
        if(result=="開発費･コスト見積り" || result=="先行開発･商材開発･商品提案")
        {
          document.getElementById("clientlist7").disabled = false;
        }
        else
        {
          document.getElementById("clientlist7").disabled = true;
          document.getElementById("clientlist7").selectedIndex  = 0;
        }
      }
      function listchange8()
      {
        var modellistElement8 = document.getElementById("modellist8");
        var result = modellistElement8.value;
        
        if(result=="開発費･コスト見積り" || result=="先行開発･商材開発･商品提案")
        {
          document.getElementById("clientlist8").disabled = false;
        }
        else
        {
          document.getElementById("clientlist8").disabled = true;
          document.getElementById("clientlist8").selectedIndex  = 0;
        }
      }
      
      
      function categorychange1()
      {
        var radioElements = document.getElementsByName("radio_category_1");
        var modellistElement1 = document.getElementById("modellist1");
        var result = modellistElement1.value;
        
        document.getElementById("clientlist1").disabled = true;
        
        if(radioElements[0].checked)
        {
          // サーバで生成したJSON配列を既にmodellistとして定義しているので参照する
          var model_list = modellist;
          document.getElementById("clientlist1").selectedIndex  = 0;
          document.getElementById("after_mp_task1").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("after_mp_task1").disabled = true;
          document.getElementById("after_mp_task1").checked  = false;
        }
        var select = document.getElementById('modellist1');
        
        var radio_data;
        for( var i=0,l=radioElements.length; l>i; i++ )
        {
          if( radioElements[i].checked )
          {
            radio_data = radioElements[i].value ;
          }
        }
        
        sl = document.getElementById('modellist1');
        while(sl.lastChild)
          sl.removeChild(sl.lastChild);
        
        var cnt = model_list.length;
        for (var i=0; i<cnt; i++)
        {
          // option要素を生成
          var option = document.createElement('option');
          var text = document.createTextNode( model_list[i] );
          option.appendChild(text);
          
          // option要素を追加
          select.appendChild(option);
        }
      }
      
      function categorychange2()
      {
        var radioElements = document.getElementsByName("radio_category_2");
        var modellistElement2 = document.getElementById("modellist2");
        var result = modellistElement2.value;
        
        document.getElementById("clientlist2").disabled = true;
        
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist2").selectedIndex  = 0;
          document.getElementById("after_mp_task2").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("after_mp_task2").disabled = true;
          document.getElementById("after_mp_task2").checked  = false;
        }
        var select = document.getElementById('modellist2');
        
        var radio_data;
        for( var i=0,l=radioElements.length; l>i; i++ )
        {
          if( radioElements[i].checked )
          {
            radio_data = radioElements[i].value ;
          }
        }
        
        sl = document.getElementById('modellist2');
        while(sl.lastChild)
          sl.removeChild(sl.lastChild);
        
        var cnt = model_list.length;
        for (var i=0; i<cnt; i++)
        {
          // option要素を生成
          var option = document.createElement('option');
          var text = document.createTextNode( model_list[i] );
          option.appendChild(text);
          
          // option要素を追加
          select.appendChild(option);
        }
      }
      
      function categorychange3()
      {
        var radioElements = document.getElementsByName("radio_category_3");
        var modellistElement3 = document.getElementById("modellist3");
        var result = modellistElement3.value;
        
        document.getElementById("clientlist3").disabled = true;
        
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist3").selectedIndex  = 0;
          document.getElementById("after_mp_task3").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("after_mp_task3").disabled = true;
          document.getElementById("after_mp_task3").checked  = false;
        }
        var select = document.getElementById('modellist3');
        
        var radio_data;
        for( var i=0,l=radioElements.length; l>i; i++ )
        {
          if( radioElements[i].checked )
          {
            radio_data = radioElements[i].value ;
          }
        }
        
        sl = document.getElementById('modellist3');
        while(sl.lastChild)
          sl.removeChild(sl.lastChild);
        
        var cnt = model_list.length;
        for (var i=0; i<cnt; i++)
        {
          // option要素を生成
          var option = document.createElement('option');
          var text = document.createTextNode( model_list[i] );
          option.appendChild(text);
          
          // option要素を追加
          select.appendChild(option);
        }
      }
      
      function categorychange4()
      {
        var radioElements = document.getElementsByName("radio_category_4");
        var modellistElement4 = document.getElementById("modellist4");
        var result = modellistElement4.value;
        
        document.getElementById("clientlist4").disabled = true;
        
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist4").selectedIndex  = 0;
          document.getElementById("after_mp_task4").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("after_mp_task4").disabled = true;
          document.getElementById("after_mp_task4").checked  = false;
        }
        var select = document.getElementById('modellist4');
        
        var radio_data;
        for( var i=0,l=radioElements.length; l>i; i++ )
        {
          if( radioElements[i].checked )
          {
            radio_data = radioElements[i].value ;
          }
        }
        
        sl = document.getElementById('modellist4');
        while(sl.lastChild)
          sl.removeChild(sl.lastChild);
        
        var cnt = model_list.length;
        for (var i=0; i<cnt; i++)
        {
          // option要素を生成
          var option = document.createElement('option');
          var text = document.createTextNode( model_list[i] );
          option.appendChild(text);
          
          // option要素を追加
          select.appendChild(option);
        }
      }
      
      function categorychange5()
      {
        var radioElements = document.getElementsByName("radio_category_5");
        var modellistElement5 = document.getElementById("modellist5");
        var result = modellistElement5.value;
        
        document.getElementById("clientlist5").disabled = true;
        
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist5").selectedIndex  = 0;
          document.getElementById("after_mp_task5").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("after_mp_task5").disabled = true;
          document.getElementById("after_mp_task5").checked  = false;
        }
        var select = document.getElementById('modellist5');
        
        var radio_data;
        for( var i=0,l=radioElements.length; l>i; i++ )
        {
          if( radioElements[i].checked )
          {
            radio_data = radioElements[i].value ;
          }
        }
        
        sl = document.getElementById('modellist5');
        while(sl.lastChild)
          sl.removeChild(sl.lastChild);
        
        var cnt = model_list.length;
        for (var i=0; i<cnt; i++)
        {
          // option要素を生成
          var option = document.createElement('option');
          var text = document.createTextNode( model_list[i] );
          option.appendChild(text);
          
          // option要素を追加
          select.appendChild(option);
        }
      }
      
      function categorychange6()
      {
        var radioElements = document.getElementsByName("radio_category_6");
        var modellistElement6 = document.getElementById("modellist6");
        var result = modellistElement6.value;
        
        document.getElementById("clientlist6").disabled = true;
        
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist6").selectedIndex  = 0;
          document.getElementById("after_mp_task6").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("after_mp_task6").disabled = true;
          document.getElementById("after_mp_task6").checked  = false;
        }
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist6").disabled = true;
          document.getElementById("clientlist6").selectedIndex  = 0;
          document.getElementById("after_mp_task6").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("clientlist6").disabled = false;
          document.getElementById("after_mp_task6").disabled = true;
          document.getElementById("after_mp_task6").checked  = false;
        }
        var select = document.getElementById('modellist6');
        
        var radio_data;
        for( var i=0,l=radioElements.length; l>i; i++ )
        {
          if( radioElements[i].checked )
          {
            radio_data = radioElements[i].value ;
          }
        }
        
        sl = document.getElementById('modellist6');
        while(sl.lastChild)
          sl.removeChild(sl.lastChild);
        
        var cnt = model_list.length;
        for (var i=0; i<cnt; i++)
        {
          // option要素を生成
          var option = document.createElement('option');
          var text = document.createTextNode( model_list[i] );
          option.appendChild(text);
          
          // option要素を追加
          select.appendChild(option);
        }
      }
      function categorychange7()
      {
        var radioElements = document.getElementsByName("radio_category_7");
        var modellistElement7 = document.getElementById("modellist7");
        var result = modellistElement7.value;
        
        document.getElementById("clientlist7").disabled = true;
        
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist7").selectedIndex  = 0;
          document.getElementById("after_mp_task7").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("after_mp_task7").disabled = true;
          document.getElementById("after_mp_task7").checked  = false;
        }
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist7").disabled = true;
          document.getElementById("clientlist7").selectedIndex  = 0;
          document.getElementById("after_mp_task7").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("clientlist7").disabled = false;
          document.getElementById("after_mp_task7").disabled = true;
          document.getElementById("after_mp_task7").checked  = false;
        }
        var select = document.getElementById('modellist7');
        
        var radio_data;
        for( var i=0,l=radioElements.length; l>i; i++ )
        {
          if( radioElements[i].checked )
          {
            radio_data = radioElements[i].value ;
          }
        }
        
        sl = document.getElementById('modellist7');
        while(sl.lastChild)
          sl.removeChild(sl.lastChild);
        
        var cnt = model_list.length;
        for (var i=0; i<cnt; i++)
        {
          // option要素を生成
          var option = document.createElement('option');
          var text = document.createTextNode( model_list[i] );
          option.appendChild(text);
          
          // option要素を追加
          select.appendChild(option);
        }
      }
      function categorychange8()
      {
        var radioElements = document.getElementsByName("radio_category_8");
        var modellistElement8 = document.getElementById("modellist8");
        var result = modellistElement8.value;
        
        document.getElementById("clientlist8").disabled = true;
        
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist8").selectedIndex  = 0;
          document.getElementById("after_mp_task8").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("after_mp_task8").disabled = true;
          document.getElementById("after_mp_task8").checked  = false;
        }
        if(radioElements[0].checked)
        {
          var model_list = modellist;
          document.getElementById("clientlist8").disabled = true;
          document.getElementById("clientlist8").selectedIndex  = 0;
          document.getElementById("after_mp_task8").disabled = false;
        }
        else
        {
          var model_list = commonlist;
          document.getElementById("clientlist8").disabled = false;
          document.getElementById("after_mp_task8").disabled = true;
          document.getElementById("after_mp_task8").checked  = false;
        }
        var select = document.getElementById('modellist8');
        
        var radio_data;
        for( var i=0,l=radioElements.length; l>i; i++ )
        {
          if( radioElements[i].checked )
          {
            radio_data = radioElements[i].value ;
          }
        }
        
        sl = document.getElementById('modellist8');
        while(sl.lastChild)
          sl.removeChild(sl.lastChild);
        
        var cnt = model_list.length;
        for (var i=0; i<cnt; i++)
        {
          // option要素を生成
          var option = document.createElement('option');
          var text = document.createTextNode( model_list[i] );
          option.appendChild(text);
          
          // option要素を追加
          select.appendChild(option);
        }
      }
      
      function unregisted_date()
      {
        var namecode = <?php echo $name_code; ?>;
        window.open('Unregistered_date.php?code='+namecode);
      }
      
      function registed_date_period()
      {
        var namecode = <?php echo $name_code; ?>;
        window.open('Regist_data_period-test.php?code='+namecode);
      }
      function registed_date_model()
      {
        var namecode = <?php echo $name_code; ?>;
        window.open('Regist_data_model.php?code='+namecode+'&rd=0&md=0');
      }
    </script>
    
    <script type="text/javascript">
      var radio_sel = <?php echo $am1_radio; ?>;
      if (radio_sel == 0)
        var model_list = modellist;
      else
        var model_list = commonlist;
        
      var select = document.getElementById('modellist1');
      var cnt = model_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( model_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var radio_sel = <?php echo $am2_radio; ?>;
      if (radio_sel == 0)
        var model_list = modellist;
      else
        var model_list = commonlist;
      
      var select = document.getElementById('modellist2');
      var cnt = model_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( model_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var radio_sel = <?php echo $am3_radio; ?>;
      if (radio_sel == 0)
        var model_list = modellist;
      else
        var model_list = commonlist;
      
      var select = document.getElementById('modellist3');
      var cnt = model_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( model_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var radio_sel = <?php echo $pm1_radio; ?>;
      if (radio_sel == 0)
        var model_list = modellist;
      else
        var model_list = commonlist;
      
      var select = document.getElementById('modellist4');
      var cnt = model_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( model_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var radio_sel = <?php echo $pm2_radio; ?>;
      if (radio_sel == 0)
        var model_list = modellist;
      else
        var model_list = commonlist;
      
      var select = document.getElementById('modellist5');
      var cnt = model_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( model_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var radio_sel = <?php echo $pm3_radio; ?>;
      if (radio_sel == 0)
        var model_list = modellist;
      else
        var model_list = commonlist;
      
      var select = document.getElementById('modellist6');
      var cnt = model_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( model_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var radio_sel = <?php echo $ot1_radio; ?>;
      if (radio_sel == 0)
        var model_list = modellist;
      else
        var model_list = commonlist;
      
      var select = document.getElementById('modellist7');
      var cnt = model_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( model_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var radio_sel = <?php echo $ot2_radio; ?>;
      if (radio_sel == 0)
        var model_list = modellist;
      else
        var model_list = commonlist;
      
      var select = document.getElementById('modellist8');
      var cnt = model_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( model_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      
      
  //OEMリストの設定
  var client_list = clientlist;
      var select = document.getElementById('clientlist1');
      var cnt = client_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( client_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var select = document.getElementById('clientlist2');
      var cnt = client_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( client_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var select = document.getElementById('clientlist3');
      var cnt = client_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( client_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var select = document.getElementById('clientlist4');
      var cnt = client_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( client_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var select = document.getElementById('clientlist5');
      var cnt = client_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( client_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var select = document.getElementById('clientlist6');
      var cnt = client_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( client_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var select = document.getElementById('clientlist7');
      var cnt = client_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( client_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
      var select = document.getElementById('clientlist8');
      var cnt = client_list.length;
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        var text = document.createTextNode( client_list[i] );
        option.appendChild(text);
        
        // option要素を追加
        select.appendChild(option);
      }
    </script>
    
    <script>
      var list_am1 = <?php echo $am1_list; ?>;
      var options1 = document.getElementById('modellist1').options;
      options1[list_am1].selected = true;
      
      var list_am2 = <?php echo $am2_list; ?>;
      var options2 = document.getElementById('modellist2').options;
      options2[list_am2].selected = true;
      
      var list_am3 = <?php echo $am3_list; ?>;
      var options3 = document.getElementById('modellist3').options;
      options3[list_am3].selected = true;
      
      var list_pm1 = <?php echo $pm1_list; ?>;
      var options4 = document.getElementById('modellist4').options;
      options4[list_pm1].selected = true;
      
      var list_pm2 = <?php echo $pm2_list; ?>;
      var options5 = document.getElementById('modellist5').options;
      options5[list_pm2].selected = true;
      
      var list_pm3 = <?php echo $pm3_list; ?>;
      var options6 = document.getElementById('modellist6').options;
      options6[list_pm3].selected = true;
      
      var list_ot1 = <?php echo $ot1_list; ?>;
      var options7 = document.getElementById('modellist7').options;
      options7[list_ot1].selected = true;
      
      var list_ot2 = <?php echo $ot2_list; ?>;
      var options8 = document.getElementById('modellist8').options;
      options8[list_ot2].selected = true;
    </script>
    
    <script>
      var client_am1 = <?php echo $am1_cltlist; ?>;
      var options1 = document.getElementById('clientlist1').options;
      options1[client_am1].selected = true;
      
      var client_am2 = <?php echo $am2_cltlist; ?>;
      var options2 = document.getElementById('clientlist2').options;
      options2[client_am2].selected = true;
      
      var client_am3 = <?php echo $am3_cltlist; ?>;
      var options3 = document.getElementById('clientlist3').options;
      options3[client_am3].selected = true;
      
      var client_pm1 = <?php echo $pm1_cltlist; ?>;
      var options4 = document.getElementById('clientlist4').options;
      options4[client_pm1].selected = true;
      
      var client_pm2 = <?php echo $pm2_cltlist; ?>;
      var options5 = document.getElementById('clientlist5').options;
      options5[client_pm2].selected = true;
      
      var client_pm3 = <?php echo $pm3_cltlist; ?>;
      var options6 = document.getElementById('clientlist6').options;
      options6[client_pm3].selected = true;
      
      var client_ot1 = <?php echo $ot1_cltlist; ?>;
      var options7 = document.getElementById('clientlist7').options;
      options7[client_ot1].selected = true;
      
      var client_ot2 = <?php echo $ot2_cltlist; ?>;
      var options8 = document.getElementById('clientlist8').options;
      options8[client_ot2].selected = true;
    </script>
    <!-- debug removed -->
    <script>
      // Hide account UI robustly, including elements added later via document.write or scripts.
      (function(){
        try{
          function hideAccountElements(){
            try{
              for(var i=1;i<=8;i++){
                var el = document.getElementById('clientlist'+i);
                if(el) el.style.display = 'none';
              }
            }catch(_){ }

            try{
              var sels = document.getElementsByTagName('select');
              for(var si=0; si<sels.length; si++){
                var s = sels[si];
                var id = s.id || '';
                if(id.indexOf('clientlist') !== -1){ s.style.display='none'; }
              }
            }catch(_){ }

            try{
              var tags = ['label','div','span','p','td','th'];
              for(var t=0;t<tags.length;t++){
                var nodes = document.getElementsByTagName(tags[t]);
                for(var n=0;n<nodes.length;n++){
                  var node = nodes[n];
                  var txt = '';
                  try{ txt = (typeof node.innerText !== 'undefined') ? node.innerText : node.textContent; }catch(e){ txt = node.textContent || ''; }
                  if(txt && txt.indexOf('アカウント')>-1){ node.style.display='none'; }
                }
              }
            }catch(_){ }
          }

          // initial hide
          hideAccountElements();

          // observe DOM changes and hide newly added matching elements
          var docRoot = document.documentElement || document.body;
          if(docRoot && window.MutationObserver){
            var observer = new MutationObserver(function(mutations){
              for(var mi=0; mi<mutations.length; mi++){
                var m = mutations[mi];
                if(m.addedNodes && m.addedNodes.length>0){
                  hideAccountElements();
                }
              }
            });
            observer.observe(docRoot, { childList:true, subtree:true });
            // stop observing after 5 seconds to avoid perf impact
            setTimeout(function(){ try{ observer.disconnect(); }catch(_){} }, 5000);
          } else {
            // fallback: try again after short delays
            var tries = 0;
            var tmr = setInterval(function(){ hideAccountElements(); tries++; if(tries>10) clearInterval(tmr); }, 200);
          }
        }catch(e){ try{ console.log('hide account UI error', e); }catch(_){ } }
      })();
    </script>
  </body>
</html>