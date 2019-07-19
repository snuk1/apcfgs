<?php
set_time_limit(0);

if(isset($_GET['txt_folder_path'])){
    $errors = array();
	
    if(isset($_GET['chk'])){
        $overwrite = true;
    } else {
        $overwrite = false;
    }
    
    $dt_cod = $_GET['slt'];
    
	$folder = $_GET['txt_folder_path'];
	
	if(file_exists($folder)){

		$cfgs = array_slice(scandir($folder), 2);
		
		if(sizeof($cfgs) != 0){
			
			$json = file_get_contents("contents/ps2_games_info.json");

			$games = json_decode($json, true);
			
            $error_count = 0;
            
			foreach($cfgs as $cfg){
				$cfg_divided = explode(".", $cfg);
                
                if($cfg_divided[sizeof($cfg_divided) - 1] == "cfg"){
                    $serial = $cfg_divided[0].".".$cfg_divided[1];
				
                    $serial = explode("_", $serial);

                    $serial = $serial[0]."-".$serial[1];

                    $serial = explode(".", $serial);

                    $serial = $serial[0]."".$serial[1];

                    foreach($games as $game){
                        
                        $useragent = "App-Name/Auto-Populate-CFGs";
                        
                        if($game['serial'] == $serial){
                            
                            $url = "https://api.rawg.io/api/games/";

                            $game_name = $game['name'];

                            $gn_cleaning1 = str_replace(": ", "-", $game_name);

                            $gn_cleaning2 = str_replace("//", "", $gn_cleaning1);

                            $gn_cleaning3 = str_replace(".", "", $gn_cleaning2);

                            $gn_cleaning4 = str_replace(" - ", "-", $gn_cleaning3);

                            $gn_cleaning5 = str_replace(" ", "-", $gn_cleaning4);
                            
                            $gn_cleaning6 = str_replace("'", "", $gn_cleaning5);
                            
                            $gn_cleaning7 = str_replace(",", "", $gn_cleaning6);

                            $gn_lower_case = strtolower($gn_cleaning7);

                            $url = $url.$gn_lower_case;
                            
                            $connection = curl_init();
                            
                            curl_setopt($connection, CURLOPT_URL, $url);
                            curl_setopt($connection, CURLOPT_USERAGENT, $useragent);
                            curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($connection, CURLOPT_CUSTOMREQUEST, "GET");
                            
                            //Error:SSL certificate problem: unable to get local issuer certificate
                            curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
                            curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
                            
                            $content = curl_exec($connection);
                            
                            curl_close($connection);
                            
                            $game_info = json_decode($content, true);

                            if(@$game_info["detail"] != "Not found."){
                                
                                if(strlen($game_info['description_raw']) > 255){
                                    $description = substr($game_info['description_raw'], 0, 251)."...";
                                } else {
                                    $description = $game_info['description_raw'];
                                }
                                
                                $description = str_replace("\n", " ", $description);

                                $genre = $game_info['genres'][0]['name'];

                                $unformated_rate = $game_info['rating'];
                                
                                $rating = round($unformated_rate * 20);

                                if($rating < 20){
                                    $stars = 1;

                                } else if($rating < 40){
                                    $stars = 2;

                                } else if($rating < 70){
                                    $stars = 3;

                                } else if($rating < 90){
                                    $stars = 4;

                                } else {
                                    $stars = 5;
                                }
                                
                                $date_array = explode("-", $game_info['released']);
                                
                                if($dt_cod == 1){
                                    $release_date = $date_array[2]."-".$date_array[1]."-".$date_array[0];
                                    
                                } else if($dt_cod == 2){
                                    $release_date = $date_array[1]."-".$date_array[2]."-".$date_array[0];
                                    
                                } else if($dt_cod == 3){
                                    $release_date = $date_array[0]."-".$date_array[1]."-".$date_array[2];
                                    
                                } else if($dt_cod == 4){
                                    $release_date = $date_array[2]."/".$date_array[1]."/".$date_array[0];
                                    
                                } else if($dt_cod == 5){
                                    $release_date = $date_array[1]."/".$date_array[2]."/".$date_array[0];
                                    
                                } else if($dt_cod == 6){
                                    $release_date = $date_array[0]."/".$date_array[1]."/".$date_array[2];
                                }
                                
                                $developer = $game_info['developers'][0]['name'];
                                
                                $write_title = true;
                                $write_release = true;
                                $write_rating = true;
                                $write_rating_text = true;
                                $write_description = true;
                                $write_developer = true;
                                $write_genre = true;
                                
                                $cfg_lines = file($folder.$cfg, FILE_SKIP_EMPTY_LINES);
                                
                                foreach($cfg_lines as $line){
                                    
                                    if(substr($line, 0, 5) == "Title"){
                                        $write_title = false;
                                    } 

                                    if(substr($line, 0, 7) == "Release"){
                                        $write_release = false;
                                    }
                                    
                                    if(substr($line, 0, 7) == "Rating="){
                                        $write_rating = false;
                                    }

                                    if(substr($line, 0, 11) == "RatingText="){
                                        $write_rating_text = false;
                                    }

                                    if(substr($line, 0, 11) == "Description"){
                                        $write_description = false;
                                    } 

                                    if(substr($line, 0, 9) == "Developer"){
                                        $write_developer = false;
                                    } 

                                    if(substr($line, 0, 5) == "Genre"){
                                        $write_genre = false;
                                    }    
                                }
                                
                                if($overwrite){
                                   for($i = 0; $i < sizeof($cfg_lines); $i += 1){
                                        
                                        if(substr($cfg_lines[$i], 0, 5) == "Title"){
                                            $cfg_lines[$i] = "\nTitle=".$game_name."\n";
                                        } 

                                        if(substr($cfg_lines[$i], 0, 7) == "Release"){
                                            $cfg_lines[$i] = "\nRelease=".$release_date."\n";
                                        }

                                        if(substr($cfg_lines[$i], 0, 7) == "Rating="){
                                            $cfg_lines[$i] = "\nRating=rating/".$stars."\n";
                                        }
                                        
                                        if(substr($cfg_lines[$i], 0, 11) == "RatingText="){
                                            $cfg_lines[$i] = "\nRatingText=".$stars."\n";
                                        }

                                        if(substr($cfg_lines[$i], 0, 11) == "Description"){
                                            $cfg_lines[$i] = "\nDescription=".$description."\n";
                                        } 

                                        if(substr($cfg_lines[$i], 0, 9) == "Developer"){
                                            $cfg_lines[$i] = "\nDeveloper=".$developer."\n";
                                        } 

                                        if(substr($cfg_lines[$i], 0, 5) == "Genre"){
                                            $cfg_lines[$i] = "\nGenre=".$genre."\n";
                                        }
                                    }
                                }
                                
                                if($write_title){
                                    array_push($cfg_lines, "\nTitle=".$game_name."\n");
                                }

                                if($write_release){
                                    array_push($cfg_lines, "\nRelease=".$release_date."\n");
                                }

                                if($write_rating){
                                    array_push($cfg_lines, "\nRating=rating/".$stars."\n");
                                }

                                if($write_rating_text){
                                    array_push($cfg_lines, "\nRatingText=".$stars."\n");
                                }

                                if($write_description){
                                    array_push($cfg_lines, "\nDescription=".$description."\n");
                                }

                                if($write_developer){
                                    array_push($cfg_lines, "\nDeveloper=".$developer."\n");
                                }

                                if($write_genre){
                                    array_push($cfg_lines, "\nGenre=".$genre."\n");
                                }
                                    
                                $str_cfg = implode('', $cfg_lines);

                                $cfg_array = explode("\n", $str_cfg);

                                $cfg_array_filtered = array_filter($cfg_array);

                                $final_cfg = fopen($folder.$cfg, 'w');

                                foreach($cfg_array_filtered as $line){
                                    fwrite($final_cfg, $line."\n");
                                }

                            } else {
                                $error_count += 1;
                                array_push($errors, "<p>".$error_count.") Unable to find the game -> Name: <span class='r'>".$game_name."</span> - Serial: <span class='r'>".$serial."</span></p>");
                            }
                        }
                    }
                    
                } else {
                    $error_count += 1;
                    array_push($errors, "<p>".$error_count.") The file: <span style='color:blue'>'".$cfg."'</span> is not a cfg</p>");
                }
				
			}
			
		} else {
            array_push($errors, "<p>No files where found!</p>");
		}
		
	} else {
        array_push($errors, "<p>Folder don't exist!</p>");
	}
    
    if(sizeof($errors) != 0){
        echo "<h2 id='info_title'>ERRORS</h2>";

        foreach($errors as $error){
            echo $error;
        }

    } else {
        echo "<h2 style='color:green'>Your CFG's where populated sucesssfully!</h2>";
    }
}
?>