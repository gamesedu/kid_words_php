<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
/*
* Kid Words 
* v005 20150716a
* Changes:
* v005 20150716a : Varialbe button size and 
*To Do : 
*  -check if line is empty
*  -check for duplicates in same page
*  -Add GET for button size
*
*
*/
$debug=true;
$correct_word_points=10;
$words_per_page=3;
$max_word_size=8;
$min_word_size=3;

$input_file_name="leskeis_ellinikes_list2d.txt";
$button_size=' style="width:200px; height:200px;" ';
$button_radio_size=' style="width:30px; height:30px;" ';


//$score_for_all_words=$correct_word_points*$words_per_page;

if (isSet($_REQUEST["words_per_page"]))  {
	$words_per_page=$_REQUEST["words_per_page"];
	
	//maybe set a maximum value
}
//if($debug) echo "<h3>hello $words_per_page</h3>";
if (isSet($_REQUEST["score"]))  {
	$score=$_REQUEST["score"];
	if (isSet($_REQUEST["correct"])){
		$score_for_all_words=$correct_word_points*$words_per_page;
		$score=$score+$score_for_all_words;
		echo '<H1 style="color:red" > ΜΠΡΑΒΟ!!! Κέρδισες '.$score_for_all_words.' πόντους </h1>';
		}
}else {
	$score=0;
}//if ($_REQUEST["score"]!=0)  {


//$input_file_name="leskeis_ellinikes_list.txt";
//$input_file_name="leskeis2_special_ellinikes_list.txt";

//if($debug) echo "hello";

//$dir_initial='j:/devl_j/greek-lexika_words_/';
$dir_initial='./';


//foreach ($files_list_array as $value) {
// $value=str_replace($dir,"",$value);
if($words_per_page==1) {echo "<h2>Η ΝΕΑ ΛΕΞΗ ΕΙΝΑΙ:<h2>";} else {echo "<h2>ΟΙ ΝΕΕΣ ΛΕΞΕΙΣ ΕΙΝΑΙ:<h2>";};
for($i=0;$i<$words_per_page;$i++){
	$a_random_line = trim(RandomLine()); 
	$line_text="";
	$a_random_line=split_line($a_random_line);
	//$a_random_line = str_replace(" ", "", $a_random_line);
	//mb_strlen($string, 'UTF-8')
	//while((strlen($a_random_line) <$max_word_size)&& (strlen($a_random_line) >$min_word_size))
//	while((mb_strlen($a_random_line, 'UTF-8') <= $max_word_size) && (mb_strlen($a_random_line, 'UTF-8') >= $min_word_size))
	while((mb_strlen($a_random_line, 'UTF-8') >= $max_word_size) || (mb_strlen($a_random_line, 'UTF-8') <= $min_word_size))
	{
		$a_random_line = trim(RandomLine());
		//$a_random_line = str_replace(" ", "", $a_random_line);
		 
		$a_random_line=trim(split_line($a_random_line));
		//if($debug) echo '<h1><li> '.$a_random_line.' mb - size: '.mb_strlen($a_random_line, 'UTF-8').'</h1>';
		//if($debug) echo '<h1><li> '.$a_random_line.' size: '.strlen($a_random_line).'</h1>';
	}
	$line_text=$a_random_line;
	//$line_text=split_line($line_text);
	//file_put_contents($file_to_write, $line_text, FILE_APPEND | LOCK_EX);
	//echo "<font size=12 font-size: 250% color=darkgreen > $line_text</font>";echo "<br>\n";
	//if($debug) echo "<h3>hello $i , $words_per_page <h3>";
	echo '<font style="font-size: 500%"  color=darkgreen >'. $line_text.'</font>' . ' <input type=checkbox '.$button_radio_size.' name=check >';
	//if($debug) echo '<br> size:'.mb_strlen($line_text, 'UTF-8');
	echo "<hr>\n";
} //for($i=0;$i<$words_per_page;$i++){

echo "<hr>Το σκορ σου είναι:$score";
//} //foreach ($files_list_array as $value) {

echo "<form method=GET>";

echo '<input type=HIDDEN name=words_per_page value='.$words_per_page.'>';
echo '<input type=HIDDEN name=score value='.$score.'>';
echo '<input type=HIDDEN name=new_page value=new_page >'; // for checking if we have a GET /POST request

echo '<input type=submit '.$button_size.' name=no value="ΛΑΘΟΣ">';
echo '<input type=submit '.$button_size.' name=next value="ΕΠΟΜΕΝΟ">';
echo '<input type=submit '.$button_size.' name=correct value="ΣΩΣΤΑ">';

echo "</form>";
// Return one rando line (not word)   -TO DO: check the line
function RandomLine() {
	global $input_file_name,$dir_initial;
	$textfile = $dir_initial.$input_file_name;
		if(file_exists($textfile)){ 
			$words =file($textfile); 
			$string = $words[array_rand($words)];
		} else {
			$string = "Error";
		}
		
	return $string;
}



function split_line($full_line){
	
	
	$words = explode(",", $full_line);
	
	$one_word = $words[array_rand($words)];
	//trim($one_word);
		while(strlen($one_word) <3 )
		{
			$one_word = $words[array_rand($words)];
			
		}
	return $one_word;
}
?>

</body>
</html>