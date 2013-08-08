<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// this is creating a new class that is extending the premade model
	// class that comes included with CodeIgniter
	class User_model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();		
			mysql_query('SET CHARACTER SET utf8');	
		}

		public function get_verse()
		{
			$query = $this->db->query("SELECT VERSETEXT, CHAPTERNO, VERSENO 
									FROM `bible2`.`bibledb_kjv` WHERE BOOKID = '20' ORDER BY RAND()");
			$row = $query->row();
			return $row;
		}
	}

?>