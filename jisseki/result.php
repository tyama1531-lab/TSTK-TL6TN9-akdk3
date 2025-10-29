<?php
session_start();
  
  $DSN        = "Xacti_resource_database";	//データソース名
  $DBUSER     = "Xacti";					//ログインユーザー名
  $DBPASSWORD = "5346";						//パスワード
  
  //Accessデータベースに接続
  if (! $con = odbc_connect($DSN, $DBUSER, $DBPASSWORD)){
    exit("Accessデータベースに接続できませんでした！");}
  
  $model_list = array();
  
  $namecode      = $_POST["namecode"];
  $model_list[1] = $_POST["modellist1"];
  $model_list[2] = $_POST["modellist2"];
  $model_list[3] = $_POST["modellist3"];
  $model_list[4] = $_POST["modellist4"];
  $model_list[5] = $_POST["modellist5"];
  $model_list[6] = $_POST["modellist6"];
  $model_list[7] = $_POST["modellist7"];
  $model_list[8] = $_POST["modellist8"];
  $radio_pos[1]  = $_POST["radio_category_1"];
  $radio_pos[2]  = $_POST["radio_category_2"];
  $radio_pos[3]  = $_POST["radio_category_3"];
  $radio_pos[4]  = $_POST["radio_category_4"];
  $radio_pos[5]  = $_POST["radio_category_5"];
  $radio_pos[6]  = $_POST["radio_category_6"];
  $radio_pos[7]  = $_POST["radio_category_7"];
  $radio_pos[8]  = $_POST["radio_category_8"];
  
//  $list_pos[1]   = $_COOKIE["modellist0"];
//  $list_pos[2]   = $_COOKIE["modellist1"];
//  $list_pos[3]   = $_COOKIE["modellist2"];
//  $list_pos[4]   = $_COOKIE["modellist3"];
//  $list_pos[5]   = $_COOKIE["modellist4"];
//  $list_pos[6]   = $_COOKIE["modellist5"];
//  $list_pos[7]   = $_COOKIE["modellist6"];
//  $list_pos[8]   = $_COOKIE["modellist7"];
  
  $list_pos[1]   = $model_list[1];
  $list_pos[2]   = $model_list[2];
  $list_pos[3]   = $model_list[3];
  $list_pos[4]   = $model_list[4];
  $list_pos[5]   = $model_list[5];
  $list_pos[6]   = $model_list[6];
  $list_pos[7]   = $model_list[7];
  $list_pos[8]   = $model_list[8];
  
  
  $InputDate     =  $_GET["indate"];
//  print "InputDate=" . $InputDate . "<br>";
  
  $model_id_list = array();
  $model_id_list[0] = $_COOKIE["modelid0"];
  $model_id_list[1] = $_COOKIE["modelid1"];
  $model_id_list[2] = $_COOKIE["modelid2"];
  $model_id_list[3] = $_COOKIE["modelid3"];
  $model_id_list[4] = $_COOKIE["modelid4"];
  $model_id_list[5] = $_COOKIE["modelid5"];
  $model_id_list[6] = $_COOKIE["modelid6"];
  $model_id_list[7] = $_COOKIE["modelid7"];
  
  $time_data = array();
  $time_data[1] = $_COOKIE["timebox0"];
  $time_data[2] = $_COOKIE["timebox1"];
  $time_data[3] = $_COOKIE["timebox2"];
  $time_data[4] = $_COOKIE["timebox3"];
  $time_data[5] = $_COOKIE["timebox4"];
  $time_data[6] = $_COOKIE["timebox5"];
  $time_data[7] = $_COOKIE["timebox6"];
  $time_data[8] = $_COOKIE["timebox7"];
  
  $time_data_flg = array();
  $time_data_flg[1] = $_COOKIE["timeboxflg0"];
  $time_data_flg[2] = $_COOKIE["timeboxflg1"];
  $time_data_flg[3] = $_COOKIE["timeboxflg2"];
  $time_data_flg[4] = $_COOKIE["timeboxflg3"];
  $time_data_flg[5] = $_COOKIE["timeboxflg4"];
  $time_data_flg[6] = $_COOKIE["timeboxflg5"];
  $time_data_flg[7] = $_COOKIE["timeboxflg6"];
  $time_data_flg[8] = $_COOKIE["timeboxflg7"];
  
  $client_list_no = array();
//  $client_list_no[0] = $_COOKIE["clientlist0"];
//  $client_list_no[1] = $_COOKIE["clientlist1"];
//  $client_list_no[2] = $_COOKIE["clientlist2"];
//  $client_list_no[3] = $_COOKIE["clientlist3"];
//  $client_list_no[4] = $_COOKIE["clientlist4"];
//  $client_list_no[5] = $_COOKIE["clientlist5"];
//  $client_list_no[6] = $_COOKIE["clientlist6"];
//  $client_list_no[7] = $_COOKIE["clientlist7"];
  
  $client_id_list = array();
  $client_id_list[0] = $_COOKIE["clientid0"];
  $client_id_list[1] = $_COOKIE["clientid1"];
  $client_id_list[2] = $_COOKIE["clientid2"];
  $client_id_list[3] = $_COOKIE["clientid3"];
  $client_id_list[4] = $_COOKIE["clientid4"];
  $client_id_list[5] = $_COOKIE["clientid5"];
  $client_id_list[6] = $_COOKIE["clientid6"];
  $client_id_list[7] = $_COOKIE["clientid7"];
  
  $after_mp_task = array();
  $after_mp_task[0] = $_COOKIE["aftmpchk0"];
  $after_mp_task[1] = $_COOKIE["aftmpchk1"];
  $after_mp_task[2] = $_COOKIE["aftmpchk2"];
  $after_mp_task[3] = $_COOKIE["aftmpchk3"];
  $after_mp_task[4] = $_COOKIE["aftmpchk4"];
  $after_mp_task[5] = $_COOKIE["aftmpchk5"];
  $after_mp_task[6] = $_COOKIE["aftmpchk6"];
  $after_mp_task[7] = $_COOKIE["aftmpchk7"];
  
  
//   print "radio_pos=" . $radio_pos[1] . "<BR>";
//   print "radio_pos=" . $radio_pos[2] . "<BR>";
//   print "radio_pos=" . $radio_pos[3] . "<BR>";
//   print "radio_pos=" . $radio_pos[4] . "<BR>";
//   print "radio_pos=" . $radio_pos[5] . "<BR>";
//   print "radio_pos=" . $radio_pos[6] . "<BR>";
//   print "radio_pos=" . $radio_pos[7] . "<BR>";
//   print "radio_pos=" . $radio_pos[8] . "<BR><BR>";
//   print "list_pos="  . $list_pos[1]  . "<BR>";
//   print "list_pos="  . $list_pos[2]  . "<BR>";
//   print "list_pos="  . $list_pos[3]  . "<BR>";
//   print "list_pos="  . $list_pos[4]  . "<BR>";
//   print "list_pos="  . $list_pos[5]  . "<BR>";
//   print "list_pos="  . $list_pos[6]  . "<BR>";
//   print "list_pos="  . $list_pos[7]  . "<BR>";
//   print "list_pos="  . $list_pos[8]  . "<BR><BR>";
  
  $modellist_num_am = 0;
  $modellist_num_pm = 0;
  $modellist_num_ot = 0;
  $modellist_h_am = 0;
  $modellist_h_pm = 0;
  
  for ($i = 1; $i <= 3; $i++)
  {
    if ($model_list[$i]<>"---")
    {
      if($time_data_flg[$i]=="true")
        $modellist_h_am = $modellist_h_am + $time_data[$i];
      else
        $modellist_num_am += 1;
    }
  }
  for ($i = 4; $i <= 6; $i++)
  {
    if ($model_list[$i]<>"---")
    {
      if($time_data_flg[$i]=="true")
        $modellist_h_pm = $modellist_h_pm + $time_data[$i];
      else
        $modellist_num_pm += 1;
    }
  }
  for ($i = 7; $i <= 8; $i++)
  {
    if ($model_list[$i]<>"---")
    {
      if($time_data_flg[$i]=="true")
      {}
      else
        $modellist_num_ot += 1;
    }
  }
  
  
  $input_month = substr($InputDate, 0, 2);
  $input_date  = substr($InputDate, 2, 2);
  $input_year  = substr($InputDate, 4, 4);
  $input_full  = $input_month . "/" . $input_date . "/" . $input_year;
  
  //氏名コード＆日付でレコード削除
  $sql_del = "DELETE T_ResourceTB.Employee_CD, T_ResourceTB.InputDate FROM T_ResourceTB WHERE (((T_ResourceTB.Employee_CD)=" . $namecode . ") AND ((T_ResourceTB.InputDate)=#". $input_full ."#))";
  odbc_exec($con, $sql_del);
  
  $bJudge = true;
  for ($i=1; $i<=8; $i++)
  {
    if ($model_list[$i] <> "---")
    {
      //機種idの読込み
      $model_id = $model_id_list[$i - 1];
      
      //部署情報の読込み
      $sql_dept = "SELECT Q_Employee_list.*, Q_Employee_list.Employee_CD FROM Q_Employee_list WHERE (((Q_Employee_list.Employee_CD)=" . $namecode . "))";
      if (@odbc_exec($con, $sql_dept))
        $rst_dept = odbc_exec($con, $sql_dept);
      else{
        print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_dept";
        exit;}
      if (odbc_result($rst_dept, "Employee_CD")==$namecode)
      {
        $dept_code = odbc_result($rst_dept, "New_dept_work_CD");
        $position_cd = odbc_result($rst_dept, "New_position_CD");
      }
      
      odbc_free_result($rst_dept);
      
      //Work time設定
      if ($i <= 3) // AM
      {
        $work_time = 1;
      }
      else if ($i>=4 && $i<=6) // PM
      {
        $work_time = 2;
      }
      else // Over time
      {
        $work_time = 3;
      }
      
      //工数算出
      if ($time_data_flg[$i] == "false")
      {
        if ($i<=3) // AM
        {
          $time_data[$i] = (3.00 - $modellist_h_am) / $modellist_num_am;
          $fte = $time_data[$i] / 160;
        }
        else if ($i>=4 && $i<=6) // PM
        {
          $time_data[$i] = (4.75 - $modellist_h_pm) / $modellist_num_pm;
          $fte = $time_data[$i] / 160;
        }
        else // Over time
        {
          $time_data[$i] = 2.00 / $modellist_num_ot;
          $fte = $time_data[$i] / 160;
        }
      }
      else
      {
        $fte = $time_data[$i] / 160;
      }
      
      //日付
      $RegMonth = substr($InputDate, 0, 2);
      $RegDate  = substr($InputDate, 2, 2);
      $RegYear  = substr($InputDate, 4, 4);
      
      $RegDateFull= "#" . $RegYear . "/" . $RegMonth . "/" . $RegDate . "#";
      $Date_Check =  $RegYear . "-" . $RegMonth . "-" . $RegDate . " 00:00:00";
      
      //年月CD抽出
      $sql_calendar = "SELECT Q_Calendar_list.* FROM Q_Calendar_list";
      if (@odbc_exec($con, $sql_calendar))
        $rst_calendar = odbc_exec($con, $sql_calendar);
      else{
        print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_calendar";
        exit;}
      while (odbc_fetch_row($rst_calendar))
      {
        If (odbc_result($rst_calendar, "Date_list")==$Date_Check)
          $calendar_cd = odbc_result($rst_calendar, "Calendar_CD");
      }
      
      odbc_free_result($rst_calendar);
      
      $timevalue = $time_data[$i];
      $timevalueflg = $time_data_flg[$i];
      
      $clientidlist = $client_id_list[$i - 1];
      $aftermptask = $after_mp_task[$i - 1];
      
      //レコードを追加するSQLを組み立て
//    $sql = "INSERT INTO T_ResourceTB (Model_ID,Employee_CD,Dept_CD,Work_time_CD,FTE,InputDate,Month_CD,Position_CD) VALUES (" . $model_id . "," . $namecode . "," . $dept_code . "," . $work_time . "," . $fte . "," . $RegDateFull . ","  . $calendar_cd . ","  . $position_cd . ")";
      $sql = "INSERT INTO T_ResourceTB (Model_ID,Employee_CD,Dept_CD,Work_time_CD,FTE,InputDate,Month_CD,Position_CD,Time_input,Time_input_flg,Client_CD,AfterMp_task_check) VALUES (" . $model_id . "," . $namecode . "," . $dept_code . "," . $work_time . "," . $fte . "," . $RegDateFull . "," . $calendar_cd . "," . $position_cd . "," . $timevalue . "," . $timevalueflg . "," . $clientidlist . "," . $aftermptask . ")";
      
      //SQLを発行
      if (@odbc_exec($con, $sql))
      {
      }
      else
      {
        $bJudge = false;
        print "登録に失敗しました<BR><BR>";
        print "エラー内容は次の通りです。<BR>";
        print "<B>" . mb_convert_encoding(odbc_errormsg($con), 'UTF8', 'SJIS-win') . "</B>";
      }
    }
  }
  
  //実績をテーブルに書き込み後、再度機種リストを取得してリストIDを更新する
  $nModelCnt = 0;
  $nCommonCnt = 0;
  $nModel_id_array = Array();
  $sql_model_latest = "SELECT T_ResourceTB.Model_ID, Q_Model_list.model_code, T_ResourceTB.Employee_CD, Sum(T_ResourceTB.FTE) AS FTE_all FROM Q_Model_list RIGHT JOIN T_ResourceTB ON Q_Model_list.Model_ID = T_ResourceTB.Model_ID WHERE (((T_ResourceTB.InputDate)>=Date()-30) AND ((Q_Model_list.Common_task_check)=False)) GROUP BY T_ResourceTB.Model_ID, Q_Model_list.model_code, T_ResourceTB.Employee_CD HAVING (((T_ResourceTB.Employee_CD)=" . $namecode . ")) ORDER BY Sum(T_ResourceTB.FTE) DESC";
  if (@odbc_exec($con, $sql_model_latest))
    $rst_model_latest = odbc_exec($con, $sql_model_latest);
  else{
    print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_model_latest";
    exit;}
  $sql_model_other  = "SELECT Q_Model_list.*, Q_Model_list.model_code, Q_Model_list.Overtime_check, Q_Model_list.Possibility FROM Q_Model_list WHERE (((Q_Model_list.Overtime_check)=True) AND ((Q_Model_list.Possibility)=1)) ORDER BY Q_Model_list.model_code";
  if (@odbc_exec($con, $sql_model_other))
    $rst_model_other  = odbc_exec($con, $sql_model_other);
  else{
    print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_model_other";
    exit;}
  odbc_fetch_row($rst_model_latest, 0);
  while(odbc_fetch_row($rst_model_latest))
  {
    $nModel_id_array[$nModelCnt] = odbc_result($rst_model_latest, "Model_ID");
    $nModelCnt++;
  }
  
  odbc_fetch_row($rst_model_other, 0);
  while(odbc_fetch_row($rst_model_other))
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
      $nModel_id_array[$nModelCnt] = odbc_result($rst_model_other, "Model_ID");
      $nModelCnt ++;
    }
  }
  
  odbc_free_result($rst_model_latest);
  odbc_free_result($rst_model_other);
  
  for ($i=1; $i<=8; $i++)
  {
    //リストが機種選択なら最新機種リストで順番を更新
    if ($radio_pos[$i]==0 && $model_list[$i]<>"---")
    {
      $j = 0;
      while($j < $nModelCnt)
      {
    
        if ($nModel_id_array[$j] == $model_id_list[$i - 1])
        {
          break;
        }
          
        $j++;
      }
      $list_pos[$i] = $j + 1;
    }
  }
  $json_radio_pos = json_encode($radio_pos);
  $json_list_pos  = json_encode($list_pos);
  
  
  //月累計算出
  $sql_total_fte = "SELECT T_ResourceTB.Model_ID, T_ResourceTB.Employee_CD, T_ResourceTB.Month_CD, Sum(T_ResourceTB.FTE) AS FTE FROM T_ResourceTB GROUP BY T_ResourceTB.Model_ID, T_ResourceTB.Employee_CD, T_ResourceTB.Month_CD HAVING (((T_ResourceTB.Employee_CD)=" . $namecode . ") AND ((T_ResourceTB.Month_CD)=" . $calendar_cd . ")) ORDER BY Sum(T_ResourceTB.FTE) DESC";
  if (@odbc_exec($con, $sql_total_fte))
    $rst_total_fte = odbc_exec($con, $sql_total_fte);
  else{
    print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_total_fte";
    exit;}
  $sql_modellist = "SELECT Q_Model_list.* FROM Q_Model_list";
  if (@odbc_exec($con, $sql_modellist))
    $rst_modellist = odbc_exec($con, $sql_modellist);
  else{
    print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_modellist";
    exit;}
  $body_fte  = "<br>";
  $body_fte .= "<B>--------累計［H］---------------------------------</B><br>";
//  while (odbc_fetch_row($rst_total_fte))
//  {
//    $num_cnt = strlen(strval(sprintf('%.01f', odbc_result($rst_total_fte, "FTE") * 160)));
//    $body_fte .= "&nbsp";
////  $body_fte .= sprintf('%0.4f',odbc_result($rst_total_fte, "FTE") * 160);
//    $body_fte .= strval(sprintf('%.01f', odbc_result($rst_total_fte, "FTE") * 160));
////  echo odbc_result($rst_total_fte, "FTE") . "<br>";
//    $modelid = odbc_result($rst_total_fte, "Model_ID");
//    
//    odbc_fetch_row($rst_modellist, 0);
//    while (odbc_fetch_row($rst_modellist))
//    {
//      If (odbc_result($rst_modellist, "Model_ID")==$modelid)
//        $model_name = odbc_result($rst_modellist, "model_code");
//    }
//    
//    for ($i=0; $i<7-$num_cnt; $i++)
//      $body_fte .= "&nbsp";
//    $body_fte .= mb_convert_encoding($model_name, 'UTF8', 'SJIS-win') . "<br>";
//  }
  
  odbc_free_result($rst_total_fte);
  
  //今月･先月の年月CDを取得
  $today = date("Y/m/d");
  $sql_month_cd   = "SELECT Q_Calendar_list.Date_list, Q_Calendar_list.Month_list, Q_Calendar_list.Calendar_CD FROM Q_Calendar_list WHERE (((Q_Calendar_list.Date_list)=#" . $today . "#))";
  if (@odbc_exec($con, $sql_month_cd))
    $rst_month_cd   = odbc_exec($con, $sql_month_cd);
  else{
    print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_month_cd";
    exit;}
  $month_cd_now   = odbc_result($rst_month_cd, "Calendar_CD");
  $month_cd_pre   = $month_cd_now - 1;
  $month_name_now = odbc_result($rst_month_cd, "Month_list");
  
  odbc_free_result($rst_month_cd);
  
  if ($month_name_now == 1)
    $month_name_pre = 12;
  else
    $month_name_pre = $month_name_now - 1;
  
  $sql_calcdata_pre = "SELECT T_ResourceTB.Employee_CD, Q_Model_list.model_code, T_ResourceTB.Month_CD, Sum(T_ResourceTB.FTE) AS FTE_SUM FROM Q_Model_list RIGHT JOIN T_ResourceTB ON Q_Model_list.Model_ID = T_ResourceTB.Model_ID GROUP BY T_ResourceTB.Employee_CD, Q_Model_list.model_code, T_ResourceTB.Month_CD HAVING (((T_ResourceTB.Employee_CD)=" . $namecode . ") AND ((T_ResourceTB.Month_CD)=" . $month_cd_pre . ")) ORDER BY Sum(T_ResourceTB.FTE)";
  if (@odbc_exec($con, $sql_calcdata_pre))
    $rst_calcdata_pre = odbc_exec($con, $sql_calcdata_pre);
  else{
    print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_calcdata_pre";
    exit;}
  $sql_calcdata_now = "SELECT T_ResourceTB.Employee_CD, Q_Model_list.model_code, T_ResourceTB.Month_CD, Sum(T_ResourceTB.FTE) AS FTE_SUM, [FTE_SUM]*160 AS FTE_SUM_H FROM Q_Model_list RIGHT JOIN T_ResourceTB ON Q_Model_list.Model_ID = T_ResourceTB.Model_ID GROUP BY T_ResourceTB.Employee_CD, Q_Model_list.model_code, T_ResourceTB.Month_CD HAVING (((T_ResourceTB.Employee_CD)=" . $namecode . ") AND ((T_ResourceTB.Month_CD)=" . $month_cd_now . ")) ORDER BY Sum(T_ResourceTB.FTE)";
  if (@odbc_exec($con, $sql_calcdata_now))
    $rst_calcdata_now = odbc_exec($con, $sql_calcdata_now);
  else{
    print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_calcdata_now";
    exit;}
  
  $body_calcdata = "";
  $calc_fte_data = array();
  $model_name_list = array();
  $cnt = 0;
  $cnt_pre = 0;
  
  while (odbc_fetch_row($rst_calcdata_pre))
  {
    $cacl_fte = odbc_result($rst_calcdata_pre, "FTE_SUM") * 160;
    $calc_fte_data[$cnt] = $cacl_fte;
    $num_cnt = strlen(strval(sprintf('%.01f', $cacl_fte)));
    $body_calcdata .= sprintf('%.01f', $cacl_fte);
    for ($i=0; $i<10-$num_cnt; $i++)
      $body_calcdata .= "&nbsp";
    
    $model_name = mb_convert_encoding(odbc_result($rst_calcdata_pre, "model_code"), 'UTF8', 'SJIS-win');
    $body_calcdata .= $model_name . "<br>";
    $model_name_list[$cnt] = "　" . $model_name;
    
    $cnt += 1;
    $cnt_pre += 1;
  }
  odbc_free_result($rst_calcdata_pre);
  
  $calc_fte_data[$cnt]   = 0;
  $model_name_list[$cnt] = $month_name_pre . "月実績　　　　　　　　";
  $cnt += 1;
  $calc_fte_data[$cnt]   = 0;
  $model_name_list[$cnt] = "";
  $cnt += 1;
  
  while (odbc_fetch_row($rst_calcdata_now))
  {
    $cacl_fte = round(odbc_result($rst_calcdata_now, "FTE_SUM_H"), 1);
    $calc_fte_data[$cnt] = $cacl_fte;
    $num_cnt = strlen(strval(sprintf('%.01f', $cacl_fte)));
    $body_calcdata .= sprintf('%.01f', $cacl_fte);
    for ($i=0; $i<10-$num_cnt; $i++)
      $body_calcdata .= "&nbsp";
    
    $model_name = mb_convert_encoding(odbc_result($rst_calcdata_now, "model_code"), 'UTF8', 'SJIS-win');
    $body_calcdata .= $model_name . "<br>";
    $model_name_list[$cnt] = $model_name;
    
    $cnt += 1;
  }
  odbc_free_result($rst_calcdata_now);
  
  $calc_fte_data[$cnt]   = 0;
  $model_name_list[$cnt] = $month_name_now . "月実績　　　　　　　　";
  $cnt += 1;
  
  $json_calc_fte_data   = json_encode($calc_fte_data);
  $json_model_name_list = json_encode($model_name_list);
  
  
  //Accessデータベースとの接続を解除
  odbc_close($con);
  
  //入力時間の計算
  $time_text = array();
  $worktime_sum = 0;
  $overtime_sum = 0;
  for($i=1; $i<=8; $i++)
  {
    if ($list_pos[$i] == 0)
      $time_text[$i] = "";
    else
    {
      $time_text[$i] = " (" . round($time_data[$i], 2) . "h)";
      if($i<=6)
        $worktime_sum += $time_data[$i];
      else
        $overtime_sum += $time_data[$i];
    }
  }
  
  
  
  //登録完了メッセージ
  if ($bJudge == true)
  {
    print "登録完了" . "<br><br>";
    print $input_year . "/" . $input_month . "/" . $input_date . "<br>";
    
    for($i=1; $i<=8; $i++)
    {
      if ($i==1)
        print "　" . "午前:<br>";
      elseif ($i==4)
        print "　" . "午後:<br>";
      elseif ($i==7)
        print "　" . "残業:<br>";
      
      print "　　　" . $model_list[$i] . $time_text[$i] . "<br>";
    }
    print "<br>";
    
    print "　時間内合計：" . round($worktime_sum, 2) . "h<br>";
    print "　時間外合計：" . round($overtime_sum, 2) . "h<br><br>";
    
  }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML lang="ja">
  <HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <META http-equiv="Content-Style-Type" content="text/css">
    <title>実績入力結果</title>
    
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script language="javascript" type="text/javascript" src="jquery/jquery.jqplot.min.js"></script>
    <script language="javascript" type="text/javascript" src="jquery/plugins/jqplot.pieRenderer.js"></script>
    <script language="javascript" type="text/javascript" src="jquery/plugins/jqplot.barRenderer.js"></script>
    <script language="javascript" type="text/javascript" src="jquery/plugins/jqplot.categoryAxisRenderer.js"></script>
    <script language="javascript" type="text/javascript" src="jquery/plugins/jqplot.pointLabels.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery/jquery.jqplot.min.css" />
    
    <script>
      var calc_fte_data = JSON.parse('<?php echo $json_calc_fte_data; ?>');
      var model_name_list = JSON.parse('<?php echo $json_model_name_list; ?>');
      var fte_cnt     = <?php echo $cnt; ?>;
      var fte_cnt_pre = <?php echo $cnt_pre; ?>;
      var array_calc_fte_data = [];
      var array_bar_color = [];
      var color1 = '#4AB2C6';
      var color2 = '#EFA229';
      
      for (i=0; i<fte_cnt_pre+1; i++)
        array_bar_color[i] = color2;
      for (i=fte_cnt_pre; i<fte_cnt; i++)
        array_bar_color[i] = color1;
      
      for (i=0; i<fte_cnt; i++)
      {
        array_calc_fte_data[i] = [];
        array_calc_fte_data[i][0] = calc_fte_data[i];
        array_calc_fte_data[i][1] = model_name_list[i];
      }
      
      jQuery( function()
      {
        jQuery . jqplot('fte_graph', [ array_calc_fte_data ],
        {
          seriesColors: array_bar_color,
          axes:
          {
            yaxis:
            {
              renderer: jQuery . jqplot . CategoryAxisRenderer,
              tickOptions:
              {
                showGridline: false
              }
            },
            xaxis:
            {
              tickOptions:
              {
                showGridline: true,
                showMark: false,
                showLabel: false
              }
            }
          },
          grid:
          {
            shadowDepth: 0,
            borderColor: '#ffffff',
            background: '#ffffff'
          },
          seriesDefaults:
          {
            renderer: jQuery . jqplot . BarRenderer,
            rendererOptions:
            {
              barDirection: 'horizontal',
              barMargin: 5,
              varyBarColor: true
            },
            pointLabels:
            {
              show: true,
              location: 'e',
              escapeHTML: false,
              formatString: '<b style="color: gray;">%.1f</b>',
              hideZeros: true
            }
          }
        });
      });
      
    </script>
    
  </HEAD>
  <BODY>
    <button type="button" onClick="back_to_input()" disabled>入力画面に戻る</button>
    <input type="button" value="実績抽出(期間)" onClick="registed_date_period()" />
    <input type="button" value="実績抽出(機種)" onClick="registed_date_model()" />
    <p><font face="ＭＳ ゴシック"><?=$body_fte?></font></p>
    
    <div id="fte_graph" style="height: 500px; width: 450px;"></div>
    
    <script type="text/javascript">
      function back_to_input()
      {
        var radiopos = JSON.parse('<?php echo  $json_radio_pos; ?>');
        var listpos  = JSON.parse('<?php echo  $json_list_pos; ?>');
        var updt     = 1;
        var namecode  = <?php echo $namecode; ?>;
        var inputdate = <?php echo $InputDate; ?>;
        
        var radio_am1 = radiopos[1];
        var radio_am2 = radiopos[2];
        var radio_am3 = radiopos[3];
        var radio_pm1 = radiopos[4];
        var radio_pm2 = radiopos[5];
        var radio_pm3 = radiopos[6];
        var radio_ot1 = radiopos[7];
        var radio_ot2 = radiopos[8];
        var list_am1  = listpos[1];
        var list_am2  = listpos[2];
        var list_am3  = listpos[3];
        var list_pm1  = listpos[4];
        var list_pm2  = listpos[5];
        var list_pm3  = listpos[6];
        var list_ot1  = listpos[7];
        var list_ot2  = listpos[8];
        
        document.cookie = "modelid0=;";
        document.cookie = "modelid1=;";
        document.cookie = "modelid2=;";
        document.cookie = "modelid3=;";
        document.cookie = "modelid4=;";
        document.cookie = "modelid5=;";
        document.cookie = "modelid6=;";
        document.cookie = "modelid7=;";
        
        document.cookie = "modellist0=;";
        document.cookie = "modellist1=;";
        document.cookie = "modellist2=;";
        document.cookie = "modellist3=;";
        document.cookie = "modellist4=;";
        document.cookie = "modellist5=;";
        document.cookie = "modellist6=;";
        document.cookie = "modellist7=;";
        
        document.cookie = "moderadio0=;";
        document.cookie = "moderadio1=;";
        document.cookie = "moderadio2=;";
        document.cookie = "moderadio3=;";
        document.cookie = "moderadio4=;";
        document.cookie = "moderadio5=;";
        document.cookie = "moderadio6=;";
        document.cookie = "moderadio7=;";
        
        document.cookie = "timebox0=;";
        document.cookie = "timebox1=;";
        document.cookie = "timebox2=;";
        document.cookie = "timebox3=;";
        document.cookie = "timebox4=;";
        document.cookie = "timebox5=;";
        document.cookie = "timebox6=;";
        document.cookie = "timebox7=;";
        
        document.cookie = "timeboxflg0=;";
        document.cookie = "timeboxflg1=;";
        document.cookie = "timeboxflg2=;";
        document.cookie = "timeboxflg3=;";
        document.cookie = "timeboxflg4=;";
        document.cookie = "timeboxflg5=;";
        document.cookie = "timeboxflg6=;";
        document.cookie = "timeboxflg7=;";
        
        inputdate = ('000' + inputdate).slice(-8);
        window.open('jisseki_input.php?code='+namecode+'&indate='+inputdate+'&updt='+updt+'&am1='+radio_am1+'&am2='+radio_am2+'&am3='+radio_am3+'&pm1='+radio_pm1+'&pm2='+radio_pm2+'&pm3='+radio_pm3+'&ot1='+radio_ot1+'&ot2='+radio_ot2+'&al1='+list_am1+'&al2='+list_am2+'&al3='+list_am3+'&pl1='+list_pm1+'&pl2='+list_pm2+'&pl3='+list_pm3+'&ol1='+list_ot1+'&ol2='+list_ot2, '_self');
      }
      
      function registed_date_period()
      {
        var namecode = <?php echo $namecode; ?>;
        window.open('Regist_data_period.php?code='+namecode);
      }
      function registed_date_model()
      {
        var namecode = <?php echo $namecode; ?>;
        window.open('Regist_data_model.php?code='+namecode+'&rd=0&md=0');
      }
    </script>
  </BODY>
</HTML>