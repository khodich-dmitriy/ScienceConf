<html>
<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="favicon.ico" rel="shortcut icon">
  <link rel="stylesheet" href="css/style.css">
  <title>Приказы</title>  
  
</head>
<body>

<form action="" method="post" name="r_form2" >


 <header class="header clearfix">
      <div class="logo">.Simpliste</div>

      <nav class="menu_main">
        <ul>
          <li><a href="mainform.php">Main</a></li>
          <li><a href="addnewuser.php">Пользователи</a></li>
          <li><a href="tableofevents.php">Мероприятия</a></li>
          <li><a href="addnewdictionary.php">Справочники</a></li>
          <li><a href="addnewreport.html">Отчеты</a></li>
          <li class="active"><a href="addnewtables.php">Другие таблицы</a></li>
		  <li><a href="exit.php">Выйти</a></li>
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

require_once("dbconnect.php");
$sql = "SELECT * FROM orders";
$res = mysqli_query($connect, $sql);

  echo '<h2>Приказы</h2>'; 
  echo '<div class="col_66">';
    echo '<table border="1" class="table">';      
   
  echo '<tr><th>ID</th><th>Тема приказа</th><th>Номер приказа</th>
  <th>Дата приказа</th>
  <th></th><th></th></tr>'; 
  while ( $item = mysqli_fetch_array( $res ) ) 
  { 
    echo '<tr>'; 
    echo '<td>'.$item['IDOrder'].'</td>';
    echo '<td>'.$item['OrderTheme'].'</td>'; 
	echo '<td>'.$item['OrderNumber'].'</td>';
    echo '<td>'.$item['OrderDate'].'</td>'; 
    echo '<td><a href="?action=editform&id='.$item['IDOrder'].'">Ред.</a></td>'; 
    echo '<td><a href="?action=delete&id='.$item['IDOrder'].'">Удл.</a></td>'; 
    echo '</tr>'; 
  } 
  echo '</table>';
  echo '<p><a href="'.$_SERVER['PHP_SELF'].'?action=addform">Добавить</a></p>';  
} 


// Функция формирует форму для добавления записи в таблице БД 
function get_add_item_form() 
{ 
include("templates/addOrder.php");
 
}


// Функция добавляет новую запись в таблицу БД  
function add_item() 
{ 
require_once("dbconnect.php");
  $OrderTheme = mysqli_escape_string($connect, $_POST['OrderTheme'] ); 
  $OrderNumber = mysqli_escape_string($connect, $_POST['OrderNumber'] ); 
  $OrderDate = mysqli_escape_string($connect, $_POST['OrderDate'] ); 
  
  $query = " INSERT INTO `orders`(`OrderTheme`, `OrderNumber`,`OrderDate`) 
 VALUES ('$OrderTheme','$OrderNumber','$OrderDate')"; 
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
  $query = 'select * from orders WHERE IDOrder='.$id; 
  
  $res = mysqli_query($connect ,$query ); 
  $item = mysqli_fetch_array( $res ); 
  include("templates/updateOrder.php");
} 

// Функция обновляет запись в таблице БД  


function update_item() 
{ 
require_once("dbconnect.php");
$id = mysqli_escape_string($connect, $_GET['IDOrder'] );
  $OrderTheme = mysqli_escape_string($connect, $_POST['OrderTheme'] ); 
  $OrderNumber = mysqli_escape_string($connect, $_POST['OrderNumber'] ); 
  $OrderDate = mysqli_escape_string($connect, $_POST['OrderDate'] ); 
  
  $query = "UPDATE orders SET OrderTheme='".$OrderTheme."', OrderNumber='".$OrderNumber."',
OrderDate='".$OrderDate."' 
   WHERE IDOrder=".$id;
   
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
  $query = "DELETE FROM orders WHERE IDOrder=".$id; 
  mysqli_query ($connect, $query ); 
 // die(var_dump($_POST, $_GET, $id));
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
} 
  
?>