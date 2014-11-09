<?php
 
//$startYear = 1973;
//$endYear = 2014;
$i = $argv[1];


// Build Ngrams by year
$sql="";
//for ($i=$startYear; $i<=$endYear; $i++) {

	echo "Elaborating year $i...\n";
        $totalText = "";
	try {
		$conn = new PDO('mysql:host=;dbname=', '', '');

		$sql = "SELECT text FROM speeches WHERE date LIKE '".$i."-%'";

		$q = $conn->query($sql);
		$q->setFetchMode(PDO::FETCH_ASSOC);

	} catch (PDOException $pe) {
		die("Could not connect to the database $dbname :" . $pe->getMessage());
	}
	while ($r = $q->fetch()) {
		$totalText = $totalText."\n".$r['text'];
	}
	// n-grams
	$countDays = 30;
	$words = preg_split('/[\s]+/', $totalText, -1, PREG_SPLIT_NO_EMPTY);	
	$totlen=count($words);
	$myfile1 = fopen("1-gram/$i.txt", "w") or die("Unable to open file!");
	$year1Array=array_count_values(str_word_count($totalText,2));
        foreach ($year1Array as $key => $value) {
                $string="$key\t$i\t$value\n";
                fwrite($myfile1, $string);
        }
	fclose($myfile1);

	$myfile2 = fopen("2-gram/$i.txt", "w") or die("Unable to open file!");
	//$myfile3 = fopen("3-gram/$i.txt", "w") or die("Unable to open file!");
	//$myfile4 = fopen("4-gram/$i.txt", "w") or die("Unable to open file!");
	//$myfile5 = fopen("5-gram/$i.txt", "w") or die("Unable to open file!");

	$n2g = array();
	//$n3g = array();
	//$n4g = array();
	//$n5g = array();
		
	$k=0;
	for($k=0;$k<$totlen-4;$k++) {
		$n2g[] = $words[$k]." ".$words[$k+1];
		//$n3g[] = $words[$k]." ".$words[$k+1]." ".$words[$k+2];
		//$n4g[] = $words[$k]." ".$words[$k+1]." ".$words[$k+2]." ".$words[$k+3];
		//$n5g[] = $words[$k]." ".$words[$k+1]." ".$words[$k+2]." ".$words[$k+3]." ".$words[$k+4];
		// DEBUG for missing final words
		// if ($k==$totlen-5) {
		//	echo $words[$k]." ".$words[$k+1]." ".$words[$k+2]." ".$words[$k+3]." ".$words[$k+4]."\n";
		//}
	}

	// Missing final words
	//$n4g[] = $words[$k]." ".$words[$k+1]." ".$words[$k+2]." ".$words[$k+3];
	//echo "4: ".$words[$k]." ".$words[$k+1]." ".$words[$k+2]." ".$words[$k+3]."\n";

	//$n3g[] = $words[$k]." ".$words[$k+1]." ".$words[$k+2];
	//$n3g[] = $words[$k+1]." ".$words[$k+2]." ".$words[$k+3];
	//echo "3: ".$words[$k]." ".$words[$k+1]." ".$words[$k+2]."\n";
	//echo "3: ".$words[$k+1]." ".$words[$k+2]." ".$words[$k+3]."\n";

	$n2g[] = $words[$k]." ".$words[$k+1];
	$n2g[] = $words[$k+1]." ".$words[$k+2];
	$n2g[] = $words[$k+2]." ".$words[$k+3];
	//echo "2: ".$words[$k]." ".$words[$k+1]."\n";	
	//echo "2: ".$words[$k+1]." ".$words[$k+2]."\n";
	//echo "2: ".$words[$k+2]." ".$words[$k+3]."\n";


	$year2Array=array_count_values($n2g);
	//$year3Array=array_count_values($n3g);
	//$year4Array=array_count_values($n4g);
	//$year5Array=array_count_values($n5g);

	        foreach ($year2Array as $key => $value) {
                $string="$key\t$i\t$value\n";
                fwrite($myfile2, $string);
        }
	fclose($myfile2);
        //foreach ($year3Array as $key => $value) {
        //        $string="$key\t$i\t$value\n";
        //        fwrite($myfile3, $string);
        //}
        //foreach ($year4Array as $key => $value) {
        //        $string="$key\t$i\t$value\n";
        //        fwrite($myfile4, $string);
        //}
        //foreach ($year5Array as $key => $value) {
        //        $string="$key\t$i\t$value\n";
        //        fwrite($myfile5, $string);
        //}



	//fclose($myfile3);
	//fclose($myfile4);
	//fclose($myfile5);
	
//}

?>

