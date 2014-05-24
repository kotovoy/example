<?php
	require_once "config_class.php";
	require_once "checkvalid_class.php";
	require_once "database_class.php";
	
	abstract class GlobalClass {
		
		private $db;
		private $table_name;
		protected $config;
		protected $valid;
		
		protected function __construct ($table_name, $db) {
			$this->db = $db;
			$this->table_name = $table_name;
			$this->config = new Config();
			$this->valid = new CheckValid();
		}
		
		public function add ($new_values) { // метод добавления новой записи
			return $this->db->insert($this->table_name, $new_values);
		}
		
		public function edit ($id, $upd_fields) { // метод редактирования записи
			return $this->db->updateOnID($this->table_name, $id, $upd_fields);
		}
		
		protected function delete ($id) { // метод удаления записи
			return $this->db->deleteOnID($this->table_name, $id);
		}
		
		public function deleteAll () { // метод удаления всех записей из таблицы
			return $this->db->deleteAll($this->table_name);	
		}
		
		public function getField ($field_out, $field_in, $value_in) { // метод который возвращает значение поля пo другому заданому полю и его значению (например, узнает пароль пользователя у которого логин user)
			return $this->db->getField($this->table_name, $field_out, $field_in, $value_in);
			}
		
		protected function setField($field, $value, $field_in, $value_in) {
			return $this->db->setField($this->table_name, $field, $value, $field_in, $value_in);
		}
		 
		protected function getFieldOnID($id, $field) { // метод получения значения поля по id
			return $this->db->getFieldOnID($this->table_name, $id, $field); 
		}
		
		protected function setFieldOnID ($id, $field, $value) { // метод заменяет значение поля по id
			return $this->db->setFieldOnID($this->table_name, $id, $field, $value);
		}
		
		public function get ($id) { // метод возвращает запись по id
			return $this->db->getElementOnID($this->table_name, $id);
		}
		
		public function getAll ($order = "", $up = true) { // метод получает все записи из таблицы
			return $this->db->getAll($this->table_name, $order, $up);
		}	
		
		protected function getAllOnField ($field, $value, $order = "", $up = true) { // метод получает все записи по определенному полю
			return $this->db->getAllOnField($this->table_name, $field, $value, $order, $up);
		}
		
		public function getRandomElement ($count) { // метод который возвращает случайные записи
			return $this->db->getRandomElements($this->table_name, $count);
		}
		
		public function getLastID () { // метод возвращает id последней вставленой записи
			return $this->db->getLastID($this->table_name);
		}
		
		public function getCount () { // метод возвращает количество записей в таблице
			return $this->db->getCount($this->table_name);
		}
		
		protected function isExists ($field, $value) { // метод проверки существования записи в таблице
			return $this->db->isExists($this->table_name, $field, $value);
		}
		
		public function select($fields, $where = "", $order = "", $up = true, $limit = ""){
				return $this->db->select($this->table_name, $fields, $where, $order, $up, $limit);
		}
	}
?>