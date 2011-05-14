<?php
	require './config.php';  
	require './facebook.php';
	require './database.php';
	
	session_start();
	
	$facebook = new Facebook(array(
		'appId' => $appId,
		'secret' => $secret,
		'cookie' => 'true'
	));
	
	
	$session = $facebook->getSession();
		
	$me = null;
	$linkedID = "NONE";
	
	if($session){		
		try{			
			$uid = $facebook->getUser();			
			$me = $facebook->api('/me');
			//Check if user already played the game before
			
			$cn = new DbConnection();
			$cn->Open();
			
			$dbRec = new DbRecord();
			$dbRec->Connection = $cn;
			$query = "SELECT * FROM players WHERE uid='".$me["id"]."'";
			$result = $dbRec->Get($query);
			
			//If player is a new user
			if($result == null){
				$body = $dbRec->Get("SELECT id FROM items WHERE type = 1");
				
				$head = $dbRec->Get("SELECT id FROM items WHERE type = 0");
				
				$armor = $dbRec->Get("SELECT id FROM items WHERE type = 4");
				
				$weapon = $dbRec->Get("SELECT id FROM items WHERE type = 3");
				
				$dbRec->Insert("INSERT INTO inventories(player_id, item_id) VALUES ('".$me["id"]."','".$body["id"]."') ");
				$dbRec->Insert("INSERT INTO inventories(player_id, item_id) VALUES ('".$me["id"]."','".$head["id"]."') ");
				$dbRec->Insert("INSERT INTO inventories(player_id, item_id) VALUES ('".$me["id"]."','".$armor["id"]."') ");
				$dbRec->Insert("INSERT INTO inventories(player_id, item_id) VALUES ('".$me["id"]."','".$weapon["id"]."') ");
			
				$dbRec->Insert("INSERT INTO players(uid, username, head, body, weapon, armor) VALUES ('".$me["id"]."','".$me["first_name"]."','".$head["id"]."','".$body["id"]."','".$weapon["id"]."','".$armor["id"]."')");
			}else{
				$dbRec->Update("UPDATE players SET isNew = 0
					WHERE uid = '".$me["id"]."'");
			}
			
			//Populate buddy list
			$friends = $facebook->api('/me/friends');			
			foreach($friends["data"] as $friend){
				if($dbRec->Get("SELECT * FROM players WHERE players.uid='".$friend["id"]."'")){
					if($dbRec->Get("SELECT * FROM buddies WHERE buddies.user_id = '".$me["id"]."' AND buddies.buddy_id = '".$friend["id"]."'") == NULL){
						$dbRec->Insert("INSERT INTO buddies(user_id, buddy_id) VALUES ('".$me["id"]."','".$friend["id"]."')");
						$dbRec->Insert("INSERT INTO buddies(user_id, buddy_id) VALUES ('".$friend["id"]."','".$me["id"]."')");
					}					
				}
			}
			
			if($_GET["itemId"]){
				$itemID = $_GET["itemId"];
				
				$item = $dbRec->Get("SELECT * FROM items WHERE items.id='".$itemID."' AND items.forger_id != '".$me["id"]."'");
				if($item){ //ITEM EXISTS
					if($dbRec->Get("SELECT * FROM inventories WHERE inventories.item_id='".$itemID."' AND inventories.player_id='".$me["id"]."'")){
						$linkedID = "OWNED";
					}else{
						$linkedID = $item["id"];
					}
					
				}else{
					$linkedID = "INVALID";
				}
			}
			
			$cn->Close();
		}catch(FacebookAPIException $e){
			error_log($e);
		}
	}	

	//loadXMLFiles
	//$assetsXML = loadFile("assets.xml")
	function loadFile($fileName){
		$fh = fopen($fileName, 'r');
		$theData = fread($fh, filesize($fileName));
		fclose($fh);
		return $theData;
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Forge Story</title>		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
		<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="FBJSBridge.js?"></script>
		
	</head>
	<body style="margin:0px;">
		<div style="margin:0px auto; padding: 5px; width:760px; font-family:Tahoma, Geneva, sans-serif; font-size:10px; color:#CCCCCC;">
			<img src="./images/header.png" alt="Forge Story" />
			<p>
				 Create stuff, then sell it. Such is the story of our lives.
			</p>
		</div>
		<div id="fb-root"></div>
		<script type="text/javascript">
			function embedPlayer() {
				FB.Canvas.setAutoResize();
				var flashvars = {
							jsConfig:"getXML",
							uid: "<?php echo $uid;?>",
							linkUID: "<?php echo $linkedID;?>"
						};
				var params = {
						wmode: "transparent"
				};
				embedSWF("<?php echo $mainSWF; ?>", "flashContent", "760", "520", "9.0.0", flashvars, params);				
			}			

			function init() { 	
				FB.init({
     				appId  : <?php echo $facebook->getAppId(); ?>,
     	     		session : <?php echo json_encode($session); ?>,
     				status : true, // check login status
     				cookie : true, // enable cookies to allow the server to access the session
		     		xfbml  : true  // parse XFBML
   				});
   				<?php 
   					if($me){
   						echo "embedPlayer()";
   					}else{
   						//echo $redirectURL;
   						//echo $facebook->getAppId();
   						echo "redirect('".$facebook->getAppId()."','','".$redirectURL."');";
   					}
   				?>
			}			

		
			function getXML(type){
				if(type == "sounds"){
					return escape("<data base='assets/sounds'> <as name='TestSound'>/location.swf</as></data>");
				}else if(type == "assets"){
					return "<?php echo rawurlencode($assetsXML);?>";
				}else if(type == "popups"){
					return "<data base='assets/popups'> <as name='TestPopup'>/location.swf</as></data>"
				}
			}

			//Redirect for authorization for application loaded in an iFrame on Facebook.com 
			function redirect(id,perms,uri) {
				var params = window.location.toString().slice(window.location.toString().indexOf('?'));
				top.location = 'https://graph.facebook.com/oauth/authorize?client_id='+id+'&scope='+perms+'&redirect_uri='+uri+params;				 
			}
			
			init();
		</script>
		<div id="flashDiv">
			<div id="flashContent"></div>			
		</div>
		<div style="margin:0px auto; padding: 5px; width:250px; font-family:Tahoma, Geneva, sans-serif; font-size:10px; color:#CCCCCC;">
			<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
			<fb:like href="http://www.facebook.com/apps/application.php?id=189157287797834" show_faces="true" width="450" font=""></fb:like>
			Due to a serious case of Running-Out-Of-Time, I did not include the "Go Aloning!!" part. Now if I get enough "likes".. Anyways
			the developer has no interest in your public or private data. I just made this for Ludum Dare 20.
		</div>
		
	</body>
</html>