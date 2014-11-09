<?php

if ($argc<2) {
	die("Not enough params\n");
}
$year = $argv[1];

// Get FileList
$path="/home/gsollazzo/data/debates";
$files=glob("$path/debates$year*.xml");


$conn = '';
try {
	$sql = "SELECT ngram FROM ngrams WHERE year='".$year."' AND count>1";
	$conn = new PDO('mysql:host=');
	$q = $conn->query($sql);
	$result = $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $pe) {
	die("Could not connect to the database $dbname :" . $pe->getMessage());
}
echo "Year $year";
$myfile = fopen("sql/$year.txt","w");

while ($r = $q->fetch()) {
	$ngram = $r['ngram'];
	$string = "";
	foreach ($files as $file) {
		// grep ngram $file
		$ret = preg_grep("/$ngram/", file($file));
		if (count($ret)>0) { 
			$string = "$file;$string";		
		}
	}
	$sql2="UPDATE ngrams SET filelist='".$string."' WHERE ngram='".$ngram."' AND year='".$year."'\n";
	fwrite($myfile, "$sql2");

}

fclose($myfile);


?>

