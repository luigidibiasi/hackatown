<?php
	include_once("../dbms.php");


	 $output = Array();

	switch($_REQUEST["subf"])
	{
		case "post":
		{
			//for hackatown reviewers: code for sign-in must be placed here. For the hackatown purpose i implement post procedure as single user procedure in order to semplify coding of idea core. 
			// excuse for my poor english ;)

		    $dtc15 = Date("Ymd");
                    $orc15 = Date("His");
		    $postbody = $_REQUEST["postbody"];
		    $lat = $_REQUEST["lat"];
  		    $lng = $_REQUEST["lng"];
			$avatar = $_REQUEST["avatar"];

		    // priority filed will be changed by knowledge-daeomn. The field will be use in order to increase visibility of good post.
			
		    sql_query("INSERT INTO posts (avatar,dtc15,orc15,lat,lng,user,body,priority) values ('".$avatar."','".$dtc15."','".$orc15."','".$lat."','".$lng."','1','".$postbody."','0')");


			$output["res"]=1;
			echo json_encode($output);
			

			break;
		}
		case "pingchat":
		{


			//for hackatown reviewer: i know that this procedure must be distribuited or parallelized on a cluster but for the purpose of the hackatown i implement it as sequential code.

			$d = floatval($_REQUEST["d"])*10;
			$R = 6371.0;
			$r = floatval($d/$R);
			$lat = $_REQUEST["lat"];
			$lng = $_REQUEST["lng"];
			$sid = $_REQUEST["sid"];
			$minlat = floatval($lat) - $r;
			$maxlat = floatval($lat) + $r;
			$minlng = $lng+ $d/ ($R*cos($lat));
 			$maxlng = $lng- $d/ ($R*cos($lat)); 
			$dtc15 = Date("Ymd");
                  	$orc15 = Date("His");

			sql_query("delete from chat where sid='".$sid."'");
			sql_query("insert into chat (lat,lng,sid,dtc15,orc15) values ('".$lat."','".$lng."','".$sid."','".$dtc15."','".$orc15."')");

			$output["data"]=Array();
			$dr = sql_query("select * from chat where sid <> '".$sid."' and lat between '".$minlat."' and '".$maxlat."' and lng between '".$minlng."' and '".$maxlng."'");
			while ($_dr = mysql_fetch_array($dr))
			{
				$output["data"][$_dr["sid"]]=1;
			}
			
			$output["res"]=1;
			echo json_encode($output);

			break;
		}

		case "hotThemeNear":
		{


			//for hackatown reviewer: i know that this procedure must be distribuited or parallelized on a cluster but for the purpose of the hackatown i implement it as sequential code.

			$d = floatval($_REQUEST["d"])*10;
			$R = 6371.0;
			$r = floatval($d/$R);
			$lat = $_REQUEST["lat"];
			$lng = $_REQUEST["lng"];

			$minlat = floatval($lat) - $r;
			$maxlat = floatval($lat) + $r;
			$minlng = $lng+ $d/ ($R*cos($lat));
 			$maxlng = $lng- $d/ ($R*cos($lat)); 


			$dr = sql_query("select * from posts where lat between '".$minlat."' and '".$maxlat."' and lng between '".$minlng."' and '".$maxlng."' order by dtc15 desc,orc15 desc ");

			// here i will place td-idf code in order to know most relevant word in each post near user position
			
			$output["data"]= Array();

			$IDF = Array();
			$i = 0;
			
			// for each post
			while ($_dr = mysql_fetch_array($dr)) {

				    $output["data"][$i]=array();
                                    $output["data"][$i]["lat"]=round($_dr["lat"],4);
                                    $output["data"][$i]["lng"]=round($_dr["lng"],4);
                                    $output["data"][$i]["dtc15"]=parseDate($_dr["dtc15"]);
                                    $output["data"][$i]["orc15"]=parseTime($_dr["orc15"]);
			            // load only first line for each post
			            $output["data"][$i]["body"]=$_dr["body"];
				    if (isset($_dr["avatar"]) && $_dr["avatar"]!="")
					$output["data"][$i]["avatar"]=$_dr["avatar"];

				$i+=1;


				// compute hot themes with IDF functions 
				// For REVIEWER: i know that we must use more complex document analisys tools but for the purpose of the prototype we choice to use IDF due to semplicity 

				$toparse = $_dr["body"]; 
				$toparse = strip_tags($toparse);
				$toparse = explode(" ",strtolower($toparse));
				$doclen = 0;

				// count in how many documents each words appears
				foreach ($toparse as $word)
				{
					if ($word=="") continue;

					//for IDF, create memory space for this post
					if (!isset($IDF[$word]))
						$IDF[$word]=Array();
					if (!isset($IDF[$i][$word]))
						$IDF[$word][$i]=1; //this doc contains this word
				}
				
				$IDF2 = Array();
				foreach ($IDF as $w => $il)
				{
					if (!isset($IDF2[$w]))
						$IDF2[$w]=count($IDF[$w]);
				}

			}
			arsort($IDF2);
			$output["hottheme"] = Array();
			$i =0;
			foreach ($IDF2 as $key => $value)
			{
				if (strlen($key)<7) continue;
				$output["hottheme"][$key] = $value;
				if ($i==8) break; $i++;
			}
			echo json_encode($output);
			break;
		}	
	}
?>
