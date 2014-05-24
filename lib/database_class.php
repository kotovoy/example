<?php
	
	require_once "config_class.php";
	require_once "checkvalid_class.php";
	
	class DataBase{ // класс по работе с базой данных
		
		private $config;
		private $mysqli;
		private $valid;
		
		public function __construct() {
			$this->config = new Config();
			$this->valid = new CheckValid();
			$this->mysqli = new MySQLi($this->config->host, $this->config->user, $this->config->password, $this->config->db);	
			$this->mysqli->query("SET NAMES 'utf8'");
		}
		
		private function query($query){ // метод который отправляет запорос и получает ответ
			return $this->mysqli->query($query);
		}
		
		public function select($table_name, $fields, $where = "", $order = "", $up = true, $limit = "") { // метод выборки из базы данных (имя таблицы, поля, where, сортировать по полю, возрастанию, лимит)
			for ($i = 0; $i < count($fields); $i++){ // перебираем все поля
				if ((strpos($fields[$i], "(") === false) && ($fields[$i] != "*")) $fields[$i] = "`".$fields[$i]."`"; 
			}
			$fields = implode(",", $fields); // превращение масива в строку с разделителем ","
			$table_name = $this->config->db_prefix.$table_name; // формируем название таблицы
			if (!$order) $order = "ORDER BY `id`"; // формируем сортировку
			else {
				if ($order != "RAND()")	{
					$order = "ORDER BY $order";
					if (!$up) $order .= " DESC";	
				}
				else $order = "ORDER BY $order";
			}
			if ($limit) $limit = "LIMIT $limit"; // формируем лимит
			if ($where) $query = "SELECT $fields FROM $table_name WHERE $where $order $limit"; // формируем where
			else $query = "SELECT $fields FROM $table_name $order $limit";
			
			$result_set = $this->query($query); // передаем запрос в метод query
			if (!$result_set) return false;
			$i = 0;
			while($row = $result_set->fetch_assoc()){ // переобразование результата в двумерный масив
				$data[$i] = $row;
				$i++;
			}
			$result_set->close();
			return $data;
		}
		
		public function insert($table_name, $new_values){ // метод который добавляет записи в таблицу
			$table_name = $this->config->db_prefix.$table_name; // формируем название таблицы
			$query = "INSERT INTO $table_name (";
			foreach ($new_values as $field => $value) $query .= "`".$field."`,"; // перебираем все поля
			$query = substr($query, 0, -1); //обрезает последний символ, тесть ","
			$query .= ") VALUES (";
			foreach ($new_values as $value) $query .= "'".addslashes($value)."',"; // перебираем все ключи (значения к полям)
			$query = substr($query, 0, -1);
			$query .= ")";
			return $this->query($query);
		}
		
		public function update ($table_name, $upd_fields, $where) { // метод обновления записи в базе данных
			$table_name = $this->config->db_prefix.$table_name;
			$query = "UPDATE $table_name SET ";
			foreach ($upd_fields as $field => $value) $query .= "`$field` = '".addslashes($value)."',";
			$query = substr($query, 0, -1);
			if ($where) {
				$query .= " WHERE $where";
				return $this->query($query);	
			}
			else return false;
		}
		
		public function delete($table_name, $where = "") { // метод удаления записи в базе данных
			$table_name = $this->config->db_prefix.$table_name;
			if ($where) {
				$query = "DELETE FROM $table_name WHERE $where";
				return $this->query($query);
			}
			else return false;
		}
		
		public function deleteAll($table_name) { // метод который очищает таблицу
			$table_name = $this->config->db_prefix.$table_name;
			$query = "TRUNCATE TABLE `$table_name`";
			return $this->query($query);
		}
		
		
		
		public function getField($table_name, $field_out, $field_in, $value_in) { // метод который возвращает значение поля пп другому заданому полю и его значению (например, узнает пароль пользователя у которого логин user)
			$data = $this->select($table_name, array($field_out), "`$field_in`='".addslashes($value_in)."'");
			if (count($data) != 1) return false;
			return $data[0][$field_out];
			}
		
		public function getFieldOnID($table_name, $id, $field_out) { // метод получения значения поля по id
			if(!$this->existsID($table_name, $id)) return false;
			return $this->getField($table_name, $field_out, "id", $id);
		}
		
		public function getAll($table_name, $order, $up) { // метод получения всех записей из таблицы
			return $this->select($table_name, array("*"), "", $order, $up);
		}
		
		public function getAllOnField ($table_name, $field, $value, $order, $up) { // метод получает все записи по определенному полю
			return $this->select($table_name, array("*"), "`$field` = '".addslashes($value)."'", $order, $up);
		}
		
		public function deleteOnID($table_name, $id) { // метод удаления записи по id
			if(!$this->existsID($table_name, $id)) return false;
			return $this->delete($table_name, "`id` = '$id'");
		}
		
		public function setField($table_name, $field, $value, $field_in, $value_in) { // метод заменяет значение определенного поля
			return $this->update($table_name, array($field => $value), "`$field_in` = '".addslashes($value_in)."'");
		}
		
		public function setFieldOnID($table_name, $id, $field, $value) { // метод заменяет значение поля по id
			if(!$this->existsID($table_name, $id)) return false;
			return $this->setField($table_name, $field, $value, "id", $id);
		}
		
		public function updateOnID($table_name, $id, $upd_fields){
			return $this->update($table_name, $upd_fields, "`id`='".$id."'");	
		}
		
		public function getElementOnID($table_name, $id) { // метод возвращает запись по id
			if(!$this->existsID($table_name, $id)) return false;
			$arr = $this->select($table_name, array("*"), "`id` = '$id'");
			return $arr[0];
		}
		
		public function getRandomElements($table_name, $count) { // метод который возвращает случайные записи
			return $this->select($table_name, array("*"), "", "RAND()", true, $count);
		}
		
		public function getCount($table_name) { // узнает количество записей в таблице
			$data = $this->select($table_name, array("COUNT(`id`)"));
			return $data[0]["COUNT(`id`)"];
		}
		
		public function isExists($table_name, $field, $value) { // метод проверки существования записи в таблице
			$data = $this->select($table_name, array("id"), "`$field` = '".addslashes($value)."'");
			if (count($data) === 0) return false;
			return true;
		}
		
		private function existsID($table_name, $id) { // метод проверки на существование id
			if(!$this->valid->validID($id)) return false;
			$data = $this->select($table_name, array("id"), "`id` = '".addslashes($id)."'");
			if (count($data) === 0) return false;
			return true;
		}
		
		public function getLastID($table_name) { // метод узнает последний (максимальный) id в заданой таблице
			$data = $this->select($table_name, array ("MAX(`id`)"));
			return $data[0]["MAX(`id`)"];
		}
		
		public function getMaxValueInField($table_name, $field) { // метод узнает максимальноe у заданой таблици в заданом поле
			$table_name = $this->config->db_prefix.$table_name;
			$result_set = $this->query("SELECT MAX(`".$field."`) FROM `".$table_name."`");
			$row = $result_set->fetch_assoc();
			return $row["MAX(`".$field."`)"];
		}
		
		public function getMinValueInField($table_name, $field) { // метод узнает минимальное значение у заданой таблици в заданом поле
			$table_name = $this->config->db_prefix.$table_name;
			$result_set = $this->query("SELECT MIN(`".$field."`) FROM `".$table_name."`");
			$row = $result_set->fetch_assoc();
			return $row["MIN(`".$field."`)"];
		}
		
		public function selectWithInterval($table_name, $fields, $intervalfield, $start, $end) {
			$where = "`".addslashes($intervalfield)."` > '".addslashes($start)."' and `".addslashes($intervalfield)."` < '".addslashes($end)."'";
			return $this->select($table_name, $fields, $where);
		}
		
		public function __destruct() {
			if ($this->mysqli) $this->mysqli->close();	
		}
		
	}
	
?>