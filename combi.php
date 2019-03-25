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

switch($select){
case "1":system("gpio -g write 27 0");
	     system("gpio -g write 22 0");
break;

case "2":system("gpio -g write 27 1");
	     system("gpio -g write 22 0");
break;

case "3":system("gpio -g write 27 0");
	     system("gpio -g write 22 1");
break;

case "4":system("gpio -g write 27 1");
	     system("gpio -g write 22 1");
break;

case "5":system("gpio -g write  6 0");
	     system("gpio -g write 13 0");
break;

case "6":system("gpio -g write  6 1");
	     system("gpio -g write 13 0");
break;

case "7":system("gpio -g write  6 0");
	     system("gpio -g write 13 1");
break;

case "8":system("gpio -g write  6 1");
	     system("gpio -g write 13 1");
break;

case "9":system("gpio -g write 16 0");
	     system("gpio -g write 20 0");
break;

case "10":system("gpio -g write 16 1");
	     system("gpio -g write  20 0");
break;

case "11":system("gpio -g write 16 0");
	     system("gpio -g write  20 1");
break;

case "12":system("gpio -g write 16 1");
	     system("gpio -g write  20 1");
break;

case "13":exec("gpio -g read 17", $status);		//Read current status	  
		  if($status[0]==0){system("gpio -g write 17 1");}	  
		  else system("gpio -g write 17 0");
		  exec("gpio -g read 17", $status2);	//Reading new status
		  echo " ".$status2[0];					//Echo back new status
break;

case "14":exec("gpio -g read 5", $status);		//Read current status	  
		  if($status[0]==0){system("gpio -g write 5 1");}	  
		  else system("gpio -g write 5 0");
		  exec("gpio -g read 5", $status2);		//Reading new status
		  echo " ".$status2[0];					//Echo back new status
break;

case "15":exec("gpio -g read 26", $status);		//Read current status	  
		  if($status[0]==0){system("gpio -g write 26 1");}	  
		  else system("gpio -g write 26 0");
		  exec("gpio -g read 26", $status2);	//Reading new status
		  echo " ".$status2[0];					//Echo back new status
break;			
}

?>
