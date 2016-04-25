<html>
<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="favicon.ico" rel="shortcut icon">
  <link rel="stylesheet" href="css/style.css">
  <title>Отделы</title>  
  
</head>
<body>

<form action="" method="post" name="r_form2" >


 <header class="header clearfix">
      <div class="logo">.Simpliste</div>

      <nav class="menu_main">
        <ul>
          <li><a href="mainform.html">Main</a></li>
          <li><a href="addnewuser.html">Пользователи</a></li>
          <li class="active"><a href="tableofevents.php">Мероприятия</a></li>
          <li><a href="addnewdictionary.html">Справочники</a></li>
          <li><a href="addnewreport.html">Отчеты</a></li>
          <li><a href="addnewtables.html">Другие таблицы</a></li>
        </ul>
      </nav>
    </header>

</form>
</body>
</html>
<?php



if ( !isset( $_GET["action"] ) ) $_GET["action"] = "showlist";  
//die(var_dump($_GET['action'], $_GET, $_POST));
switch ( $_GET["action"] ) 
{ 
  case "showlist":    // Список всех записей в таблице БД
    show_list(); break; 
  case "addform":     // Форма для добавления новой записи 
    get_add_item_form(); break; 
  case "add":         // Добавить новую запись в таблицу БД
    add_item(); break;
  case "editform":    // Форма для редактирования записи 
    get_edit_item_form(); break; 
  case "update":      // Обновить запись в таблице БД
	update_item(); break; 
  case "delete":      // Удалить запись в таблице БД
    delete_item(); break;
  default: 
    show_list(); 
}

// Функция выводит список всех записей в таблице БД
function show_list() 
{ 

 
$sql = "SELECT * FROM departments";
require_once("dbconnect.php");
$res = mysqli_query($connect, $sql);

  echo '<h2>Отделы</h2>'; 
  echo '<div class="col_66">';
    echo '<table border="1" class="table">';      
   
  echo '<tr><th>IDDeparment</th><th>Отдел</th><th>Университет</th>
  <th>Ред.</th><th>Удл.</th></tr>'; 
  while ( $item = mysqli_fetch_array( $res ) ) 
  { 
    echo '<tr>'; 
	echo '<td>'.$item['IDDeparment'].'</td>'; 
    echo '<td>'.$item['Department'].'</td>'; 
    
	$sql2 = "SELECT 'University' FROM 'countries' WHERE IDUniversity = ".$item['CodeUniversity'];
	$res2 =  mysqli_query($connect, $sql2);
	 echo '<td>'.mysqli_fetch_array( $res2 )['University'].'</td>';
    echo '<td><a href="?action=editform&id='.$item['IDDeparment'].'">Ред.</a></td>'; 
    echo '<td><a href="?action=delete&id='.$item['IDDeparment'].'">Удл.</a></td>'; 
    echo '</tr>'; 
  } 
  echo '</table>';
  echo '<p><a href="'.$_SERVER['PHP_SELF'].'?action=addform">Добавить</a></p>';  
} 


// Функция формирует форму для добавления записи в таблице БД 
function get_add_item_form() 
{ 
include("templates/addDepartment.php");
 
}


// Функция добавляет новую запись в таблицу БД  
function add_item() 
{ 
require_once("dbconnect.php");
  $Department = mysqli_escape_string($connect, $_POST['Department'] ); 
  $CodeUniversity = mysqli_escape_string($connect, $_POST['CodeUniversity'] ); 
  $query = " INSERT INTO 'departments'('Department', 'CodeUniversity') 
 VALUES ('$Department','$CodeUniversity')";
  mysqli_query ($connect, $query ); 
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
}

// Функция формирует форму для редактирования записи в таблице БД 
function get_edit_item_form() 
{ 
  require_once("dbconnect.php");
  echo '<h2>Редактировать</h2>'; 
  $id = empty($_GET["id"]) ? 0 : intval($_GET["id"]);
  $query = 'select * from departments WHERE IDDeparment='.$id; 
  
  $res = mysqli_query($connect ,$query ); 
  $item = mysqli_fetch_array( $res ); 
  include("templates/updateDepartment.php");
} 

// Функция обновляет запись в таблице БД  


function update_item() 
{ 
  require_once("dbconnect.php");
  $id = mysqli_escape_string($connect, $_GET['IDDeparment'] );
  $Department = mysqli_escape_string($connect, $_GET['Department'] ); 
  $CodeUniversity = mysqli_escape_string($connect, $_GET['CodeUniversity'] ); 
  $query = "UPDATE departments SET Department='".$Department."', CodeUniversity ='".$CodeUniversity."' WHERE IDDeparment=".$id;
   
  mysqli_query ($connect, $query ); 
   // die(var_dump($_POST, $_GET, $id));
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
} 

// Функция удаляет запись в таблице БД 
function delete_item() 
{ 
  require_once("dbconnect.php");
  $id = empty($_GET["id"]) ? 0 : intval($_GET["id"]);
  $query = "DELETE FROM departments WHERE IDDeparment=".$id; 
  mysqli_query ($connect, $query ); 
 // die(var_dump($_POST, $_GET, $id));
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
} 
  
?>