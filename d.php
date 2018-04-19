<form method="post" enctype="multipart/form-data">
	Jméno:<br>
	<input type="text" name="name"><br>
	Obrázek:<br>
	<input type="file" name="image"><br>
	<input type="submit">
</form>

<?php

$name = $_POST["name"];
$image = $_FILES["image"];

if (!empty($name) AND !empty($image)) {
	$pattern = "/^[a-zäáàãâčćďěéëèêíïìîľĺńňñóöôòõőřŕšśťúůüùũûýžź -_]+$/";

	if (preg_match($pattern, $name)) {
		$noSpace = preg_replace("/\s/", "-", $name);

		$ext = end((explode(".", strtolower($image["name"]))));
		$allowedExtensions = array("jpg","gif","png");

		if (in_array($ext, $allowedExtensions)) {
			$fileName = $testName = $noSpace.'.'.$ext;

			while (file_exists($testName)) {
				$ne = explode(".", $testName);
				$testName = $ne[0]."x.".$ne[1];
			}

			rename($fileName, $testName);

			if (move_uploaded_file($image["tmp_name"], basename($fileName))) {
				echo "Soubor $fileName nahrán.<br>";
			} else {
				echo "Soubor $fileName se nepodařilo nahrát.<br>";
			}
		} else {
			echo "Obázek může být pouze typu png, jpg nebo gif.";
		}
	} else {
		echo "Jméno může obsahovat pouze malá písmena české abecedy, mezeru, pomlčku a podtržítko.";
	}
} else {
	echo "Musíte vyplnit všechna pole.";
}

?>