<?php
include("header.php");
?>
<script>
(function() {
	console.log("A");
	play("CONNECTED", "<?php echo $_GET['sess_id'];?>");
})();
var extending = false;
var end = false;
var page = 0;
$(document).scroll(function () {	
	console.log("scrolling " + window.scrollY + " " + document.body.clientHeight + " - " + window.innerHeight + " = " + (document.body.clientHeight + window.innerHeight ));
	if(window.scrollY > document.body.clientHeight - window.innerHeight - 500) {
		if(!extending && !end) {
			extending = true;
			$.ajax({
				"url":"more.php?q=<?php echo urlencode($_GET['q'])?>&page=" + page,
				success : function(data) {
					if(data == "EMPTY") {
						$("#throbber").remove();
						end = true;
						extending = false;
						return;
					}
					$("#list").append(data);
					extending = false;
					page++;
				}
			});
		}
	}
});
</script>
<div class="container">

	<div class="row-fluid">
		<div class="span12">
<table class="table" >
	<thead>
		<tr>
			<td></td>
			<td>Title</td>
		</tr>
	</thead>
	<tbody id="list">
	<?php
	$url = "https://gdata.youtube.com/feeds/api/videos?q=".urlencode($_GET['q'])."&orderby=published&start-index=1&max-results=50&v=2";
	$data = file_get_contents($url);
	$xmlDoc = new DOMDocument();
	$xmlDoc->loadXML($data);
	$entries = $xmlDoc->getElementsByTagName("entry");
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
	</tbody>
	<tfoot id="throbber">
		<tr>
			<td colspan="4">
				<center><img src="img/loader.gif" /></center>
			</td>
		</tr>
	</tfoot>
</table>
<?php include("footer.php"); ?>