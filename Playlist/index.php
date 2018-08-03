<?php /* Template Name: PageEmbedSingle */
$cachebuster = strtotime(date('Y-m-d H:i:s'));
?>
<?php header('Access-Control-Allow-Origin: http://imasdk.googleapis.com'); ?>
<!DOCTYPE html>
<html>
<head>    
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://waspmobile.com/video-player/playlist/lib/video-js.min.css">
		<link rel="stylesheet" href="https://waspmobile.com/video-player/playlist/lib/videojs.ads.css" />
		<link rel="stylesheet" href="https://waspmobile.com/video-player/playlist/lib/videojs.ima.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://waspmobile.com/video-player/lib/videojs-share.css">
		<title>Consequenceofsound</title>
		<link rel="stylesheet" href="https://cdn.consequenceofsound.net/video-player/production/css/site-list.css">
		<link rel="stylesheet" href="https://cdn.consequenceofsound.net/video-player/production/css/site-embed.css">
		<link rel="stylesheet" href="https://cdn.consequenceofsound.net/video-player/production/css/style.css">
	<style type="">
	.clickable{
		cursor:pointer !important;
	}
	</style>
	<?php
// Read JSON file to get all data
 $json = file_get_contents('https://cdn.consequenceofsound.net/video-player/production/data/data_stage_ln.json?cb='.rawurlencode($cachebuster));
//Decode JSON
$json_data = json_decode($json,true);
$finalArray = array();	
		global $post;
	$atts["posttag"]='yes';	
		if($atts["posttag"] === 'yes')
		{
			$posttagArray = array();			
				$posttagArray[] = 'best music';
 			foreach($posttagArray as $tagres)
			{
				foreach($json_data["data"] as $jres)
				{
					$jartistString = $jres["artist"];
					$tagjsonArray = explode(",", trim(strtolower($jartistString)));
					$tagjsonArray = array_map("trim", $tagjsonArray);
					if (in_array(trim($tagres), $tagjsonArray))
					{
						$finalArray[] = $jres;
					}
				}
			}
		}
		 	
	$finalArray = array_unique($finalArray, SORT_REGULAR);
	ob_start();
    ?>
	
</head>
<body>
    
	
	
	<div id="ima-sample-container">
    <div class="container-fluid"> 
	<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8">
          <div id="ima-sample-videoplayer">
	<video id="content_video" class="video-js vjs-fluid" controls preload="auto" width="100%" poster="<?php echo ( $finalArray[0]['poster'] ) ?>" playsinline>
	<source src="<?php echo ( $finalArray[0]['src'] ) ?>" type="<?php echo ( $finalArray[0]['type'] ) ?>">
</video>
			  <br/> <br/> 
			  
	<input type="button" class="btn btn-primary clickable" onClick="loadPrev()" value="Prev" />
    <input type="button" class="btn btn-primary clickable" onClick="loadNext()" value="Next" />
          </div>
	</div>  
	</div>
	</div>
    </div>
<script type="text/javascript">
	var jsdata  = <?php echo json_encode($finalArray); ?>;
	var jscount = <?php echo count($finalArray); ?>;
</script>

	<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.2.0/video.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/videojs-flash/2.1.1/videojs-flash.min.js"></script>
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.12.0/videojs-contrib-hls.min.js"></script>-->
    <script type="text/javascript" src="videojs.ads.min.js"></script>
    <script type="text/javascript" src="videojs.ima.js"></script>
    <script src="https://googleads.github.io/videojs-ima/node_modules/can-autoplay/build/can-autoplay.min.js"></script>
    <script src="ads.js"></script>

</body>
</html>

<?php 
 
