<form method="post" enctype="multipart/form-data">
	Jméno:<br>
	<input type="text" name="firstname"><br>
	Příjmení:<br>
	<input type="text" name="lastname"><br>
	Soubor:<br>
	<input type="file" name="upload"><br>
	<input type="submit">
</form>

<?php

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$file = $_FILES["upload"];

$toIntl = Array('ä'=>'a','Ä'=>'A','á'=>'a','Á'=>'A','à'=>'a','À'=>'A','ã'=>'a','Ã'=>'A','â'=>'a','Â'=>'A','č'=>'c','Č'=>'C','ć'=>'c','Ć'=>'C','ď'=>'d','Ď'=>'D','ě'=>'e','Ě'=>'E','é'=>'e','É'=>'E','ë'=>'e','Ë'=>'E','è'=>'e','È'=>'E','ê'=>'e','Ê'=>'E','í'=>'i','Í'=>'I','ï'=>'i','Ï'=>'I','ì'=>'i','Ì'=>'I','î'=>'i','Î'=>'I','ľ'=>'l','Ľ'=>'L','ĺ'=>'l','Ĺ'=>'L','ń'=>'n','Ń'=>'N','ň'=>'n','Ň'=>'N','ñ'=>'n','Ñ'=>'N','ó'=>'o','Ó'=>'O','ö'=>'o','Ö'=>'O','ô'=>'o','Ô'=>'O','ò'=>'o','Ò'=>'O','õ'=>'o','Õ'=>'O','ő'=>'o','Ő'=>'O','ř'=>'r','Ř'=>'R','ŕ'=>'r','Ŕ'=>'R','š'=>'s','Š'=>'S','ś'=>'s','Ś'=>'S','ť'=>'t','Ť'=>'T','ú'=>'u','Ú'=>'U','ů'=>'u','Ů'=>'U','ü'=>'u','Ü'=>'U','ù'=>'u','Ù'=>'U','ũ'=>'u','Ũ'=>'U','û'=>'u','Û'=>'U','ý'=>'y','Ý'=>'Y','ž'=>'z','Ž'=>'Z','ź'=>'z','Ź'=>'Z');

if (!empty($firstname) AND !empty($lastname) AND !empty($file)) {
	$pattern = "/^[a-zA-ZäÄáÁàÀãÃâÂčČćĆďĎěĚéÉëËèÈêÊíÍïÏìÌîÎľĽĺĹńŃňŇñÑóÓöÖôÔòÒõÕőŐřŘŕŔšŠśŚťŤúÚůŮüÜùÙũŨûÛýÝžŽźŹ]*-?[a-zA-ZäÄáÁàÀãÃâÂčČćĆďĎěĚéÉëËèÈêÊíÍïÏìÌîÎľĽĺĹńŃňŇñÑóÓöÖôÔòÒõÕőŐřŘŕŔšŠśŚťŤúÚůŮüÜùÙũŨûÛýÝžŽźŹ]*$/";

	if (preg_match($pattern, $firstname) + preg_match($pattern, $lastname) == 2) {
		$first = strtolower(strtr($firstname, $toIntl));
		$last = strtolower(strtr($lastname, $toIntl));
		$ext = end((explode(".", $file["name"])));

		$fileName = $first.'_'.$last.'.'.$ext;

		if (move_uploaded_file($file["tmp_name"], basename($fileName))) {
			echo "Soubor $fileName nahrán.";
		} else {
			echo "Soubor $fileName se nepodařilo nahrát.";
		}
	} else {
		echo "Jméno a příjmení mohou obsahovat pouze velká a malá písmena české abecedy, případně jednu pomlčku (mezi textem).";
	}
} else {
	echo "Musíte vyplnit všechna pole.";
}

?>