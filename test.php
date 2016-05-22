<?php 

include 'mysql_database.class.php';

class user 
{
	public  $db;
	public  $table_name;
	public  $primary_key_name;
	private $loaded = false;


	public function __construct($db, $key = 0)
	{
		$this->db               = $db;
		$this->table_name       = $this->get_table_name();
		$this->primary_key_name = $this->db->get_table_primary_key($this->table_name);

		$this->load($key);
	}


	public function load($key)
	{
		$filters = array($this->primary_key_name => $key);
		$row_values = $this->db->select($this->table_name, null, $filters);
		$row_values = $row_values[0];

		foreach ($row_values as $field_name => $value) 
		{
			$this->{$field_name} = $value;
		}

		if ($this->{$this->primary_key_name}) $this->loaded = true;
	}


	public function get_table_name()
	{
		return get_class($this);
	}


	public function save()
	{
		if (!$this->loaded)
		{
			$key = $this->db->insert($this->table_name, $this->get_row_values());
			$this->load($key);
		}
		else
		{
    	$this->db->update($this->table_name, $this->{$this->primary_key_name}, $this->get_row_values());
		}
	}


	public function get_row_values()
	{
		$field_names = $this->get_fields();
		$row_values  = array();

		foreach ($field_names as $field_name) 
		{
			$row_values[$field_name] = $this->{$field_name};
		}

		return $row_values;
	}


	public function get_fields()
	{
		return $this->db->get_table_fields($this->table_name);
	}


	public function to_str()
	{
		$field_names = $this->get_fields();
		$row_values  = array();

		foreach ($field_names as $field_name) 
		{
			$row_values[$field_name] = $this->{$field_name};
		}

		return print_r($row_values, 1);
	}	

}

$db = new mysql_database();


$user = new user($db, 1);

$user->firstname = "smith2";
$user->lastname  = "herrera";
$user->email     = "sant@gmail.com";

$user->save();

print_r($user->to_str());

?>