<?php
include("header.php");
$sess_id = "";
if(!isset($_SESSION["sess_id"])) {
	$sess_id = md5("love://Joy06H#crush::".date("Ymdhis")."::".rand());
	$_SESSION["sess_id"] = ($ses_id);
	
	
} else {
	
	$sess_id = $_SESSION["sess_id"];
}
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/sv_SE/all.js#xfbml=1&appId=164571690335562";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="prepaid" class="row-fluid">
	<div class="span5">
	
	<script type="text/javascript">
		
		(function() {
			
				PUBNUB.subscribe({
					channel:"remote_<?php echo $sess_id;?>",
					restore: false,
					disconnect: function() {
						console.log("Disconnected");
						$("body").html("Connection lost");
					},
					reconnect: function() {
					
					},
					callback: function(message) {
						console.log("A");
						var data = {id:message};
						
						var player = document.getElementById("myytplayer");
						if(data.id != "") {
							console.log(data);	
						}
						if(data.id == ":pause") {
							try {
								if(paused) {
									player.playVideo();
									$("#btnPause").html("&gt;");
									
								} else {
									$("#btnPause").html("&gt;");
									player.pauseVideo();
								}
							} catch(e) {
							}
							paused = !paused;
							return;
						}
						if(data.id == ":play") {
							
							player.playVideo();
							return;
						}
						if(data.id == ":stop") {
							player.stopVideo();
							return;
						}
						if(data.id == ":forward") {
							player.seekTo(player.getCurrentTime() + 25, true);
							return;
						}
						if(data.id == ":rewind") {
							player.seekTo(player.getCurrentTime() - 25, true);
							return;
						}
						if(data.id == "CONNECTED") {
							console.log("connected");
							$("#status").attr("src", "connected.png");
							return;
						}
						if(data.id != "") {
							paused = false;
							console.log("A");
							$("body").html("");
							$("body").append("<div id=\"ytapiplayer\" style=\"width:100%; height:100%\"></div>");
							var params = { allowScriptAccess: "always" };
							var atts = { id: "myytplayer" };
							swfobject.embedSWF("http://www.youtube.com/v/" + data.id + "?autoplay=1&enablejsapi=1&playerapiid=ytplayer&version=3",
											   "ytapiplayer", "100%", "100%", "8", null, null, params, atts);
								document.getElementsByTagName("object")[0].setAttribute("height", window.innerHeight);
						}
					}
				});
		})();
</script>
<p>Scan this QR-code. This will open a web page in your mobile phone which opens a search dialog. Do not close this page. When the image has changed into "Phone connected", search for a movie on your phone. When you find a movie, click on it on your phone and the page will start playing movie within 10 seconds. If you want to watch another video, just search again and select a new and the page will automatically play the new video for you within 10 seconds. 
</div>
<div class="span5">
<img id="status" src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?php echo urlencode("http://segorify.com/youtube_remote_pn/controller.php?sess_id=".$sess_id); ?>&chld=H|0" />
</div>
</div>
<div id="content" style="display: none">
<div id="ytapiplayer">
	You need Flash player 8+ and JavaScript enabled to view this video.
</div>
</div>
<div class="fb-comments" data-href="http://segorify.com/youtube_remote_pn" data-num-posts="2" data-width="470"></div>
<?php include("footer.php"); ?>