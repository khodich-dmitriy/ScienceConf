<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="favicon.ico" rel="shortcut icon">
        <link rel="stylesheet" href="css/style.css">
        <title>Добавление города</title>
    </head>

    <body>
        <form name="addform" action="?action=add" method="POST"> 
		<div class="col_66">
            <table class="table" > 
                <tr> 
                    <td style="color: #fff;">Город</td>
                    <td><input type="text" name="City" value="" required="" /></td>
                </tr>

                <tr> 
                    <td style="color: #fff;">Страна</td>
                    <td style="color: #000;">
                        <?php
                            require("dbconnect.php");
                            $sql = "SELECT * FROM countries";
                            $result_select = mysqli_query($connect, $sql);

                            /*Выпадающий список*/
                            echo "<select  name = CodeCountry>";
                            while($arr = mysqli_fetch_array($result_select)) {
                                echo "<option value = '$arr[0]' > $arr[1]</option>";
                            }
                            echo "<option value = '' > </option>";echo "</select>";
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><input type="submit" value="Добавить"></td>
                    <td><button type="button" onClick="history.back();">Отменить</button></td>
                </tr>
            </table>
        </form>
    </body>
</html>
