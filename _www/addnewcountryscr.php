<?php
require_once("dbconnect.php");

/* Проверяем если в глобальном массиве $_POST существуют данные отправленные из формы и заключаем переданные данные в обычные переменные. Таким образом, мы застраховываемся от хостингов, которые не поддерживают глобальные переменные. */
if(isset($_POST["r_country"])){ $r_country = $_POST["r_country"]; }
if(isset($_POST["r_addcountry"])){ $r_addcountry = $_POST["r_addcountry"]; }

/* Проверяем если была нажата кнопка зарегистрироваться. Если да, то вводим информацию в БД, иначе, значит что кнопка не была нажата, и пользователь зашел на страницу напрямую. Поэтому выводим ему сообщение об этом. */
if(isset($r_addcountry))
{
	print_r($r_country);
/* Формируем запрос к БД для ввода данных */
$query = " INSERT INTO `countries`(`Country`) VALUES ('$r_country')";

$result = mysqli_query($connect, $query) or die ( "Error : ".mysqli_error($connect) );


// Если все нормально то выводим сообщение.
if($result)
{
	//header('Location: /tableofcountries.php');

  }
  
    echo '</tbody>';
  echo '</table>';
echo"Good! <a href='addnewevent.php'>Come Back.</a> ";
exit();
}

else{
	echo "Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. 
Вы <a href='index.php'>";
}
?>