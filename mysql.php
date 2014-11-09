<?php

$ngram=$_GET['ngram'];
if (($ngram=="") || !isset($ngram)) {

echo "Error";
die();
}


try {
$sql = "SELECT * FROM ngrams WHERE ngram ='".$ngram."' ORDER by year asc";
$conn = new PDO('mysql:host=localhost;dbname=parligram', '<USER>', '<PASSWORD>');
$q = $conn->query($sql);
$result = $q->setFetchMode(PDO::FETCH_ASSOC);
} catch  (PDOException $pe) {
                die("Could not connect to the database:" . $pe->getMessage());
}

$out = array();
while ($r = $q->fetch()) {
$out[$r['year']] = $r;
}



echo json_encode($out);

?>
