<form method="post" enctype="multipart/form-data">
	Jméno:<br>
	<input type="text" name="firstname"><br>
	Příjmení:<br>
	<input type="text" name="lastname"><br>
	Obrázek:<br>
	<input type="file" name="image"><br>
	<input type="submit">
</form>

<?php

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$image = $_FILES["image"];

if (!empty($firstname) AND !empty($lastname) AND !empty($image)) {
	$pattern = "/^[a-zA-ZäÄáÁàÀãÃâÂčČćĆďĎěĚéÉëËèÈêÊíÍïÏìÌîÎľĽĺĹńŃňŇñÑóÓöÖôÔòÒõÕőŐřŘŕŔšŠśŚťŤúÚůŮüÜùÙũŨûÛýÝžŽźŹ]*-?[a-zA-ZäÄáÁàÀãÃâÂčČćĆďĎěĚéÉëËèÈêÊíÍïÏìÌîÎľĽĺĹńŃňŇñÑóÓöÖôÔòÒõÕőŐřŘŕŔšŠśŚťŤúÚůŮüÜùÙũŨûÛýÝžŽźŹ]*$/";

	if (preg_match($pattern, $firstname) + preg_match($pattern, $lastname) == 2) {
		$ext = end((explode(".", strtolower($image["name"]))));
		$allowedExtensions = array("jpg","gif");

		if (in_array($ext, $allowedExtensions)) {
			$fileName = "obrazek.".$ext;

			if (move_uploaded_file($image["tmp_name"], basename($fileName))) {
				echo "Soubor $fileName nahrán.<br>";
			} else {
				echo "Soubor $fileName se nepodařilo nahrát.<br>";
			}

			$file = fopen("jmena.txt", "a+");
			if (fwrite($file, "$firstname $lastname\r\n")) {
				echo "Jméno zapsáno do souboru jmena.txt.";
			} else {
				echo "Jméno se nepodařílo zapsat do souboru jmena.txt.";
			}
			fclose($file);
		} else {
			echo "Obázek může být pouze typu jpg nebo gif.";
		}
	} else {
		echo "Jméno a příjmení mohou obsahovat pouze velká a malá písmena české abecedy, případně jednu pomlčku (mezi textem).";
	}
} else {
	echo "Musíte vyplnit všechna pole.";
}

?>