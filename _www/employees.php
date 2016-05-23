<?php
session_start();
require("dbconnect.php");

// Проверяем если существуют данные в сессий.
if(isset($_SESSION['email']) && isset($_SESSION['password']) ){

// Вставляем данные из сессий в обычные переменные
$email = $_SESSION['email'];
$password = $_SESSION['password'];

// Делаем запрос к БД для выбора данных.
$query = " SELECT * FROM profiles WHERE Email = '$email' AND Password = '$password'";
$result = mysqli_query($connect, $query) or die ( "Error : ".mysqli_error($connect) ); 

/* Проверяем, если в базе нет пользователей с такими данными, то выводим сообщение об ошибке */
	if(mysqli_num_rows($result) < 1)
	{
		echo "Вход доступен только авторизированным пользователям! Перейти на <a href='index.php'>главную страницу</a>";
	}

} else {
	echo "Вход доступен только авторизированным пользователям! Перейти на <a href='index.html'>главную страницу</a>";
	die();
}
?>
<html>
<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
         <!-- CSS
         ================================================== -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <!-- FontAwesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css"/>
        <!-- Animation -->
        <link rel="stylesheet" href="css/animate.css" />
        <!-- Owl Carousel -->
        <link rel="stylesheet" href="css/owl.carousel.css"/>
        <link rel="stylesheet" href="css/owl.theme.css"/>
        <!-- Pretty Photo -->
        <link rel="stylesheet" href="css/prettyPhoto.css"/>
        <!-- Main color style -->
        <link rel="stylesheet" href="css/red.css"/>
        <!-- Template styles-->
        <link rel="stylesheet" href="css/custom.css" />
        <!-- Responsive -->
        <link rel="stylesheet" href="css/responsive.css" />
        <link rel="stylesheet" href="css/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
		  <link rel="stylesheet" href="css/demo.css">

  <!-- Стили для адаптивного фонового изображения -->
  <link rel="stylesheet" href="css/styleimg.css">
	
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,500' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/style.css">
  <title>Сотрудники</title>  
  
</head>
<body>

<form action="" method="post" name="r_form2" >


  <header id="section_header" class="navbar-fixed-top main-nav" role="banner">
    	<div class="container">

     <nav class="collapse navbar-collapse navigation" id="bs-example-navbar-collapse-1" role="navigation">
                        <ul class="nav navbar-nav navbar-right">
								<li><a href="mainform.php">Main</a></li>
										<li><a href="addnewuser.php">Пользователи</a></li>
										<li><a href="tableofevents.php">Мероприятия</a></li><li><a href="tableofeventsFull.php">Мероприятия для Админа</a></li>
										<li  class="active"><a href="addnewdictionary.php">Справочники</a></li>
										<li><a href="addnewreport.php">Генерация отчетности</a></li>
										<li><a href="addnewtables.php">Другие таблицы</a></li>
										<li></li>
										<li><a href="exit.php">Выйти</a></li>
                        </ul>
     </nav>
	   </div>
	   
    </header>
<div class="container">
<header class="container">
    <section class="content">
      <h1></h1>
      <p class="sub-title"><strong></strong> <br /></p>
    </section>
 </header>
 </div>
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

 
$sql = "SELECT * FROM employees";
require("dbconnect.php");
$res = mysqli_query($connect, $sql);

  echo '<h2>Сотрудники</h2>'; 
  echo '<div class="col_66">';
    echo '<table border="1" class="table">';      
   
  echo '<tr><th>ID</th><th>ФИО</th><th>Должность</th><th>Степень</th><th>Звание</th><th>Телефон</th>
  <th>E-mail</th><th>Кафедра</th><th></th><th></th></tr>'; 
  while ( $item = mysqli_fetch_array( $res ) ) 
  { 
    echo '<tr class="my-bold-font">';  
    echo '<td>'.$item['IDEmployee'].'</td>'; 
    echo '<td>'.$item['FIO'].'</td>'; 
    
    $sql2 = "SELECT `Post` FROM `posts` WHERE IDPost = ".$item['CodePost'];
    $res2 =  mysqli_query($connect, $sql2);
    echo '<td>'.mysqli_fetch_array( $res2 )['Post'].'</td>';

    $sql3 = "SELECT `Degree` FROM `degrees` WHERE IDDegree = ".$item['CodeDegree'];
    $res3 =  mysqli_query($connect, $sql3);
    echo '<td>'.mysqli_fetch_array( $res3 )['Degree'].'</td>';

    $sql4 = "SELECT `Rank` FROM `ranks` WHERE IDRank = ".$item['CodeRank'];
    $res4 =  mysqli_query($connect, $sql4);
    echo '<td>'.mysqli_fetch_array( $res4 )['Rank'].'</td>';

    echo '<td>'.$item['Phone'].'</td>'; 
    echo '<td>'.$item['Email'].'</td>'; 
	
	$sql5 = "SELECT `Cathedra` FROM `cathedrae` WHERE IDCathedra = ".$item['CodeCathedra'];
    $res5 =  mysqli_query($connect, $sql5);
	if ($res5 != NULL)
	{
		 echo '<td>'.mysqli_fetch_array( $res5 )['Cathedra'].'</td>';
	}
	else
	{
		echo '<td></td>';
	}
   
	
    echo '<td><a href="?action=editform&id='.$item['IDEmployee'].'">Ред.</a></td>'; 
    echo '<td><a href="?action=delete&id='.$item['IDEmployee'].'">Удл.</a></td>'; 
    echo '</tr>'; 
  } 
  echo '</table>';
  echo '<p><a href="'.$_SERVER['PHP_SELF'].'?action=addform">Добавить</a></p>';  
} 


// Функция формирует форму для добавления записи в таблице БД 
function get_add_item_form() 
{ 
include("templates/addEmployee.php");
 
}


// Функция добавляет новую запись в таблицу БД  
function add_item() 
{ 
require("dbconnect.php");
  $FIO = mysqli_escape_string($connect, $_POST['FIO'] ); 
  $CodePost = mysqli_escape_string($connect, $_POST['CodePost'] ); 
  $CodeDegree = mysqli_escape_string($connect, $_POST['CodeDegree'] ); 
  $CodeRank = mysqli_escape_string($connect, $_POST['CodeRank'] ); 
  $Phone = mysqli_escape_string($connect, $_POST['Phone'] ); 
  $Email = mysqli_escape_string($connect, $_POST['Email'] ); 
  $CodeCathedra = mysqli_escape_string($connect, $_POST['CodeCathedra'] ); 
   $query = "INSERT INTO `employees`(`FIO`, `CodePost`, `CodeDegree`, `CodeRank`,`Email`,`Phone`,`CodeCathedra`) 
   VALUES ('$FIO','$CodePost','$CodeDegree','$CodeRank','$Email','$Phone','$CodeCathedra')";
  mysqli_query ($connect, $query ); 
  //die(var_dump($_POST, $_GET, $Email));
 //error_reporting(E_ALL);
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
}

// Функция формирует форму для редактирования записи в таблице БД 
function get_edit_item_form() 
{ 
  require("dbconnect.php");
  echo '<h2>Редактировать</h2>'; 
  $id = empty($_GET["id"]) ? 0 : intval($_GET["id"]);
  $query = 'select * from employees WHERE IDEmployee ='.$id; 
  
  $res = mysqli_query($connect ,$query ); 
  $item = mysqli_fetch_array( $res ); 
  include("templates/updateEmployee.php");
} 

// Функция обновляет запись в таблице БД  


function update_item() 
{ 
  require("dbconnect.php");
  $id = mysqli_escape_string($connect, $_GET['IDEmployee'] );
  $FIO = mysqli_escape_string($connect, $_POST['FIO'] ); 
  $CodePost = mysqli_escape_string($connect, $_POST['CodePost'] ); 
  $CodeDegree = mysqli_escape_string($connect, $_POST['CodeDegree'] ); 
  $CodeRank = mysqli_escape_string($connect, $_POST['CodeRank'] ); 
  $Phone = mysqli_escape_string($connect, $_POST['Phone'] ); 
  $Email = mysqli_escape_string($connect, $_POST['Email'] ); 
  $CodeCathedra = mysqli_escape_string($connect, $_POST['CodeCathedra'] ); 
  $query = "UPDATE employees SET FIO='".$FIO."', Phone ='".$Phone
  ."', Email = '".$Email."', CodePost = '".$CodePost."', CodeDegree = '"
  .$CodeDegree."', CodeRank = '".$CodeRank."', CodeCathedra = '".$CodeCathedra."' WHERE IDEmployee=".$id;
   
  mysqli_query ($connect, $query ); 
   // die(var_dump($_POST, $_GET, $id));
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
} 

// Функция удаляет запись в таблице БД 
function delete_item() 
{ 
  require("dbconnect.php");
  $id = empty($_GET["id"]) ? 0 : intval($_GET["id"]);
  $query = "DELETE FROM employees WHERE IDEmployee=".$id; 
  mysqli_query ($connect, $query ); 
 // die(var_dump($_POST, $_GET, $id));
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
} 
  
?>