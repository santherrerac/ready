<?php 

class mysql_database 
{
	public $servername = "localhost";
	public $username   = "root";
	public $password   = "root";
	public $dbname     = "ready";
	public $conn       = null;

	function __construct()
	{
    $this->connect();
	}


	public function connect()
	{
		$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		if ($this->conn->connect_error) die("Connection failed: " . $this->conn->connect_error);
	}


	public function create_table()
	{
		$sql = "CREATE TABLE user (
					user_key INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
					firstname VARCHAR(30) NOT NULL,
					lastname VARCHAR(30) NOT NULL,
					email VARCHAR(50),
					reg_date TIMESTAMP
					)";
	}

	public function insert($table_name, $table_values)
	{
		$field_names = array_keys($table_values);  
		$values      = array_values($table_values);

		$sql = "INSERT INTO $table_name 
		        (".implode(',', $field_names).")
            VALUES ('".implode("','", $values)."')";
 
  	$this->query($sql);
    $last_id = $this->conn->insert_id;

    return $last_id;
	}


  public function update($table_name, $key, $row_values)
  {
    $columns          = "";
    $primary_key_name = $this->get_table_primary_key($table_name);

    foreach ($row_values as $field_name => $value) 
    {
      $columns .= ($columns?",":"")."$field_name='$value'";
    }

    $sql = "UPDATE $table_name SET $columns WHERE $primary_key_name='$key'";

    $this->query($sql);
  }


  public function select($table_name, $field_names, $filters)
  { 
    $where_sql = "";

    if (empty($field_names)) $field_names = $this->get_table_fields($table_name);

    if ($filters)
    {
      foreach ($filters as $field_name => $value) 
      {
        $where_sql .= ($where_sql? "AND": "")."$field_name = '$value' ";
      }
    }

    $sql = "SELECT ".implode(",", $field_names)."
            FROM   $table_name
            WHERE $where_sql";

    $result = $this->query($sql);
    $rows = array();

    while($row = $result->fetch_assoc()) 
    {
      $rows[] = $row;
    }

    return $rows;
  }


  public function get_table_fields($table_name)
  {
    $sql = "SHOW COLUMNS from $table_name";

        $result = $this->query($sql);
    $rows = array();

    while($row = $result->fetch_assoc()) 
    {
      $rows[] = $row['Field'];
    }

    return $rows;

  }


  public function get_table_primary_key($table_name)
  {
    $sql = "SHOW KEYS FROM $table_name WHERE Key_name = 'PRIMARY';";

    $result = $this->query($sql);
    $row = $result->fetch_assoc();

    return $row["Column_name"];
  }



	public function query($sql)
	{
		return $this->conn->query($sql);
	}
}


 ?>