<?php
  if(isset ($_POST['mydata'])){
    $select = $_POST['mydata'];	}
  else $select= "Not posted";
  echo $select; //local variable received from GUI

  //Setting output pins for vhf row
  system("gpio -g mode 17 out");//amplifier pin
  system("gpio -g mode 22 out");
  system("gpio -g mode 27 out");
  //Setting output pins for uhf row
  system("gpio -g mode  5  out");//amplifier pin
  system("gpio -g mode  6  out");
  system("gpio -g mode 13  out");	
  //Setting output pins for shf row
  system("gpio -g mode  26  out"); //amplifier pin
  system("gpio -g mode  16  out");
  system("gpio -g mode  20  out");		

  switch($select){// To be replaced by 2 nested cases
                  //(band=U,V.S and 
				  // Position = GP,HALO,V-YAGI,H-YAGI, AMP_ON, AMP_OFF
				  // connect(band.Pos) function replaces two system calls
  case "1": // to be replaced by connect(VHF,GP);
    system("gpio -g write 27 0");
    system("gpio -g write 22 0");
    break;

  case "2":// to be replaced by connect(VHF,HALO);
    system("gpio -g write 27 1");
	system("gpio -g write 22 0");
    break;

  case "3":// to be replaced by connect(VHF,V-YAGI);
    system("gpio -g write 27 0");
    system("gpio -g write 22 1");
    break;

  case "4":// to be replaced by connect(VHF,H-YAGI);
    system("gpio -g write 27 1");
    system("gpio -g write 22 1");
    break;

  case "5":// to be replaced by connect(UHF,GP);
    system("gpio -g write  6 0");
    system("gpio -g write 13 0");
    break;

  case "6":// to be replaced by connect(UHF,HALO);
    system("gpio -g write  6 1");
	system("gpio -g write 13 0");
    break;

  case "7":// to be replaced by connect(UHF,V-YAGI);
    system("gpio -g write  6 0");
    system("gpio -g write 13 1");
    break;

  case "8":// to be replaced by connect(UHF,H-YAGI);
    system("gpio -g write  6 1");
    system("gpio -g write 13 1");
    break;

  case "9":// to be replaced by connect(SHF,GP);
    system("gpio -g write 16 0");
    system("gpio -g write 20 0");
    break;

  case "10":// to be replaced by connect(SHF,HALO);
    system("gpio -g write 16 1");
    system("gpio -g write  20 0");
    break;

  case "11":// to be replaced by connect(SHF,V-YAGI);
    system("gpio -g write 16 0");
    system("gpio -g write  20 1");
    break;

  case "12":// to be replaced by connect(SHF,H-YAGI);
    system("gpio -g write 16 1");
    system("gpio -g write  20 1");
    break;

  case "13":
    exec("gpio -g read 17", $status);			     //Read current status	  
    if($status[0]==0){system("gpio -g write 17 1");} // to be replaced by connect(VHF,AMP_ON);  
    else system("gpio -g write 17 0");               // to be replaced by connect(VHF,AMP_ON); 
    exec("gpio -g read 17", $status100);		     //Reading new status
    echo " ".$status100[0];					         //Echo back new status
    break;

  case "14":
    exec("gpio -g read 5", $status);			      //Read current status	  
    if($status[0]==0){system("gpio -g write 5 1");}	  // to be replaced by connect(UHF,AMP_ON); 
    else system("gpio -g write 5 0");                 // to be replaced by connect(VHF,AMP_OFF); 
    exec("gpio -g read 5", $status200);		          //Reading new status
    echo " ".$status200[0];					          //Echo back new status
    break;

  case "15":
    exec("gpio -g read 26", $status);			      //Read current status	  
    if($status[0]==0){system("gpio -g write 26 1");}  // to be replaced by connect(SHF,AMP_ON);   
    else system("gpio -g write 26 0");                // to be replaced by connect(VHF,AMP_OFF); 
    exec("gpio -g read 26", $status300);		      //Reading new status
    echo " ".$status300[0];					          //Echo back new status
    break;			
  } // end of case
//--------------------------------Array additions from here--------------------------
  //set up the php associated array
  $sel=array("vhf"=>0, "uhf"=>0, "shf"=>0, "vhf_amp"=>0, "uhf_amp"=>0, "shf_amp"=>0); 
  // ROBLAN use position names instead of numbers
  //Read the vhf pin values and update array with selected button No.
  // ROBLAN put next 7 lines in function check_position(band)
  exec  ("gpio -g read 27", $status27);
  exec  ("gpio -g read 22", $status22);
  if ($status27[0]==0 && $status22[0]==0){$sel["vhf"]=1;}
  elseif($status27[0]==1 && $status22[0]==0){$sel["vhf"]=2;}
  elseif($status27[0]==0 && $status22[0]==1){$sel["vhf"]=3;}
  else  {$sel["vhf"]=4;} // check both lines
  // ADD Error message 

  //ROBLAN use checkPosition(UHF); instead of nect 7 lines
  //Read the uhf pin values and update array with selected button No.
  exec  ("gpio -g read 6", $status6);
  exec  ("gpio -g read 13", $status13);
  if	  ($status6[0]==0 && $status13[0]==0){$sel["uhf"]=1;}
  elseif($status6[0]==1 && $status13[0]==0){$sel["uhf"]=2;}
  elseif($status6[0]==0 && $status13[0]==1){$sel["uhf"]=3;}
  else  {$sel["uhf"]=4;}

  //ROBLAN use checkPosition(SHF); instead of nect 7 lines
  //Read the shf pin values and update array with selected button No.
  exec  ("gpio -g read 16", $status16);
  exec  ("gpio -g read 20", $status20);
  if	  ($status16[0]==0 && $status20[0]==0){$sel["shf"]=1;}
  elseif($status16[0]==1 && $status20[0]==0){$sel["shf"]=2;}
  elseif($status16[0]==0 && $status20[0]==1){$sel["shf"]=3;}
  else  {$sel["shf"]=4;}

  //status of vhf amp 
  //ROBLAN Add this checking tp checkPosition(band)
  exec("gpio -g read 17", $status17);			//Read current vhf status	  
  if($status17[0]==1){$sel["vhf_amp"]='ON';}	  
  if($status17[0]==0){$sel["vhf_amp"]='OFF';}		  

  //status of uhf amp
  //ROBLAN use checkPosition(UHF); instead of nect 7 lines 
  exec("gpio -g read 5", $status5);			//Read current uhf status
  if($status5[0]==1){$sel["uhf_amp"]='ON';}	  
  if($status5[0]==0){$sel["uhf_amp"]='OFF';}

  //status of shf amp
  //ROBLAN use checkPosition(UHF); instead of nect 7 lines
  exec("gpio -g read 26", $status26);			//Read current shf status
  if($status26[0]==1){$sel["shf_amp"]='ON';}	  
  if($status26[0]==0){$sel["shf_amp"]='OFF';}

  //print_r($sel); //Will print the php array to the toggle window for checking
  // Convert to a JSON Array
  $myjson=json_encode($sel);
  //echo $myjson;	//Will print the json array to the toggle window for checking
  $fh = fopen("myJSON.json", 'w') or die("Failed to create file");
  fwrite($fh, $myjson) or die ("could not write to file");
  fclose($fh);
  //echo "file written OK";
?>
