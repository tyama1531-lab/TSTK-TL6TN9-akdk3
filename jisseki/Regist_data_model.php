<?php
  $DSN        = "Xacti_resource_database";	//データソース名
  $DBUSER     = "Xacti";					//ログインユーザー名
  $DBPASSWORD = "5346";						//パスワード
  
  //Accessデータベースに接続
  if (! $con = odbc_connect($DSN, $DBUSER, $DBPASSWORD)){
    exit("Accessデータベースに接続できませんでした！");}
  
  $name_code = $_GET["code"];
  $am1_radio = $_GET['rd'];
  $am1_list  = $_GET['md'];
  
  $body_temp = "";
  
  //機種リストの読込み
  $sql_model_latest = "SELECT T_ResourceTB.Model_ID, Q_Model_list.model_code, T_ResourceTB.Employee_CD, Sum(T_ResourceTB.FTE) AS FTE_all FROM Q_Model_list RIGHT JOIN T_ResourceTB ON Q_Model_list.Model_ID = T_ResourceTB.Model_ID WHERE (((T_ResourceTB.InputDate)>=Date()-30) AND ((Q_Model_list.Common_task_check)=False)) GROUP BY T_ResourceTB.Model_ID, Q_Model_list.model_code, T_ResourceTB.Employee_CD HAVING (((T_ResourceTB.Employee_CD)=" . $name_code . ")) ORDER BY Sum(T_ResourceTB.FTE) DESC";
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
  
  $model_list = array();
  $model_id_list = array();
  $cnt = 1;
  $model_list[0] = "---";
  $model_id_list[0] = 0;
  while (odbc_fetch_row($rst_model_latest))
  {
    $model_list[$cnt] = mb_convert_encoding(odbc_result($rst_model_latest, "model_code"), 'UTF8', 'SJIS-win');
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
      $model_list[$cnt] = mb_convert_encoding(odbc_result($rst_model_other, "model_code"), 'UTF8', 'SJIS-win');
      $model_id_list[$cnt] = odbc_result($rst_model_other, "Model_ID");
      
      $cnt += 1;
    }
  }
  $model_list_cnt = $cnt;
  $json_model_list = json_encode($model_list);
  $json_model_id_list = json_encode($model_id_list);
  odbc_free_result($rst_model_latest);
  odbc_free_result($rst_model_other);
  
  //共通業務リスト読込み
  $sql_common = "SELECT T_Common_task_master.*, T_Common_task_master.Common_task_order FROM T_Common_task_master ORDER BY T_Common_task_master.Common_task_order";
  if (@odbc_exec($con, $sql_common))
    $rst_common = odbc_exec($con, $sql_common);
  else{
    print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_common";
    exit;}
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
  $common_list_cnt = $cnt;
  $json_common_list = json_encode($common_list);
  $json_common_id_list = json_encode($common_id_list);
  odbc_free_result($rst_common);
  
  if ($am1_radio == 0)
    $model_id = $model_id_list[$am1_list];
  else
    $model_id = $common_id_list[$am1_list];
  
  
  
  if ($am1_list <> 0)
  {
    $sql_month_min = "SELECT T_ResourceTB.Employee_CD, T_ResourceTB.Model_ID, Min(T_ResourceTB.Month_CD) AS Month_CD_min FROM T_ResourceTB GROUP BY T_ResourceTB.Employee_CD, T_ResourceTB.Model_ID HAVING (((T_ResourceTB.Employee_CD)=" . $name_code . ") AND ((T_ResourceTB.Model_ID)=" . $model_id . "))";
    $sql_month_max = "SELECT T_ResourceTB.Employee_CD, T_ResourceTB.Model_ID, Max(T_ResourceTB.Month_CD) AS Month_CD_max FROM T_ResourceTB GROUP BY T_ResourceTB.Employee_CD, T_ResourceTB.Model_ID HAVING (((T_ResourceTB.Employee_CD)=" . $name_code . ") AND ((T_ResourceTB.Model_ID)=" . $model_id . "))";
    if (@odbc_exec($con, $sql_month_min))
      $rst_month_min = odbc_exec($con, $sql_month_min);
    else{
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_month_min";
      exit;}
    if (@odbc_exec($con, $sql_month_max))
      $rst_month_max = odbc_exec($con, $sql_month_max);
    else{
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_month_max";
      exit;}
    $month_min = odbc_result($rst_month_min, "Month_CD_min");
    $month_max = odbc_result($rst_month_max, "Month_CD_max");
    odbc_free_result($rst_month_min);
    odbc_free_result($rst_month_max);
    
    
    if ($month_min != null)
    {
      $sql_calendar = "SELECT Q_Calendar_list.Year_list, Q_Calendar_list.Month_list, Q_Calendar_list.Calendar_CD FROM Q_Calendar_list GROUP BY Q_Calendar_list.Year_list, Q_Calendar_list.Month_list, Q_Calendar_list.Calendar_CD HAVING (((Q_Calendar_list.Calendar_CD)>=" . $month_min . "And (Q_Calendar_list.Calendar_CD)<=" . $month_max . "))";
      
      
      if (@odbc_exec($con, $sql_calendar))
        $rst_calendar = odbc_exec($con, $sql_calendar);
      else{
        print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_calendar";
        exit;}
    }
    
    $sql_calcdata = "SELECT T_ResourceTB.Employee_CD, T_ResourceTB.Model_ID, T_ResourceTB.Month_CD, Sum(T_ResourceTB.FTE) AS FTE_SUM FROM T_ResourceTB GROUP BY T_ResourceTB.Employee_CD, T_ResourceTB.Model_ID, T_ResourceTB.Month_CD HAVING (((T_ResourceTB.Employee_CD)=" . $name_code . ") AND ((T_ResourceTB.Model_ID)=" . $model_id . "))";
    if (@odbc_exec($con, $sql_calcdata))
      $rst_calcdata = odbc_exec($con, $sql_calcdata);
    else{
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_calcdata";
      exit;}
    
    $body_calcdata = "";
    $fte_data_total = 0;
    $month_cd_cnt = $month_min;
    $calc_fte_data = array();
    $month_list = array();
    $cnt = 0;
    
    while (odbc_fetch_row($rst_calcdata))
    {
      $month_cd = odbc_result($rst_calcdata, "Month_CD");
      
      while($month_cd > $month_cd_cnt)
      {
        odbc_fetch_row($rst_calendar, 0);
        while (odbc_fetch_row($rst_calendar))
        {
          if ($month_cd_cnt == odbc_result($rst_calendar, "Calendar_CD"))
          {
            $year_info  = odbc_result($rst_calendar, "Year_list");
            $month_info = odbc_result($rst_calendar, "Month_list");
          }
        }
        $body_calcdata .= $year_info . "/" . sprintf('%02d', $month_info) . "&nbsp&nbsp&nbsp";
        $body_calcdata .= "0.0<br>";
        
        $month_list[$cnt] = $month_info . "月";
        
        $month_cd_cnt += 1;
      }
      
      odbc_fetch_row($rst_calendar, 0);
      while (odbc_fetch_row($rst_calendar))
      {
        if ($month_cd == odbc_result($rst_calendar, "Calendar_CD"))
        {
          $year_info  = odbc_result($rst_calendar, "Year_list");
          $month_info = odbc_result($rst_calendar, "Month_list");
        }
      }
      $body_calcdata .= $year_info . "/" . sprintf('%02d', $month_info) . "&nbsp&nbsp&nbsp";
      $month_list[$cnt] = $month_info . "月";
      
      $calc_fte = floatval(odbc_result($rst_calcdata, "FTE_SUM")) * 160;
      $fte_data = $calc_fte;
      $fte_data_total += $fte_data;
      $body_calcdata .= sprintf('%.01f', $fte_data);
      $calc_fte_data[$cnt] = $calc_fte;
      
      $body_calcdata .= "<br>";
      $month_cd_cnt += 1;
      $cnt += 1;
    }
    
    $body_calcdata .= "合計&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
    $body_calcdata .= sprintf('%.01f', $fte_data_total);
    
    $json_calc_fte_data = json_encode($calc_fte_data);
    $json_month_list    = json_encode($month_list);
    
    odbc_free_result($rst_calcdata);
    odbc_free_result($rst_calendar);
    
    //レコードを追加するSQLを組み立て
    $sql = "INSERT INTO T_Refer_table (Employee_name_code, Refer_page) VALUES (" . $name_code . ", 'model')";
    
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
  
  //Accessデータベースとの接続を解除
  odbc_close($con);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML lang="ja">
  <HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <META http-equiv="Content-Style-Type" content="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <title>実績抽出(機種)</title>
    
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script language="javascript" type="text/javascript" src="jquery/jquery.jqplot.min.js"></script>
    <script language="javascript" type="text/javascript" src="jquery/plugins/jqplot.barRenderer.js"></script>
    <script language="javascript" type="text/javascript" src="jquery/plugins/jqplot.categoryAxisRenderer.js"></script>
    <script language="javascript" type="text/javascript" src="jquery/plugins/jqplot.pointLabels.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery/jquery.jqplot.min.css" />
    
    
    <script>
      var calc_fte_data = JSON.parse('<?php echo $json_calc_fte_data; ?>');
      var month_list    = JSON.parse('<?php echo $json_month_list; ?>');
      var fte_cnt = <?php echo $cnt; ?>;
      var array_calc_fte_data = [];
      
      for (i=0; i < fte_cnt; i++)
      {
        array_calc_fte_data[i] = [];
        array_calc_fte_data[i][0] = month_list[i];
        array_calc_fte_data[i][1] = calc_fte_data[i];
      }
      
      jQuery( function()
      {
        jQuery . jqplot('jqPlot-sample', [ array_calc_fte_data ],
        {
          axes:
          {
            xaxis:
            {
              renderer: jQuery . jqplot . CategoryAxisRenderer,
            }
          },
          seriesDefaults:
          {
            renderer: jQuery . jqplot . BarRenderer,
            pointLabels:
            {
              show: true,
              location: 'n',
              ypadding: 0,
              escapeHTML: false,
              formatString: '<b style="color: gray;">%d</b>'
            }
          }
        });
      });
    </script>
    
  </HEAD>
  <BODY>
    <script>
      function GetCookie( name )
      {
        var result = null;
        var cookieName = name + '=';
        var allcookies = document.cookie;
        
        var position = allcookies.indexOf( cookieName );
        if( position != -1 )
        {
          var startIndex = position + cookieName.length;
          var endIndex = allcookies.indexOf( ';', startIndex );
          if( endIndex == -1 )
          {
            endIndex = allcookies.length;
          }
          
          result = decodeURIComponent( allcookies.substring( startIndex, endIndex ) );
        }
        return result;
      }
    </script>
    
    <script>
      var strdate = GetCookie('strdate');
      var enddate = GetCookie('enddate');
      if (strdate == null)
        strdate = "";
      if (enddate == null)
        enddate = "";
        
      document.write('<form id="fm" name="fm" method="post">');
        document.write('<label for="radio_model1">［機種］</label>&nbsp&nbsp');
        document.write('<label for="radio_model1">［共通］</label><br>');
        document.write('&nbsp&nbsp&nbsp&nbsp<input id="radio_model1_0" type="radio" name="radio_category_1" value="0" onchange="categorychange1()" <?php if($am1_radio==0){echo "checked";}?> />');
        document.write('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input id="radio_model1_1" type="radio" name="radio_category_1" value="1" onchange="categorychange1()" <?php if($am1_radio==1){echo "checked";}?> />');
        document.write('&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<select id="modellist1" name="modellist1" onchange="listchange1()"></select><br>');
      document.write('</form>');
    </script>
    
    <script>
      var modellist = <?php echo $am1_list; ?>;
      if (modellist != 0)
      {
        document.write('<br>');
        document.write('<p><font face="ＭＳ ゴシック"><B>-------------抽出結果［H］-------------</B></font></p>');
      }
    </script>
    
    <div id="jqPlot-sample" style="height: 300px; width: 600px;"></div>
    
    <script>
      var modellist = <?php echo $am1_list; ?>;
      if (modellist != 0)
        document.write('<p><font face="ＭＳ ゴシック"><?=$body_calcdata?></font></p>');
    </script>
    
    <script type="text/javascript">
      var radio_sel = <?php echo $am1_radio; ?>;
      if (radio_sel == 0)
        var model_list = JSON.parse('<?php echo  $json_model_list; ?>');
      else
        var model_list = JSON.parse('<?php echo  $json_common_list; ?>');
        
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
    </script>
    
    <script>
      var list_am1 = <?php echo $am1_list; ?>;
      var options1 = document.getElementById('modellist1').options;
      options1[list_am1].selected = true;
    </script>
    
    <script>
      function categorychange1()
      {
        var radioElements = document.getElementsByName("radio_category_1");
        if(radioElements[0].checked)
          var model_list = JSON.parse('<?php echo  $json_model_list; ?>');
        else
          var model_list = JSON.parse('<?php echo  $json_common_list; ?>');
        var select = document.getElementById('modellist1');
        
        var radio_data;
        for( var i=0,l=radioElements.length; l>i; i++ )
        {
          if( radioElements[i].checked )
          {
            radio_data = radioElements[i].value ;
          }
        }
        
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
        
        var namecode = <?php echo $name_code; ?>;
        window.open('Regist_data_model.php?code='+namecode+'&rd='+radio_data+'&md=0', '_self');
      }
      
      function listchange1()
      {
        var list_id = document.forms.fm.modellist1.selectedIndex;
        var namecode = <?php echo $name_code; ?>;
        var radio_am1 = <?php echo $am1_radio; ?>;
        window.open('Regist_data_model.php?code='+namecode+'&rd='+radio_am1+'&md='+list_id, '_self');
      }
    </script>
    
    <p><font face="ＭＳ ゴシック"><?=$body_temp?></font></p>
    
  </BODY>
</HTML>