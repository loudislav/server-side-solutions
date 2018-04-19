<?php

$dbhost = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "serverside";
$surname = "asdf";

?>

<form method="post">
	Jméno:<br>
	<input type="text" name="firstname"><br>
	Příjmení:<br>
	<input type="text" name="lastname"><br>
	Email:<br>
	<input type="email" name="email"><br>
	Telefon:<br>
	<input type="tel" name="phone"><br>
	<input type="submit">
</form>

<?php

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$phone = $_POST["phone"];

$db = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

$tableName = date("Ymd").$surname;

// Create table
mysqli_query($db, "create table $tableName if not exists (firstname varchar(64) not null, lastname varchar(64) not null, email varchar(64) not null, phone varchar(64) not null)");

// Sava data
if (!empty($firstname) AND !empty($lastname) AND !empty($email) AND !empty($phone)) {
	$patternName = "/^[A-ZÄÁÀÃÂČĆĎĚÉËÈÊÍÏÌÎĽĹŃŇÑÓÖÔÒÕŐŘŔŠŚŤÚŮÜÙŨÛÝŽŹ]{1}[a-zäáàãâčćďěéëèêíïìîľĺńňñóöôòõőřŕšśťúůüùũûýžź]+$/";
	$patternEmail = "/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/";
	$patternPhone = "/^[0-9]{9}$/";

	if (preg_match($patternName, $firstname) + preg_match($patternName, $lastname) + preg_match($patternEmail, $email) + preg_match($patternPhone, $phone) == 4) {
		mysqli_query($db, "insert into $tableName values ('$firstname', '$lastname', '$email', '$phone')");
	} else {
		echo "Jméno a příjmení musí začínat velkým písmenem a dále pokračovat malými písmeny české abecedy. Email musí být ve správném tvaru. Telefon musí obsahovat devět číslic bez předvolby.";
	}
} else {
	echo "Musíte vyplnit všechna pole.";
}

// Show data
$people = mysqli_query($db, "select * from $tableName");

?>
<table>
	<tr><th>Jméno</th><th>Příjmení</th><th>Email</th><th>Telefon</th></tr>
<?php

while ($row = mysqli_fetch_array($people)) {
	echo "<tr><td>$row[firstname]</td><td>$row[lastname]</td><td>$row[email]</td><td>$row[phone]</td></tr>";
}

?>
</table>