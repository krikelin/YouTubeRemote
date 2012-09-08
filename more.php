<?php
$url = "https://gdata.youtube.com/feeds/api/videos?q=".urlencode($_GET['q'])."&orderby=published&start-index=".($_GET['page']*50 + 1)."&max-results=50&v=2";

$data = file_get_contents($url);

$xmlDoc = new DOMDocument();
$xmlDoc->loadXML($data);
$entries = $xmlDoc->getElementsByTagName("entry");


if($entries->length < 1) {
	die("EMPTY");
}

for($i = 0; $i < $entries->length; $i++) {
	$entry = $entries->item($i);
	$thumbnail = $entry->getElementsByTagNameNS("http://search.yahoo.com/mrss/", "thumbnail")->item(0)->getAttribute("url") or die("A");
	$id = $entry->getElementsByTagName("id")->item(0)->childNodes->item(0)->nodeValue or die("Ae");
	
	$id = explode(":", $id);
	$id = $id[3];
	
?>	 
<tr class="item">
	<td width="64px">
		<a href="video.php?id=<?php echo $id;?>&sess_id=<?php echo $_GET["sess_id"];?>"><img src="<?php echo $thumbnail ?>" width="64px" /></a>
	</td>
	
	<td><a href="video.php?id=<?php echo $id;?>&sess_id=<?php echo $_GET["sess_id"];?>"><?php echo $entry->getElementsByTagNameNS("http://search.yahoo.com/mrss/", "title")->item(0)->childNodes->item(0)->nodeValue;?></a>
	</td>
</tr>

<?php
}
?>