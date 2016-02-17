<!DOCTYPE html>
<html>
<head>
<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

<style>
body {background-color:lightgrey;}
h1   {color:blue;}
p    {color:green;}
table, th, td {
    border-bottom: 1px solid green;
    border-collapse: collapse;
    padding:5px;
}
td {
	font-family: Tahoma;
	font-size: 12px;
	color: #000000;
}
tr:nth-child(even) {background-color: #f2f2f2}
</style>
</head>
<?php
define('DACCESS',1);
include 'includes/defines.php';
include 'libraries/Database.php';
include 'classes/openITIreland/class.nielsen.php';
$db = new Database;

$stage = $_GET['stage'];
$file = '/'.$_GET['file'];

$fileParsed = explode('_',$file);
$imgFolder = $fileParsed[0].'_'.$fileParsed[1].'_'.$fileParsed[2].'_'.$fileParsed[3].'_'.substr($fileParsed[4],0,2).'.img';
$userId = $_GET['file'];

$BIC_Category_map = array('A'=>'Art','B'=>'Biography','C'=>'Language','D'=>'Literature','F'=>'Fiction',
		'G'=>'Guide book/Reference book','H'=>'Humanities','J'=>'Society','K'=>'Business', 'L'=>'Law','M'=>'Medicine',
		'P'=>'Science','R'=>'Earth Sciences',
		'U'=>'Technology','V'=>'Lifestyle', 'W'=>'Lifestyle','Y'=>'Children');
foreach ($BIC_Category_map as $code=>$name){
	$sql = 'select * from categories where Name = "'. $name.'"';
	$db->query($sql);
	$category  = $db->loadobject();
	$categoryids[$code] =   $category->id;
}
$xml = file_get_contents(dirname(__FILE__).$file);
$xml = simplexml_load_string($xml);

$authorCount = 0; $authorsFound = 0; $authorsNotFound = 0; $authorsCreated = 0; $duplicate_authorNames=0;
$totalBooks = 0;$booksFound=0; $booksNotFound=0; $booksCreated = 0;$imagesFound=0;$imagesNotFound=0;
$publishersCreated = 0; $publishersFound=0; $publishersNotFound=0; 
$xml_bookHasNoAuthors=0;
echo '<a name="top"></a><a href="#stats">[...]</a>';
echo formatHeader();

foreach($xml->Product as $key=>$product) {		// ***** start Product (Book) Loop
	$book = new nielsen_XML_Product();
	$isbn13 = $product->RecordReference;

	$bookFound = $book->getByISBN13($db,$isbn13);

	$totalBooks++;
	if($bookFound) $booksFound++;
	else $booksNotFound++;
	
	/*	Title	*/
	$title = $book->xmlToTitle($product);
	$fTitle = $title;
	$title = $db->getQuotedString($title);
	
	if($bookFound) 
		$fTitle='<a href = "./publish/&edit?id='.$book->book->id.'" target="blank">'.$title.'</a>';
	
	/*	Authors	*/
	$authors = $book->getAuthors($db, $product);
		$authorCount 			+= $book->authorCount;
		$authorsFound 			+= $book->authorsFound;
		$authorsNotFound 		+= $book->authorsNotFound;
		$duplicate_authorNames 	+= $book->duplicate_authorNames;
/*	echo '
		$authorCount 			+='. $authorCount.'
		$authorsFound 			+='. $authorsFound.'
		$authorsNotFound 		+='. $authorsNotFound.'
		$duplicate_authorNames 	+='. $duplicate_authorNames.'<br>
			'	; */
	if($authors) { /* at least one in XML */
		if($stage){
			$num = $book->createAuthors($db,$userId);
			$authorsCreated += $num;
	//		var_dump($book->authorIDs);
		}
		$authorStr = $book->formatAuthors();
	}
	else { 
		$authorStr = '<span style="color:red">*Author not provided</span>';
		$xml_bookHasNoAuthors++;
	}
	
	/*	Genre, Category ID */
	$BICCode = $product->BICMainSubject ;
	$cat1 = substr($BICCode,0,1);
	$categoryName = $BIC_Category_map[$cat1];
	$categoryID = $categoryids[$cat1];
//	echo '<b>Category = </b>'.$categoryName.' ('.$categoryID.')';
	
	/*	Image	*/
	$image = $book->getImage($product);
	if((!$image == '') && (file_exists(dirname(__FILE__). $imgFolder. '/'. $image) )) {
		$imageSrc = $imgFolder.'/'.$image;
		$imagesFound++;
	}
	else {
		$imagesNotFound++;
		$imageSrc='';
	}
	
	/*	Publisher	*/
	$publisherName = $book->getPublisher($product);
	$publisherExists = $book->checkPublisherExists($db,$publisherName);
	if($publisherExists) $publishersFound++;
	else $publishersNotFound++;
	
	if(($stage) && (!$publisherExists)) {
		$book->createPublisher($db, $publisherName);
		$publisherExists = true; 
		$publishersCreated++;
	}
		
	if ($publisherExists) {
		$publisherNameStr = '<a href="./admin/edit?company='.base64_encode($publisherName).'" target="blank">'.$publisherName.'</a>';
	}
	else { 
		$publisherNameStr = $publisherName;
	}
	$publisher_url = $book->publisher_url; // required for DB only
	
	/*	Published Date */
	$publicationDate = $book->getPublishedDate($product);

	$form = '';
	$book->getProductForm($product);
	$hardback=false;$paperback=false;$audio=false;$ebook=false;
	if($book->hardback) {
		$form = 'Hardback';
		$hardback = true;
	}
	if($book->paperback) {
		$form = 'Paperback';
		$paperback = true;
	}
	if($book->audio) {
		$form = 'Audio';
		$audio = true;
	}
	if($book->ebook) {
		$form = 'e-book';
		$ebook = true;
	}
	if($stage) {
		/*	Languages	*/
		$languages = $book->formatLanguages($db,$product);
		
		/* Tags */
		$tags = $book->getTags($product);
		
		/* Synopsis	*/
		$synopsis = $db->getQuotedString($book->getSynopsis($product));

		/* Pages*/
		$pages = $book->getPages($product);
		
		$lastupdated = date('Ymd');
		if ($bookFound == false ) {	/* create Book */
			$sql = 'insert into publications
			(title, publisher, publisherurl, genre, categoryid, area, synopsis, lastupdated, published, image, hardback,
			paperback, ebook, audio, pages, isbn13, language, user_id )
			values ("'.$title.'","'.$publisherName.'","'.$publisher_url.'","'.$categoryName.'","'.$categoryID.
					'","'.$tags.'","'.$synopsis.'","'.$lastupdated.'","'.$publicationDate.
					'","'.$image.'","'.$hardback.'","'.$paperback.'","'.$ebook.'","'.$audio.'","'.
					$pages.'","'.$isbn13.'","'.$languages.'","'.$userId.'")';
			//		echo $sql;
			$db->query($sql);
			$bookid = $db->getLastId();
			$fTitle = '<a href = "./publish/&edit?id='.$bookid.'" target="blank">'.$title.'</a>';
			$booksCreated++;
			
//			var_dump($book->authorIDs);
			if($authors) {
				foreach($book->authorIDs as $sequence=>$authorid) {
					$sql = 'insert into author_x_book (authorid, bookid, sequence) values ('.$authorid.','.$bookid.','.$sequence.')';
					$db->query($sql);
//					echo $sql.'<br>';
				}
			//echo 'Book Created with ID: '.$bookid;
			}
			if((!$image == '') && (file_exists(dirname(__FILE__). $imgFolder. '/'. $image) )) {
				$image_parse = explode('.',$image);
				$extension = end($image_parse);
				$image_src_location = dirname(__FILE__). $imgFolder. '/'. $image;
				$image_dest_location = 'upload/'. $bookid.'.'.$extension	;
				$copied = copy($image_src_location,$image_dest_location);
			//	echo '<br><b>Image:</b>' .$image_src_location;
		
				/* update the book with the image name*/
				$sql = 'update publications set image = "'.$bookid.'.'.$extension.'" where id = '. $bookid ;
				$db->query($sql);
			}
		}
	}
	echo formatRow($imageSrc,$isbn13,$fTitle,$categoryName,$authorStr,$publisherNameStr,$publicationDate,$form);
}
echo '</table>';
echo '<a href=#top>[...]</a><hr><a name="stats"></a><p align="center" style="font-size:20px;">Feed Statistics</p><hr>';
echo '<div class="row" style="padding-left:20px;"><div class="col-sm-4">';
echo '<table><caption><b><u>Books</u></b></caption>';
echo '<tr align="top"><td align="top">Total number of Books:</td><td>'.$totalBooks.'</td></tr>';
echo '<tr><td>Existing books </td><td>'.$booksFound.'</td></tr>';
echo '<tr><td>New Books</td><td>'.$booksNotFound.'</td></tr>';
echo '<tr><td>Books created:</td><td>'.$booksCreated.'</td></tr>';
echo '<tr><td>Images Found:</td><td>'.$imagesFound.'</td></tr>';
echo '<tr><td>Images Not Found</td><td>'.$imagesNotFound	.'</td></tr>';
echo '</table></div>';
echo '<div class="col-sm-5">';
echo '<table><caption><b><u>Authors</u></b></caption>';
echo '<tr><td>Total no. of Author references:</td><td>'.$authorCount.'</td></tr>';
echo '<tr><td>Author names matching existing Authors:</td><td>'.$authorsFound.'</td></tr>';
echo "<tr><td>Author names not found:</td><td>".$authorsNotFound.'</td></tr>';
echo "<tr><td>Authors created:</td><td>".$authorsCreated.'</td></tr>';
echo '<tr><td>Number of books with no Authors:</td><td>'.$xml_bookHasNoAuthors.'</td></tr>';
echo '<tr><td>Number of books with ambiguous Authors:</td><td>'.$duplicate_authorNames.'</td></tr>';
echo '</table></div>';
echo '<div class="col-sm-3">';
echo '<table><caption><b><u>Publishers</u></b></caption>';
echo '<tr><td>Publisher references found:</td><td>'.$publishersFound.'</td></tr>';
echo '<tr><td>Publisher references not found:</td><td>'.$publishersNotFound.'</td></tr>';
echo '<tr><td>Publishers created:</td><td>'.$publishersCreated.'</td></tr>';
echo '</table></div>
		</div>';
echo '<hr><p>End of Report</p>';


function formatHeader() {
	return '<table>
				<tr >
					<th>Image</th>
					<th>ISBN-13</th>
					<th>Title</th>
					<th>Category</th>
					<th>Contributors</th>
					<th>Publisher</th>
					<th>Published</th>
					<th>Form</th>
				</tr>';
}
function formatRow($image,$isbn13,$title,$category, $authors,$publisher,$published, $form){
	$html = '<tr>';
	if($image == '') 
		$html .= '<td></td>';
	else
		$html .= '<td><img src=".'.$image.'" style="height:20px;"></td>';
	$html .= '<td>'.$isbn13.'</td>';
	$html .= '<td>'.$title.'</td>';
	$html .= '<td>'.$category.'</td>';
	$html .= '<td>'.$authors.'</td>';
	$html .= '<td>'.$publisher.'</td>';
	$html .= '<td>'.$published.'</td>';
	$html .= '<td>'.$form.'</td>';
	$html .= '</tr>';
	return $html;
}
?>
