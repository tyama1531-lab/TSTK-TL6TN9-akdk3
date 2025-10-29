<?php
  $DSN        = "Xacti_resource_database";	//データソース名
  $DBUSER     = "Xacti";					//ログインユーザー名
  $DBPASSWORD = "5346";						//パスワード
  
  //Accessデータベースに接続
  if (! $con = odbc_connect($DSN, $DBUSER, $DBPASSWORD)){
    exit("Accessデータベースに接続できませんでした！");}
  
  $name_code = $_GET["code"];
  
  if (isset($_COOKIE["calcflg"]))
  {
    $calc_flg = $_COOKIE["calcflg"];
    $str_date = $_COOKIE["strdate"];
    $end_date = $_COOKIE["enddate"];
  }
  else
    $calc_flg = 0;
  
  if ($calc_flg == 1)
  {
    $sql_calcdata = "SELECT T_ResourceTB.Employee_CD, T_ResourceTB.Model_ID, Q_Model_list.model_code, Sum(T_ResourceTB.FTE) AS FTE_SUM FROM Q_Model_list RIGHT JOIN T_ResourceTB ON Q_Model_list.Model_ID = T_ResourceTB.Model_ID WHERE (((T_ResourceTB.InputDate)>=#" . $str_date . "# And (T_ResourceTB.InputDate)<=#" . $end_date . "#)) GROUP BY T_ResourceTB.Employee_CD, T_ResourceTB.Model_ID, Q_Model_list.model_code HAVING (((T_ResourceTB.Employee_CD)=" . $name_code . ")) ORDER BY Sum(T_ResourceTB.FTE) DESC";
    if (@odbc_exec($con, $sql_calcdata))
      $rst_calcdata = odbc_exec($con, $sql_calcdata);
    else{
      print "アクセスエラー（しばらく時間を置いてから再度ログインをお願いします） error_calcdata";
      exit;}
    $body_calcdata = "";
    $calc_fte_data = array();
    $model_name_list = array();
    $cnt = 0;
    while (odbc_fetch_row($rst_calcdata))
    {
      $cacl_fte = odbc_result($rst_calcdata, "FTE_SUM") * 160;
      $calc_fte_data[$cnt] = $cacl_fte;
      $num_cnt = strlen(strval(sprintf('%.01f', $cacl_fte)));
      $body_calcdata .= sprintf('%.01f', $cacl_fte);
      for ($i=0; $i<10-$num_cnt; $i++)
        $body_calcdata .= "&nbsp";
      
      $model_name = mb_convert_encoding(odbc_result($rst_calcdata, "model_code"), 'UTF8', 'SJIS-win');
      $body_calcdata .= $model_name . "<br>";
      $model_name_list[$cnt] = $model_name;
      
      $cnt += 1;
    }
    
    $json_calc_fte_data   = json_encode($calc_fte_data);
    $json_model_name_list = json_encode($model_name_list);
    
    //レコードを追加するSQLを組み立て
    $sql = "INSERT INTO T_Refer_table (Employee_name_code, Refer_page) VALUES (" . $name_code . ", 'period')";
    
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
    <link rel="shortcut icon" href="favicon2.ico">
    <title>実績抽出(期間)</title>
    
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script language="javascript" type="text/javascript" src="jquery/jquery.jqplot.min.js"></script>
    <script language="javascript" type="text/javascript" src="jquery/plugins/jqplot.pieRenderer.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery/jquery.jqplot.min.css" />
    
    
    <script>
      var calc_fte_data = JSON.parse('<?php echo $json_calc_fte_data; ?>');
      var model_name_list = JSON.parse('<?php echo $json_model_name_list; ?>');
      var fte_cnt = <?php echo $cnt; ?>;
      var array_calc_fte_data = [];
      
      for (i=0; i < fte_cnt; i++)
      {
        array_calc_fte_data[i] = [];
        array_calc_fte_data[i][0] = model_name_list[i];
        array_calc_fte_data[i][1] = calc_fte_data[i];
      }
      
      jQuery( function()
      {
        jQuery.jqplot('jqPlot-sample', [ array_calc_fte_data ],
        {
          grid:
          {
            shadowDepth: 0,
            borderColor: '#ffffff',
            background: '#ffffff'
          },
          seriesDefaults:
          {
            renderer: jQuery . jqplot . PieRenderer,
            rendererOptions:
            {
              padding: 15,
              dataLabels: 'value',
              showDataLabels: true,
              startAngle: -90,
            }
          },
          legend:
          {
            show: true,
            location: 'e',
            rendererOptions:
            {
              numberRows: null
            },
          }
        });
      });
    </script>
    
    <script>
      $(window).on('load', function() 
      {
        $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
        $('.StrDate').datepicker(
        {//クラス名を指定
          showMonthAfterYear: false,
          numberOfMonths: 3,
          showButtonPanel: true,
        });
      });
      $(window).on('load', function() 
      {
        $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
        $('.EndDate').datepicker(
        {//クラス名を指定
          showMonthAfterYear: false,
          numberOfMonths: 3,
          showButtonPanel: true,
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
        document.write('<p>開始日：<input type="date" class="StrDate" id="StrDate" name="StrDate" style="width:100px" value="' + strdate + '" id="datepicker1" onchange="datepickerstrchange()"></p></p>');
        document.write('<p>終了日：<input type="date" class="EndDate" id="EndDate" name="EndDate" style="width:100px" value="' + enddate + '" id="datepicker2" onchange="datepickerendchange()"></p></p>');
        document.write('<input type="button" id="reg_button" value="抽出" onClick="return regist_data()"/>');
      document.write('</form>');
    </script>
    
    <script>
      var calcflg = GetCookie("calcflg");
      if(calcflg == 1)
      {
        document.write('<br>');
        document.write('<p><font face="ＭＳ ゴシック"><B>-------------抽出結果［H］-------------</B></font></p>');
      }
    </script>
    
    <script>
      function datepickerstrchange()
      {
        var strvalue = document.forms.fm.StrDate.value;
        document.cookie = 'strdate=' + strvalue;
      }
      function datepickerendchange()
      {
        var endvalue = document.forms.fm.EndDate.value;
        document.cookie = 'enddate=' + endvalue;
      }
      
      function regist_data()
      {
        var namecode = <?php echo $name_code; ?>;
        
        var strdate = GetCookie('strdate');
        if(strdate == null)
        {
          alert("開始日を入力してください");
          document.cookie = 'calcflg=0';
          return false;
        }
        var strmonth = strdate.substr(0,2);
        var strday   = strdate.substr(3,2);
        var stryear  = strdate.substr(6,4);
        var strdaycode = stryear * 12 * 30 + strmonth * 30 + strday * 1;
        
        var enddate = GetCookie('enddate');
        if(enddate == null)
        {
          alert("終了日を入力してください");
          document.cookie = 'calcflg=0';
          return false;
        }
        var endmonth = Number(enddate.substr(0,2));
        var endday   = Number(enddate.substr(3,2));
        var endyear  = Number(enddate.substr(6,4));
        var enddaycode = endyear * 12 * 30 + endmonth * 30 + endday * 1;
        
        var regist_flg = false;
        
        if(strdaycode > enddaycode)
        {
          alert("終了日が開始日より前に設定されています")
          regist_flg = false;
        }
        else
          regist_flg = true;
        
        if (regist_flg == true)
        {
          document.cookie = 'calcflg=1';
          window.open('Regist_data_period.php?code='+namecode, '_self');
          return true;
        }
        else
        {
          document.cookie = 'calcflg=0';
          return false;
        }
      }
    </script>
    
    <div id="jqPlot-sample" style="height: 300px; width: 450px;"></div>
    
    <script>
      var calcflg = GetCookie("calcflg");
      
      if(calcflg == 1)
        document.write('<p><font face="ＭＳ ゴシック"><?=$body_calcdata?></font></p>');
    </script>
    
  </BODY>
</HTML>