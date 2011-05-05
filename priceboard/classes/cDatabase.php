<?php
	class DB {
		var $mdb2;
		function open_connection($conn = DB_DNS) {
			//initialize MDB2
			$this->mdb2 = &MDB2::singleton($conn);
			$this->mdb2->loadModule('Extended');
			$this->mdb2->loadModule('Date');
			$this->mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);		
			
			return $this->mdb2;
		}
		
		function close_connection() {
			$this->mdb2->disconnect();
		}
	}			
?>