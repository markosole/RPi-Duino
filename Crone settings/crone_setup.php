<?php

if ( stripos( $_SERVER[ 'REQUEST_URI' ], basename( __FILE__ ) ) !== FALSE ) { // TRUE if the script's file name is found in the URL
 header( 'HTTP/1.0 403 Forbidden' );
 die( "<h2>Forbidden! Direct access is not allowed.</h2>" );
}
//***************************
// 		plugin za izvrsavanje komandi provjere datuma aktivacije i deaktivacije Nodova
//		Verzija: v0.1.0
//		$pin = 2222;
//		exec("sudo /home/pi/433Utils/RPi_utils/codesend ".$pin);
//***************************
mysql_connect("localhost", "root", "fit1740") or die(mysql_error());
mysql_select_db("bonfire") or die(mysql_error());

// Retrieve all the data from the "example" table
$result = mysql_query("SELECT nodes_id, node_number, node_name, command_identifier, node_activate_time, node_deactivate_time FROM bf_table_nodes")
or die(mysql_error());  
$rows = array();
while($row = mysql_fetch_array($result))
$rows[] = $row;
foreach($rows as $row){ 

		echo "*********************************************</br>";
		echo "<strong>Trenutno RPi (sekunde):</strong> " . date('Y-m-d H:i:s') . "</br>";
		echo "<strong>Trenutno RPi minute:</strong> " . date('Y-m-d H:i') . "</br></br>";
		
		echo "<strong>Vrijeme aktivacije:</strong> " . $row[node_activate_time] . "</br>";
		echo "<strong>Vrijeme deaktivacije:</strong> " . $row[node_deactivate_time] . "</br>";
								//echo "Danas je dan: " . date( "D", $timestamp) ." </br>";
								// Prikaz skracenog naziva dana u tjednu. Umjesto D stavim W i dobit cu broj dana u tjednu. 
								//
		//trenutno vrijeme / datum		
		$date_stamp = date('Y-m-d H:i');
		
		//Debuging dio
		$datum_starta_temp = date_create($row[node_activate_time]);
		$datum_stopa_temp = date_create($row[node_deactivate_time]);
		echo "</br>" . "Vrijeme aktivacije Node-a: " . date_format($datum_starta_temp, 'Y-m-d H:i');
		
		
		
		$date_on 	 = date_format($datum_starta_temp, 'Y-m-d H:i');	//vrijeme paljenja
		$date_off	 = date_format($datum_stopa_temp, 'Y-m-d H:i');	//vrijeme gasenja
		$identifier	 = $row[command_identifier];	//Komanda aktivacije. Broj tj vrijednost koja se salje Node-u
		$identifier_off = 9;  //obicni random bez veze broj, pridruzuje se komandi za deaktivaciju uredjaja
		//$node_number = $row[node_number];    za buducu upotrebu
		
		// Funkcija za provjeru i gasenje upaljenih uredjaja u zadano vrijeme
		
		
		
		
		
		if ( $date_off == $date_stamp ) {
			echo "</br>Ok, vrijeme se poklapa, izvrsavam komandu...";
			
			exec("sudo /home/pi/433Utils/RPi_utils/codesend ".$identifier . $identifier_off);
			} else {
		
		echo "</br>Nema komandi za slanje. Uredjaj je u stand by rezimu.</br></br>";
		}
				
		
		if ( $date_on == $date_stamp ) {
		echo "</br>Ok, vrijeme se poklapa, izvrsavam komandu...";
	
		exec("sudo /home/pi/433Utils/RPi_utils/codesend ".$identifier);
		} else {
		
		echo "</br>Nema komandi za slanje. Uredjaj je u stand by rezimu.</br></br>";
		}
		
		

}
		
		