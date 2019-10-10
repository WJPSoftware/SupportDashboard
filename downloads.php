<?

	session_start();

	include_once("Classes/classes.php");

	include_once("Classes/documents/groupsclass.php");
	include_once("Classes/documents/sectionsclass.php");
	include_once("Classes/documents/documentsclass.php");
	include_once("Classes/documents/readlistclass.php");
	include_once("Classes/tenders/tendersclass.php");

	$Auth = $_GET["auth"];

	$DID = $_GET["did"];

	$Document = new Documents($DID);

	if ($Document->getfilesize() == 0) {

    	header('Location: ' . $Document->geturl());
   		die();
 	}

	if(ISSET($Auth)){

		$DID = $_GET["did"];

		$AuthCheck =  md5("did=" . $DID . "site=" . SITENAME);

    	if(ISSET($DID) && $Auth == $AuthCheck){

    		$Document = new Documents($DID);


    			$file = $Document->getfilewithdir();

				//echo($file);
				header("Content-Description: File Transfer");
	    		header("Content-length: " . $Document->getfilesize());
	    		header("Content-type: " . $Document->getfiletype());
	    		header("Pragma: public");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	    		header("Content-disposition: attachment; filename=\"" . $Document->getoutputfilename() . "\"");

	    		readfile($file);
	    	//	ReadList::newread($DID,$UID);
	    	exit;

	    } else {

	    	//Redirect to login
	    	header("Location: welcome.php");

	    }

	} else {

		if($_GET["type"] == "contacts"){
			if($_SESSION["userid"] != 0){

				$Attachment = urldecode($_GET["url"]);
				$file = FILELOC."/Contacts/".$Attachment;

				header("Content-Description: File Transfer");
		    	header("Content-type: " . pathinfo($Attachment, PATHINFO_EXTENSION));

		    	header("Pragma: public");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		    	header("Content-disposition: attachment; filename=\"" . $Attachment . "\"");

		    	readfile($file);

		    	exit;

			}else{
				header("Location: welcome.php?urlpassthrough=downloadsview.php?type=".$_GET["type"]."%26url=".$_GET["url"]);
				exit;
			}

		}

		$DID = $_GET["did"];

		$Document = new Documents($DID);
		$UID = $_SESSION["userid"];
		$User = new Users($UID);

		if(!$Document->getpublic() )
		{

	    if($UID > 0){

	    	$UserCats = $User->getcategorys() == null ? array() : $User->getcategorys();
	    	$DocCats = $Document->getaccesscategorys();

	    	if($DocCats == null){
	    		$Section = new Sections($Document->getsectionid());
	    		if($Section->getgroup()->gettender() != 0){
	    			$Tender = new Tenders($Section->getgroup()->gettender());
	    			$DocCats = $Tender->getaccesscategories();
	    		}else{
	    			$DocCats = array();
	    		}
	    	}

	    	$i = 0;

	    	$Pass = false;

			$result = array_intersect($DocCats, $UserCats);

			if(count($result) > 0){
				$Pass = true;
			}

	    	if($User->getuserlevel() >= 3){
	    		$Pass = true;
	    	}

	    	if(!$Pass){
					if($_GET["phrase"] == "DEBUG"){
						print_r($DocCats);
						echo count($DocCats)."<br />";
						print_r($UserCats);
						echo count($UserCats)."<br />";
						$result = array_intersect($DocCats, $UserCats);

						echo count($result)."<br />";
					}
					echo "Error: Insufficient Privalage!";
	    		return;
	    	}
			//}

	    	if(ISSET($DID)){

				$file = $Document->getfilewithdir();

				ob_end_clean();

				header("Content-Description: File Transfer");
		    	header("Content-length: " . $Document->getfilesize());
		    	header("Content-type: " . $Document->getfiletype());
		    	header("Pragma: public");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		    	header("Content-disposition: attachment; filename=\"" . $Document->getoutputfilename() . "\"");

		    	readfile($file);

		    	//if($UID > 0){
		    		ReadList::newread($DID,$UID);
		    	//}
		    	exit;
		    }
	    } else {
	    	//Redirect to login
	    	header("Location: welcome.php");
	    }
	}else{

				$file = $Document->getfilewithdir();

				//echo($file);
				header("Content-Description: File Transfer");
		    	header("Content-length: " . $Document->getfilesize());
		    	header("Content-type: " . $Document->getfiletype());
		    	header("Pragma: public");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		    	header("Content-disposition: attachment; filename=\"" . $Document->getoutputfilename() . "\"");

		    	readfile($file);

	    		if($UID>0)
	    			{
	    				ReadList::newread($DID,$UID);
	    			}
		    	exit;

	}

	}


?>
