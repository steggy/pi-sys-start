#! /usr/bin/php
<?

/*
Used for PI startup
run at boot to cover all the startup needs of the custom PI
*/


global $start_log;
global $ini_array;
global $ini_file;
global $unitname;
$GLOBALS['startlog'] = "/var/log/start.log";
$GLOBALS['ini_file'] =__DIR__ ."/sys_startup.ini";

/*if(!check_root())
	{
		echo "\nMust be run as root or from cron!!\n\n";
		log_it("Must be run as root or from cron!!");
		die; 
	}
*/

log_it("[Startup Ran]");

echo "FILE " .$GLOBALS['ini_file'] ."\n";
readini($GLOBALS['ini_file']);
//print_r($GLOBALS['ini_array']);

/* When this PI is using relays we need to init them using GPIO*/

initrelay();


$GLOBALS['unitname'] = preg_replace("/\r|\n/", "", shell_exec("/bin/hostname"));


//'*******************************************************************************
function check_root()
{
	if (posix_getuid() == 0){
        //echo "This is root !";
        return True;
    } else {
        //echo "This is non-root";
        return False;
	}
}
//'*******************************************************************************

//'*******************************************************************************
function log_it($log_str)
{
	file_put_contents($GLOBALS['startlog'], date("Y-m-d H:i:s") ." - " .$log_str ."\n", FILE_APPEND | LOCK_EX);	
}
//'*******************************************************************************

//'*******************************************************************************
function initrelay()
{
	if(isset($GLOBALS['ini_array']['userelay']['val']))
	{
		if($GLOBALS['ini_array']['userelay']['val'] == 1)
		{
			if(is_array($GLOBALS['ini_array']['relay']))
			{
				echo "Use Relay\n";
				$relay_array = array_values($GLOBALS['ini_array']['relay']);
				for($i = 0; $i < sizeof($relay_array); $i++)
				{
					$relays = explode(",", $relay_array[$i]);
					//file_put_contents('/sys/class/gpio/export', 'gpio'.$relays[1]);
					//$f = fopen('/sys/class/gpio/export', "w");
					//fwrite($f, 'gpio'.$relays[1]);
					//fclose($f);

					echo "RELAY " .$relays[0] ." Value " .$relays[1] ."\n";
					system("/usr/local/bin/gpio -g mode " .$relays[1] ." out");
					system("/usr/local/bin/gpio -g write " .$relays[1] ." 1");
				}
				sleep(1);
				print_r($relay_array);
			}
		}	
	}else{
		echo "error\n";
	}
	
}
//'*******************************************************************************

//'*******************************************************************************
function readini($file)
{
	$GLOBALS['ini_array'] = parse_ini_file($file,true);
}
//'*******************************************************************************


?>
