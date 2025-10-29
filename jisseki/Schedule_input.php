<?php
  $DSN        = "Xacti_resource_database";	//データソース名
  $DBUSER     = "Xacti";					//ログインユーザー名
  $DBPASSWORD = "5346";						//パスワード
  
  //Accessデータベースに接続
  if (! $con = odbc_connect($DSN, $DBUSER, $DBPASSWORD)){
    exit("Accessデータベースに接続できませんでした！");}
  
  $name_code = $_GET["code"];
  
  //社員情報の読込み
  $sql_member = "SELECT * FROM T_Employee_list";
  $rst_member = odbc_exec($con, $sql_member);
  while (odbc_fetch_row($rst_member))
  {
    If (odbc_result($rst_member, "employee_cd")==$name_code)
    {
      $employee_name = mb_convert_encoding(odbc_result($rst_member, "employee_name"), 'UTF8', 'SJIS-win');
      $dept_code = odbc_result($rst_member, "dept_cd");
    }
  }
  
  $body_text = "氏名： " . $employee_name . "<br>";
  
  //部署情報の読込み
  $sql_dept = "SELECT * FROM T_Official_dept_cd";
  $rst_dept = odbc_exec($con, $sql_dept);
  $judge=0;
  while (odbc_fetch_row($rst_dept) Or $judge=0)
  {
     If (odbc_result($rst_dept, "Official_dept_CD")==$dept_code)
     {
       $dept_name = mb_convert_encoding(odbc_result($rst_dept, "Official_dept_name"), 'UTF8', 'SJIS-win');
       $judge = 1;
     }
  }
  $body_text .= "部署： " . $dept_name . "<br><br>";
  
  //機種リストの読込み
  $sql_model = "SELECT Q_Model_list.*, Q_Model_list.model_code, Q_Model_list.Overtime_check, Q_Model_list.Possibility FROM Q_Model_list WHERE (((Q_Model_list.Overtime_check)=True) AND ((Q_Model_list.Possibility)=1)) ORDER BY Q_Model_list.model_code";
  $rst_model = odbc_exec($con, $sql_model);
  $model_list = array();
  $cnt = 1;
  $model_list[0] = "---";
  while (odbc_fetch_row($rst_model)) 
  {
    $model_list[$cnt] = mb_convert_encoding(odbc_result($rst_model, "model_code"), 'UTF8', 'SJIS-win');
    $cnt += 1;
  }
  $json_model_list = json_encode($model_list);
  
  //Accessデータベースとの接続を解除
  odbc_close($con);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML lang="ja">
  <HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <META http-equiv="Content-Style-Type" content="text/css">
    <title>業務予定登録</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
      
    </script>
  </HEAD>
  <BODY>
    <p style="font-size:16px;"><B><U>業務予定登録</U></B></p>
    <p style="font-size:14px;"><?=$body_text?></p>
    
    <form name="form1" method="GET" action="#">
      <input type="button" value="登録" id="regist" onClick="loadData()">
      <input type="button" value="削除" id="delete" onClick="DeleteData()" disabled><p></p>
      <table border="0" cellspacing="0" cellpadding="1" id="table1">
        <tr>
          <th><p style="font-size:14px;">✓</p></th>
          <th><p style="font-size:14px;">No.</p></th>
          <th><p style="font-size:14px;">機種</p></th>
          <th><p style="font-size:14px;">項目リスト</p></th>
          <th><p style="font-size:14px;">項目詳細</p></th>
          <th><p style="font-size:14px;">全工数[h]</p></th>
          <th><p style="font-size:14px;">残工数[h]</p></th>
          <th><p style="font-size:14px;">開始日</p></th>
          <th><p style="font-size:14px;">終了日</p></th>
        </tr>
        <tr>
          <td class="chk"><input type="checkbox" name="selectcheck" /></td>
          <td class="num">1</td>
          <td class="model"> <select id="modellist1" name="modellist10" style="margin-bottom:0px;"></select></td>
          <td class="task1"> <input type="text" name="taks10" value="" size="20" /></td>
          <td class="task2"> <input type="text" name="task20" value="" size="40" /></td>
          <td class="alleft"><input type="number" name="alleft0" min="0" value="" size="5" /></td>
          <td class="remeft"><input type="number" name="remeft0" min="0" value="" size="5" /></td>
          <td class="start"> <input type="date" name="date_picker10" style="width:80px" value="mm/dd/yyyy" id="datepicker0"></td>
          <td class="end">   <input type="date" name="date_picker20" style="width:80px" value="mm/dd/yyyy" id="datepicker1"></td>
        </tr>
      </table>
      <input type="button" value="項目追加" onClick="AddTableRows();" />
    </form>
    
    <script type="text/javascript">
      var model_list = JSON.parse('<?php echo  $json_model_list; ?>');
      var select = document.getElementById('modellist1');
      var cnt = model_list.length;
      
      for (var i=0; i<cnt; i++)
      {
        // option要素を生成
        var option = document.createElement('option');
        option.setAttribute('value', i);
        option.innerHTML = model_list[i];
        
        // option要素を追加
        select.appendChild(option);
      }
    </script>
    
    <script>
      var list1 = 0;
      var options1 = document.getElementById('modellist1').options;
      options1[list1].selected = true;
    </script>
    
    <script type="text/javascript">
      var counter = 1;
      function AddTableRows()
      {
        // カウンタを回す
        counter++;
        
        var table1 = document.getElementById("table1");
        var row1 = table1.insertRow(counter);
        var cell1 = row1.insertCell(0);
        var cell2 = row1.insertCell(1);
        var cell3 = row1.insertCell(2);
        var cell4 = row1.insertCell(3);
        var cell5 = row1.insertCell(4);
        var cell6 = row1.insertCell(5);
        var cell7 = row1.insertCell(6);
        var cell8 = row1.insertCell(7);
        var cell9 = row1.insertCell(8);
        
        // class の付与は UserAgent によって
        // 挙動が違うっぽいので念のため両方の方法で
        cell1.setAttribute("class","chk");
        cell2.setAttribute("class","num");
        cell3.setAttribute("class","model");
        cell4.setAttribute("class","task1");
        cell5.setAttribute("class","task2");
        cell6.setAttribute("class","alleft");
        cell7.setAttribute("class","remeft");
        cell8.setAttribute("class","start");
        cell9.setAttribute("class","end");
        cell1.className = 'chk';
        cell2.className = 'num';
        cell3.className = 'model';
        cell4.className = 'task1';
        cell5.className = 'task2';
        cell6.className = 'alleft';
        cell7.className = 'remeft';
        cell8.className = 'start';
        cell9.className = 'end';
        
        var HTML1 = '<input type="checkbox" name="selectcheck" />';
        var HTML2 = counter;
        var HTML3 = '<select id="modellist' + counter + '" name="modellist1' + counter + '" style="margin-bottom:0px;">';
        var HTML4 = '<input type="text" name="task1' + counter + '" value="" size="20" />';
        var HTML5 = '<input type="text" name="task2' + counter + '" value="" size="40" />';
        var HTML6 = '<input type="number" name="alleft' + counter + '" min="0" value="" size="5" />';
        var HTML7 = '<input type="number" name="remeft' + counter + '" min="0" value="" size="5" />';
        var HTML8 = '<input type="date" name="date_picker1' + counter + '" style="width:80px" value="mm/dd/yyyy" id="datepicker' + (counter-1)*2+0 + '">';
        var HTML9 = '<input type="date" name="date_picker2' + counter + '" style="width:80px" value="mm/dd/yyyy" id="datepicker' + (counter-1)*2+1 + '">';
        cell1.innerHTML = HTML1;
        cell2.innerHTML = HTML2;
        cell3.innerHTML = HTML3;
        cell4.innerHTML = HTML4;
        cell5.innerHTML = HTML5;
        cell6.innerHTML = HTML6;
        cell7.innerHTML = HTML7;
        cell8.innerHTML = HTML8;
        cell9.innerHTML = HTML9;
        
        for( var i=1; i<=counter; i++)
        {
          $( "#datepicker" + i*2+0 ).datepicker();
          $( "#datepicker" + i*2+1 ).datepicker();
        }
        
        var idname = 'modellist' + counter;
        var model_list = JSON.parse('<?php echo  $json_model_list; ?>');
        var select = document.getElementById(idname);
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
      
      function loadData()
      {
        var DetailText1 = document.form1.elements[6].value;
        alert(DetailText1);
      }
      
      $( function()
      {
        $( "#datepicker0").datepicker();
        $( "#datepicker1").datepicker();
        
      });
    </script>
    
  </BODY>
</HTML>