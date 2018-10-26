<?php
require_once("common_db.php");
function store_get_shopper_id() {
	global $store_session_con;

	if (!isset($store_session_con)) {
		$store_session_con = db_connect();
	}

	$query  = "SELECT Shopper_id FROM Session WHERE id = ? AND Shopper_id IS NOT NULL";



	try {
		$statement = $dbo->prepare($query);
		$statement->execute(array(session_id()));
	} catch (PDOException $ex) {
		error_log("PDO Exception in file $ex->getFile(), line $ex->getLine(): Code $ex->getCode() - $ex->getMessage()");
		return 0;
	}

	if ($statement->rowCount() === 0)
		return 0;

	return $statement->fetch(PDO::FETCH_NUM)[0];
}

function store_session_open($save_path, $sess_name) {
	global $store_session_con;
	$store_session_con = db_connect();

	return true;
}

function store_session_close() {
	global $store_session_con;
	$store_session_con = null;

	return true;
}

function store_session_read($session_id) {
	global $store_session_con;

	$query = "SELECT data FROM Session WHERE id = ?";

	try {
		$statement = $store_session_con->prepare($query);
		$statement->execute(array($session_id));
	} catch (PDOException $ex) {
		die($ex->getMessage());
	}

	if($statement->rowCount() === 1)
		return $statement->fetch()[0];

	return '';
}

function store_session_write($session_id, $session_data){
	global $store_session_con;
	if (!isset($store_session_con)) {
		$store_session_con = db_connect();
	}
	// First, see if that session already exists
	$query = "SELECT COUNT(*) FROM Session WHERE id = ?";
	try {
		$statement = $store_session_con->prepare($query);
		$statement->execute(array($session_id));
	} catch (PDOException $ex) {
		die($ex->getMessage());
	}
	$row = $statement->fetch();
	if ($row[0] > 0)
		$query = "UPDATE Session SET id = ?, data = ?";
	else
		$query = "REPLACE Session (id, data) VALUES (?,?)";

	try {
		$statement = $store_session_con->prepare($query);
		$statement->execute(array($session_id, $session_data));
	} catch(PDOException $ex) {
		die($ex->getMessage());
		return false;
	}

	return true;
}

function store_session_destroy($session_id){
	global $store_session_con;
	if (!isset($store_session_con)) {
		$store_session_con = db_connect();
	}
	$query = "DELETE FROM Session WHERE id = ?";
	try {
		$statement = $store_session_con->prepare($query);
		$statement->execute(array($session_id));
	}
	catch(PDOException $ex) {
		die($ex->getMessage());
		return false;
	}

	return true;
}

function store_session_gc($gc_maxlife){
	global $store_session_con;

	if (!isset($store_session_con)) {
		$store_session_con = db_connect();
	}

	$query = "DELETE FROM Session WHERE t < NOW() - INTERVAL ? SECOND";

	try {
		$statement = $store_session_con->prepare($query);
		$statement->execute($gc_maxlife);
	} catch(PDOException $ex) {
		die($ex->getMessage());
		return false;
	}

	return true;

}

//ini_set("session.save_handler", "user");

session_set_save_handler(
	"store_session_open",
	"store_session_close",
	"store_session_read",
	"store_session_write",
	"store_session_destroy",
	"store_session_gc"
);

session_start();

function check_credentials($username, $password) {
	$query  = "SELECT shopper_id, sh_password FROM Shopper ";
	$query .= "WHERE sh_username = ?";

	$dbo = db_connect();

	$statement = $dbo->prepare($query);
	$statement->execute(array($username));

	$row = $statement->fetch();
	if ($row[0] > 0) {
		if (password_verify($password, $row[1]))
			return($row[0]);
		else
			return(0);
	}
	else {
		return(0);
	}
}

function login($username, $password) {

	$shopper_id = check_credentials($username, $password);
	if ($shopper_id > 0) {
		session_regenerate_id(TRUE);

		$sessid = session_id();
		$dbo = db_connect();

		$query  = "INSERT INTO Session (id, Shopper_id) VALUES (?,?)";

		try {
			$statement = $dbo->prepare($query);
			$success = $statement->execute(array($sessid, $shopper_id));
		}
		catch (PDOException $ex) {
			error_log($ex->getMessage());
			die($ex->getMessage());
		}
		return (TRUE);
	}
	else {
		return (FALSE);
	}
}

function logout() {

	session_regenerate_id(TRUE);
	session_destroy();
	// End the session;
}
