<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href="favicon.ico" rel="shortcut icon">
	<link rel="stylesheet" href="css/style.css">
	<title>Обновить</title>  
</head>
<body>
	<form name="editform" action="?action=update&IDOrder=<?= htmlspecialchars($id) ?>" method="POST"> 

	<table class="table"> 
		<tr> 
			<td>Тема приказа</td> 
			<td><input type="text" name="OrderTheme" value="<?= htmlspecialchars($item["OrderTheme"]) ?>" /></td> 
		</tr> 

		<tr> 
			<td>Номер приказа</td> 
			<td><input type="number" name="OrderNumber" value="<?= htmlspecialchars($item["OrderNumber"]) ?>" /></td> 
		</tr> 

		<tr> 
			<td>Дата приказа</td> 
			<td><input type="date" name="OrderDate" value="<?= htmlspecialchars($item["OrderDate"]) ?>" /></td> 
		</tr> 

		<tr> 
			<td><input type="submit" value="Сохранить"></td> 
			<td><button type="button" onClick="history.back();">Отменить</button></td> 
		</tr> 

	</table> 
	</form> 
</body>
</html>