var database;
function dbConnect() {
    //�f�[�^�x�[�X�ɐڑ�����֐�
    database = new ActiveXObject("ADODB.Connection");
    database.Open("Provider=Microsoft.ACE.OLEDB.12.0;Data Source=C:\\Users\\tyama\\Desktop\\Dashboard\\Xacti_Dashboard.accdb");
    alert("�f�[�^�x�[�X�ɐڑ����܂����B");
}
 
function dbClose() {
    //�f�[�^�x�[�X��ؒf����֐�
    database.Close();
    database = null;
    alert("�f�[�^�x�[�X��ؒf���܂����B");
}



function focus(obj){
  obj.style.backgroundColor = "#ffff00";
}

function blur(obj){
  obj.style.backgroundColor = "#ffffff";
}