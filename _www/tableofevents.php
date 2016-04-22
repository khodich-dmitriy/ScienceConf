<html>
<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="favicon.ico" rel="shortcut icon">
  <link rel="stylesheet" href="css/style.css">
  <title>Мероприятия</title>  
  
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

 
$sql = "SELECT * FROM events";
require_once("dbconnect.php");
$res = mysqli_query($connect, $sql);

  echo '<h2>Мероприятия</h2>'; 
  echo '<div class="col_66">';
    echo '<table border="1" class="table">';      
   
  echo '<tr><th>IDEvent</th><th>Название</th><th>Дата начала</th>
  <th>Дата окончания</th><th>Кафедра</th><th>Тип мероприятия</th>
  <th>Ссылка на пресс-релиз</th><th>Ссылка на пост-релиз-релиз</th>
  <th>Ред.</th><th>Удл.</th></tr>'; 
  while ( $item = mysqli_fetch_array( $res ) ) 
  { 
    echo '<tr>'; 
	echo '<td>'.$item['IDEvent'].'</td>'; 
    echo '<td>'.$item['EventName'].'</td>'; 
    echo '<td>'.$item['StartDate'].'</td>'; 
    echo '<td>'.$item['ExpirationDate'].'</td>'; 
	
	$sql2 = "SELECT `Cathedra` FROM `cathedrae` WHERE IDCathedra = ".$item['CodeCathedra'];
	$res2 =  mysqli_query($connect, $sql2);
	 echo '<td>'.mysqli_fetch_array( $res2 )['Cathedra'].'</td>'; 
	 $sql3 = "SELECT `EventType` FROM `eventtypes` WHERE  IDEventType = ".$item['CodeEventType'];
	$res3 =  mysqli_query($connect, $sql3);
	 echo '<td>'.mysqli_fetch_array( $res3 )['EventType'].'</td>'; 
		echo '<td>'.$item['PressReleaseRef'].'</td>'; 
    echo '<td>'.$item['PostReleaseRef'].'</td>'; 
    echo '<td><a href="?action=editform&id='.$item['IDEvent'].'">Ред.</a></td>'; 
    echo '<td><a href="?action=delete&id='.$item['IDEvent'].'">Удл.</a></td>'; 
    echo '</tr>'; 
  } 
  echo '</table>';
  echo '<p><a href="'.$_SERVER['PHP_SELF'].'?action=addform">Добавить</a></p>';  
} 


// Функция формирует форму для добавления записи в таблице БД 
function get_add_item_form() 
{ 
include("templates/add.php");
 
}


// Функция добавляет новую запись в таблицу БД  
function add_item() 
{ 
require_once("dbconnect.php");
  $EventName = mysqli_escape_string($connect, $_POST['EventName'] ); 
  $StartDate = mysqli_escape_string($connect, $_POST['StartDate'] ); 
  $ExpirationDate = mysqli_escape_string($connect, $_POST['ExpirationDate'] ); 
  $PressReleaseRef = mysqli_escape_string($connect, $_POST['PressReleaseRef'] ); 
  $PostReleaseRef = mysqli_escape_string($connect, $_POST['PostReleaseRef'] ); 
  $NumberOfTeachersDonNTU = mysqli_escape_string($connect, $_POST['NumberOfTeachersDonNTU'] ); 
  $Website = mysqli_escape_string($connect, $_POST['Website'] ); 
  $ReferenceToProgram = mysqli_escape_string($connect, $_POST['ReferenceToProgram'] ); 
  $ExpectedCountries = mysqli_escape_string($connect, $_POST['ExpectedCountries'] ); 
  $CodeCathedra = mysqli_escape_string($connect, $_POST['CodeCathedra'] ); 
   $CodeEventType = mysqli_escape_string($connect, $_POST['CodeEventType'] ); 
  $query = " INSERT INTO `events`(`EventName`, `StartDate`,`ExpirationDate`, `PressReleaseRef`,
 `PostReleaseRef`, `NumberOfTeachersDonNTU`,  `Website`, 
`ReferenceToProgram`, `ExpectedCountries`,
`CodeCathedra`,`CodeEventType`) 
 VALUES ('$EventName',' $StartDate','$ExpirationDate',
 ' $PressReleaseRef','$PostReleaseRef','$NumberOfTeachersDonNTU','$Website',
 '$ReferenceToProgram',' $ExpectedCountries','$CodeCathedra',
'$CodeEventType')"; 
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
  $query = 'select * from events WHERE IDEvent='.$id; 
  
  $res = mysqli_query($connect ,$query ); 
  $item = mysqli_fetch_array( $res ); 
  include("templates/update.php");
} 

// Функция обновляет запись в таблице БД  


function update_item() 
{ 
require_once("dbconnect.php");
$id = mysqli_escape_string($connect, $_GET['IDEvent'] );
  $EventName = mysqli_escape_string($connect, $_POST['EventName'] ); 
  $StartDate = mysqli_escape_string($connect, $_POST['StartDate'] ); 
  $ExpirationDate = mysqli_escape_string($connect, $_POST['ExpirationDate'] ); 
  $PressReleaseRef = mysqli_escape_string($connect, $_POST['PressReleaseRef'] ); 
  $PostReleaseRef = mysqli_escape_string($connect, $_POST['PostReleaseRef'] ); 
  $NumberOfTeachersDonNTU = mysqli_escape_string($connect, $_POST['NumberOfTeachersDonNTU'] ); 
  $Website = mysqli_escape_string($connect, $_POST['Website'] ); 
  $ReferenceToProgram = mysqli_escape_string($connect, $_POST['ReferenceToProgram'] ); 
  $ExpectedCountries = mysqli_escape_string($connect, $_POST['ExpectedCountries'] ); 
  $CodeCathedra = mysqli_escape_string($connect, $_POST['CodeCathedra'] ); 
   $CodeEventType = mysqli_escape_string($connect, $_POST['CodeEventType'] ); 
   $query = "UPDATE events SET EventName='".$EventName."', StartDate ='".$StartDate."' ,ExpirationDate = '".$ExpirationDate."',
  PressReleaseRef ='".$PressReleaseRef."', 
 PostReleaseRef = '".$PostReleaseRef."', NumberOfTeachersDonNTU = '".$NumberOfTeachersDonNTU."',  Website = '".$Website."', 
ReferenceToProgram = '".$ReferenceToProgram."', ExpectedCountries = '".$ExpectedCountries."',
CodeCathedra = '".$CodeCathedra."',CodeEventType = '".$CodeEventType."'
   WHERE IDEvent=".$id;
   
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
  $query = "DELETE FROM events WHERE IDEvent=".$id; 
  mysqli_query ($connect, $query ); 
 // die(var_dump($_POST, $_GET, $id));
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
} 
  
?>