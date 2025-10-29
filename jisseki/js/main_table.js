var database;
function dbConnect() {
    //データベースに接続する関数
    database = new ActiveXObject("ADODB.Connection");
    database.Open("Provider=Microsoft.ACE.OLEDB.12.0;Data Source=C:\\Users\\tyama\\Desktop\\Dashboard\\Xacti_Dashboard.accdb");
    alert("データベースに接続しました。");
}
 
function dbClose() {
    //データベースを切断する関数
    database.Close();
    database = null;
    alert("データベースを切断しました。");
}



function focus(obj){
  obj.style.backgroundColor = "#ffff00";
}

function blur(obj){
  obj.style.backgroundColor = "#ffffff";
}