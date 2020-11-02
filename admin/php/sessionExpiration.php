<?php

function isLoginSessionExpired() {
	$durata_sessione = 7200; 
	$orario_corrente = time(); 
	if(isset($_SESSION['ultimo_accesso']) && isset($_SESSION["id"])){  
		if(((time() - $_SESSION['ultimo_accesso']) > $durata_sessione)){ 
			return true; 
		} 
	}
	return false;
}



?>