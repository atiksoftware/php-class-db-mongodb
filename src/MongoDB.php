<?php

	namespace Atiksoftware\Database;

	class MongoDB
	{
		public $errors = [];

		public $driver = null;


		public $dbName = null; #
		public $before_dbName = null; #

		public $clName = null;
		public $before_clName = null;

		public $rules_when       = [];
		public $rules_order      = [];
		public $rules_projection = [];
		public $rules_limit      = null;
		public $rules_skip       = null;

		public function __construct(){

		}

		public function connect($hostname = "", $username = "", $password = ""){
			if(PHP_MAJOR_VERSION == 7){
				$this->driver = new \MongoDB\Driver\Manager(
					$hostname,
					[
						'username' => $username,
						'password' => $password
					]
				);
			}
			return $this;
		}

		public function setDatebase($dbName){
			$this->before_dbName = $this->dbName;
			$this->dbName        = $dbName;
			return $this;
		}

		public function setCollection($clName){
			$this->before_clName = $this->clName;
			$this->clName        = $clName;
			return $this;
		}

		/** Sıralama kuralları. Mysql deki "ORDER BY" gibi
		* @param array Sıralama kuralları dizisi. -> ["_id" => 1]
		* @return object return $this
		*/
		public function orderBy($param){
			$this->rules_order = $param;
			return $this;
		}
		/** Bunu sadece belli anahtarları listelemek için kullanıyoruz.
		* @param array Anahtar kurlları. -> ["_id" => 1, "fname" => 1, "lname" => 1]
		* @return object return $this
		*/
		public function projectBy($param){
			$this->rules_projection = $param;
			return $this;
		}
		/** DB den okunacak kayıtların max limiti
		* @param integer Max kaç kayıt isteniyor. -> 10
		* @return object return $this
		*/
		public function limit($i){
			$this->rules_limit = $i;
			return $this;
		}
		/** veri okunurken N tane item atlanacak
		* @param integer Kaç kayıt atlanacak. -> 12
		* @return object return $this
		*/
		public function skip($i){
			$this->rules_skip = $i;
			return $this;
		}
		/** Kayıt listeleme kuralları. Mysqldeki WHERE gibi
		* @param integer Kurallar. -> ["age" => ['$gt' => 20] ]
		* @return object return $this
		*/
		public function when($param){
			$this->rules_when = $param;
			return $this;
		}

		function resetRules(){
			$this->rules_when = [];
			$this->rules_order = [];
			$this->rules_projection = [];
			$this->rules_limit = null;
			$this->rules_skip  = null;
			return $this;
		}

		/*####### functions #######*/

		public function select(){
			if(PHP_MAJOR_VERSION == 7){
				$options = [
					'projection' => $this->rules_projection,
					"sort"       => $this->rules_order,
					"limit"      => $this->rules_limit,
					"skip"       => $this->rules_skip
				];
				$query = new \MongoDB\Driver\Query(
					$this->rules_when,
					$options
				);
				$rows = $this->driver->executeQuery("{$this->dbName}.{$this->clName}", $query);
				$rows->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
				$result = iterator_to_array($rows);
			}

			$this->resetRules();
			return $result;
		}
		public function insert($data,$multiple = false){
			$bulk = new \MongoDB\Driver\BulkWrite(['ordered' => true]);
			if($multiple){
				foreach($data as $row){
					$bulk->insert($row);
				}
			}else{
				$bulk->insert($data);
			}
			$this->driver->executeBulkWrite("{$this->dbName}.{$this->clName}", $bulk);
			return $this;
		}
		public function update($data = [], $overwrite = false, $multiple = false){
			$prop["upsert"] = $overwrite;
			$bulk = new \MongoDB\Driver\BulkWrite;
			if($multiple){
				foreach($data as $row){
					$bulk->update($this->rules_when,$row,$prop);
				}
			}else{
				$bulk->update($this->rules_when,$data,$prop);
			}
			$writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 10000);
			$this->driver->executeBulkWrite("{$this->dbName}.{$this->clName}", $bulk,$writeConcern);
			$this->resetRules();
			return $this;
		}
		function remove(){
			$bulk = new \MongoDB\Driver\BulkWrite(['ordered' => true]);
			$bulk->delete($this->rules_when);
			$this->driver->executeBulkWrite("{$this->dbName}.{$this->clName}", $bulk);
			$this->resetRules();
			return $this;
		}


		public function count(){
			$command = new \MongoDB\Driver\Command(["count" => $this->clName, "query" => $this->rules_when]);
			$Result = $this->driver->executeCommand($this->dbName, $command);
			return $Result->toArray()[0]->n;
		}




		public function addError($error){
			$this->errors[] = $error;
		}

	}
