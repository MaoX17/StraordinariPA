<?php

/**
 *
 * @category   Calss
 * @package    Class_Db
 * @copyright  Copyright (c) 2005-2007 Maurizio Proietti
 */


/**
 * @see Loader
 */
//require_once 'Class/Loader.php';

/**
 * @see User_Exception
 */
//require_once 'Class/Db/Exception.php';


//----------------------------- Fine require -----------------------------------

// Interfaccie sono opzionali, ma comunicano "come usare" le classi sottostanti


interface IFactory {
 
    public function createInstance();
    
}
 
abstract class DbAbstraction implements IFactory {
 
 	public function __construct() {
    }
    
    protected $dsn;
    protected $options;
    
    public function getDsn() {
    	
    	return $this->dsn;
    	
    }
    
    public function setDsn($dsn_impostato) {
    	
    	$this->dsn = $dsn_impostato;
    	
    }
    
    public function getOptions() {
    	
    	return $this->options;
    	
    }
    
    public function setOptions(array $options) {
    	
    	$this->options = $options;
    	
    }
    
    
}


 
class AdoDbFactory extends DbAbstraction implements IFactory {
 
    //public function __construct() {
    //    parent::__construct();
    //}

    public function createInstance() {
    	
    	require_once('adodb5/adodb.inc.php');
    	$db = ADONewConnection($this->getDsn());
    	return $db;
    } 
 
}


class PearDbFactory extends DbAbstraction implements IFactory {
     
    public function createInstance() {
    	
    	require_once('DB.php');
    	$db =& DB::connect($this->dsn, $this->options);
		if (PEAR::isError($db)) {
    		die($db->getMessage());
		}
    	return $db;
    } 
 
}


class PearMDB2Factory extends DbAbstraction implements IFactory {
     
    public function createInstance() {
    	
    	require_once('MDB2.php');
    	$db =& MDB2::connect($this->dsn, $this->options);
		if (PEAR::isError($db)) {
    		die($db->getMessage());
		}
    	return $db;
    } 
 
}

//Volendo posso inserire anche ZendFramework DB


interface IAbstractionFactory {
	
	public static function getFactory($DbType);
	
}

abstract class DbAbstractionFactory implements IAbstractionFactory {
	
	public static function getFactory($DbType) {
		
		switch ($DbType)
		{
			case 'ADODB':
				$factory=new AdoDbFactory();
				break;
			case 'PEARDB':
				$factory=new PearDbFactory();
				break;
			case 'PEARMDB2':
				$factory=new PearMDB2Factory();
				break;			
		}
		return $factory;
		
	}
	
}

// USO
//$factory=DbAbstractionFactory::getFactory('PEARDB');
//$factory->setDsn('mysql://root@localhost/gasp2v');



















/* Come si usa ADODB
    include('adodb/adodb.inc.php');
    $db = ADONewConnection($database);
    $db->debug = true;
    $db->Connect($server, $user, $password, $database);
    $rs = $db->Execute('select * from some_small_table');
    print "<pre>";
    print_r($rs->GetRows());
    print "</pre>"; 
    */


/* Come si usa PEAR-DB
	
   require_once 'DB.php';
	$dsn = 'pgsql://someuser:apasswd@localhost/thedb';
	$options = array(
    'debug'       => 2,
    'portability' => DB_PORTABILITY_ALL,
	);

	$db =& DB::connect($dsn, $options);
	if (PEAR::isError($db)) {
	    die($db->getMessage());
	}
	// ...
	$db->disconnect();
*/


// -------------------------------------------- USO ----------------------------------------



//CLIENT
//$factory=DbAbstractionFactory::getFactory('ADODB');
/*$factory->setOptions($options = array(
    'debug'       => 2,
    'portability' => DB_PORTABILITY_ALL));
*/
/*
$factory=DbAbstractionFactory::getFactory('PEARDB');
$factory->setDsn('mysql://root@localhost/gasp');
$db=$factory->createInstance();
foreach($db as $key => $value) {
    		echo $key." --> ".$value;
}

$sql = 'SELECT * FROM anagrafica'; 
$rs = $db->query($sql); 
if( DB::isError($rs) ) { 
	echo "<p><strong>Attenzione!</strong>Si � verificato un errore durante l'esecuzione della query \"$sql\"."; 
	die($rs->getMessage()); 
}
echo "<table border=2>";
while( $row = $rs->fetchRow(DB_FETCHMODE_ASSOC) ) { 
	echo '<tr>'; 
	echo "<td>" . $row['id_anagrafica'] . "</td>"; 
	echo "<td>" . $row['nome'] . "</td>"; 
	echo "<td>" . $row['cognome'] . "</td>"; 
	echo '</tr>'; 
}
echo "</table>";

$sql = "INSERT INTO `test` (`id`, `test`) VALUES ('','".mysql_escape_string(serialize($db))."');";
echo "<br>$sql<br>".strlen($sql)."<br>";
$rs = $db->query($sql); 
$affected_rows = $db->affectedRows(); 
echo "<p>Riga/Righe modificata/e: <strong>" . $affected_rows . "</strong></p>"; 

$sql = 'SELECT * FROM test'; 

$rs = $db->query($sql); 
if( DB::isError($rs) ) { 
	echo "<p><strong>Attenzione!</strong>Si � verificato un errore durante l'esecuzione della query \"$sql\"."; 
	die($rs->getMessage()); 
}
while( $row = $rs->fetchRow(DB_FETCHMODE_ASSOC) ) { 
	$db1 = unserialize($row['test']); 
	echo $db1;
}



$sql = 'SELECT * FROM anagrafica'; 

$rs = $db1->query($sql); 
if( DB::isError($rs) ) { 
	echo "<p><strong>Attenzione!</strong>Si � verificato un errore durante l'esecuzione della query \"$sql\"."; 
	die($rs->getMessage()); 
}
echo "<table border=2>";
while( $row = $rs->fetchRow(DB_FETCHMODE_ASSOC) ) { 
	echo '<tr>'; 
	echo "<td>" . $row['id_anagrafica'] . "</td>"; 
	echo "<td>" . $row['nome'] . "</td>"; 
	echo "<td>" . $row['cognome'] . "</td>"; 
	echo '</tr>'; 
}
echo "</table>";





$db1->disconnect();
$db->disconnect();

unset($db);
unset($db1);
*/

