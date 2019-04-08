<?php
  if(isset ($_POST['mydata'])){
    $select = $_POST['mydata'];	}
  else $select= "Not posted";
  echo $select; //local variable 'data' received from GUI
  $band = array("VHF","UHF","SHF");
   $status - 0;
  // echo BAND[0];
  $V0 = 17;
  $V1 = 22;
  $V2 = 27;
  $U0 = 5;
  $U1 = 6;
  $U2 = 13;
  $S0 = 26;
  $S1 = 16;
  $S2 = 20;
  $line_ON = 1;
  $line_OFF = 0;
 const VHF0 = 17; // gpio line for VHF Amolifier line
 const VHF1 = 22; // gpio line for VHF Relais line 0
 const VHF2 = 27; // gpio line for VHF Relais line 1
 const UHF0 = 5;  // gpio line for UHF Amolifier line
 const UHF1 = 6;  // gpio line for UHF Relais line 0
 const UHF2 = 13; // gpio line for UHF Relais line 1 
 const SHF0 = 26; // gpio line for SHF Amolifier line
 const SHF1 = 16; // gpio line for SHF Relais line 0
 const SHF2 = 20; // gpio line for SHF Relais line 1
  //Setting output pins for vhf row
  system("gpio -g mode ".VHF0." out");
  system("gpio -g mode ".VHF1." out");
  system("gpio -g mode ".VHF2." out");
  //Setting output pins for uhf row
  system("gpio -g mode  ".UHF0."  out");
  system("gpio -g mode  ".UHF1."  out");
  system("gpio -g mode  ".UHF2."  out");	
  //Setting output pins for shf row
  system("gpio -g mode  ".SHF0."  out");
  system("gpio -g mode  ".SHF1."  out");
  system("gpio -g mode  ".SHF2."  out");		

  switch($select){// To be replaced by 2 nested cases
                  //(band=U,V.S and 
				  // Position = GP,HALO,V-YAGI,H-YAGI, AMP_ON, AMP_OFF
				  // connect(band.Pos) function replaces two system calls
  case "1": setLinePair($V1,$V2,$line_OFF,$line_OFF);break;
  case "2": setLinePair($V1,$V2,$line_ON,$line_OFF);break;
  case "3": setLinePair($V1,$V2,$line_OFF ,$line_ON);break;
  case "4": setLinePair($V1,$V2,$line_ON,$line_ON);break;
  case "5": setLinePair($U1,$U2,$line_OFF,$line_OFF);break;
  case "6": setLinePair($U1,$U2,$line_ON,$line_OFF);break;
  case "7": setLinePair($U1,$U2,$line_OFF,$line_ON);break;
  case "8": setLinePair($U1,$U2,$line_ON,$line_ON);break;
  case "9": setLinePair($S1,$S2,$line_OFF,$line_OFF);break;
  case "10":setLinePair($U1,$U2,$line_ON,$line_OFF);break;
  case "11":setLinePair($U1,$U2,$line_OFF,$line_ON);break;
  case "12":setLinePair($U1,$U2,$line_ON,$line_ON);break;
 
  case "13":
 //   exec("gpio -g read ".$V0."", $status);			      //Read current status	  
 //   if($status[0]==0){system("gpio -g write ".$V0." 1");}  // to be replaced by connect(SHF,AMP_ON);   
 //   else 
 // 		system("gpio -g write ".$V0." 0");                // to be replaced by connect(VHF,AMP_OFF); 
 // exec("gpio -g read ".$V0."", $status);		      //Reading new status
 //   echo " ".$status[0];					          //Echo back new status
  checkAmp($V0);
  break;

  case "14":
    exec("gpio -g read ".UHF0."", $status);			      //Read current status	  
    if($status[0]==0){system("gpio -g write ".UHF0." 1");}  // to be replaced by connect(SHF,AMP_ON);   
    else system("gpio -g write ".UHF0." 0");                // to be replaced by connect(VHF,AMP_OFF); 
    exec("gpio -g read ".UHF0."", $status);		      //Reading new status
    echo " ".$status[0];					          //Echo back new status
    break;
  
  
  case "15":
    exec("gpio -g read ".SHF0."", $status);			      //Read current status	  
    if($status[0]==0){system("gpio -g write ".SHF0." 1");}  // to be replaced by connect(SHF,AMP_ON);   
    else system("gpio -g write ".SHF0." 0");                // to be replaced by connect(VHF,AMP_OFF); 
    exec("gpio -g read ".SHF0."", $status);		      //Reading new status
    echo " ".$status[0];					          //Echo back new status
    break;			
  } // end of switch
//--------------------------------Array additions from here--------------------------
  //set up the php associated array
  $sel=array("vhf"=>0, "uhf"=>0, "shf"=>0, "vhf_amp"=>0, "uhf_amp"=>0, "shf_amp"=>0); 
  // ROBLAN use position names instead of numbers
  //Read the vhf pin values and update array with selected button No.
  // ROBLAN put next 7 lines in function check_position(band)
  exec  ("gpio -g read ".VHF2."", $statusVHF2);
  exec  ("gpio -g read ".VHF1."", $statusVHF1);
  if ($statusVHF2[0]==0 && $statusVHF1[0]==0){$sel["vhf"]=1;}
  elseif($statusVHF2[0]==1 && $statusVHF1[0]==0){$sel["vhf"]=2;}
  elseif($statusVHF2[0]==0 && $statusVHF1[0]==1){$sel["vhf"]=3;}
  else  {$sel["vhf"]=4;} // check both lines
  // ADD Error message 

  //ROBLAN use checkPosition(UHF); instead of nect 7 lines
  //Read the uhf pin values and update array with selected button No.
  exec  ("gpio -g read ".UHF1."", $statusUHF1);
  exec  ("gpio -g read ".UHF2."", $statusUHF2);
  if	  ($statusUHF1[0]==0 && $statusUHF2[0]==0){$sel["uhf"]=1;}
  elseif($statusUHF1[0]==1 && $statusUHF2[0]==0){$sel["uhf"]=2;}
  elseif($statusUHF1[0]==0 && $statusUHF2[0]==1){$sel["uhf"]=3;}
  else  {$sel["uhf"]=4;}

  //ROBLAN use checkPosition(SHF); instead of nect 7 lines
  //Read the shf pin values and update array with selected button No.
  exec  ("gpio -g read ".SHF1."", $statusSHF1);
  exec  ("gpio -g read ".SHF2."", $statusSHF2);
  if	  ($statusSHF1[0]==0 && $statusSHF2[0]==0){$sel["shf"]=1;}
  elseif($statusSHF1[0]==1 && $statusSHF2[0]==0){$sel["shf"]=2;}
  elseif($statusSHF1[0]==0 && $statusSHF2[0]==1){$sel["shf"]=3;}
  else  {$sel["shf"]=4;}

  //status of vhf amp 
  //ROBLAN Add this checking tp checkPosition(band)
  exec("gpio -g read ".VHF0." ", $statusVHF0);			//Read current vhf status	  
  if($statusVHF0[0]==1){$sel["vhf_amp"]='ON';}	  
  if($statusVHF0[0]==0){$sel["vhf_amp"]='OFF';}		  

  //status of uhf amp
  //ROBLAN use checkPosition(UHF); instead of nect 7 lines 
  exec("gpio -g read ".UHF0."", $statusUHF0);			//Read current uhf status
  if($statusUHF0[0]==1){$sel["uhf_amp"]='ON';}	  
  if($statusUHF0[0]==0){$sel["uhf_amp"]='OFF';}

  //status of shf amp
  //ROBLAN use checkPosition(UHF); instead of nect 7 lines
  exec("gpio -g read ".SHF0."", $statusSHF0);			//Read current shf status
  if($statusSHF0[0]==1){$sel["shf_amp"]='ON';}	  
  if($statusSHF0[0]==0){$sel["shf_amp"]='OFF';}

  //print_r($sel); //Will print the php array to the toggle window for checking
  // Convert to a JSON Array
  $myjson=json_encode($sel);
  //echo $myjson;	//Will print the json array to the toggle window for checking
  $fh = fopen("myJSON.json", 'w') or die("Failed to create file");
  fwrite($fh, $myjson) or die ("could not write to file");
  fclose($fh);
  //echo "file written OK";
 
 function setLinePair($LineA,$lineV,$a,$b){	 
   system("gpio -g write  "+$LineA+" "+$a);
   system("gpio -g write  "+$LineB+" "+$b);	 
   }
 function checkAmp($Line){ 
      exec("gpio -g read ".$Line."", $status);			      //Read current status	  
    if($status[0]==0){system("gpio -g write ".$Line." 1");}  // to be replaced by connect(SHF,AMP_ON);   
    else 
  		system("gpio -g write ".$Line." 0");                // to be replaced by connect(VHF,AMP_OFF); 
  exec("gpio -g read ".$Line."", $status);		      //Reading new status
    echo " ".$status[0];
 }
?>
