<?php

namespace app\components;

//Mother model

abstract class Model
{
	/**
	 * Register error handlers
	 * key is a name of a rule parameter so in rule [['name'], 'length' => 20] 'length' is an identifier for handler
	 * @var array
	 */
	private $methods = [
		'required' => 'checkRequire',
		'length' => 'checkLength',
		'integer' => 'checkInteger',
	];
	protected $errors = [];
	protected $tableName;

	public function __construct()
	{
		$this->tableName = $this->setDefaultTableName();
	}

	/**
	 * Returns underscore format of model class name to set default table name
	 * @return string
	 */
	public function setDefaultTableName()
	{
		$className = (new \ReflectionClass($this))->getShortName();
		return strtolower(preg_replace(
			['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'],
			'$1_$2',
			$className
		));
	}

	public function setTableName($name)
	{
		$this->tableName = $name;
	}

	public function findAll()
	{
		$db = DbConnection::getInstance()->getPdo();
		// Table and Column names cannot be replaced by parameters in PDO. Hm.
		$handler = $db->query("SELECT * FROM {$this->tableName}");
		$items = $handler->fetchAll(\PDO::FETCH_CLASS, get_class($this));

		return $items;
	}

	public function findByName($statement)
	{
		$db = DbConnection::getInstance()->getPdo();
		$row = key($statement);
		$value = $statement[$row];
		// Table and Column names cannot be replaced by parameters in PDO. Hm.
		$handler = $db->prepare("SELECT * FROM {$this->tableName} WHERE {$row} LIKE :value");
		$handler->execute(['value' => $value]);
		$items = $handler->fetchAll(\PDO::FETCH_CLASS, get_class($this));

		return $items[0] ?? $items;
	}

	public function findById($id)
	{
		$db = DbConnection::getInstance()->getPdo();
		// Table and Column names cannot be replaced by parameters in PDO. Hm.
		$handler = $db->prepare("SELECT * FROM {$this->tableName} WHERE `id` = :id");
		$handler->execute(['id' => $id]);
		$items = $handler->fetchAll(\PDO::FETCH_CLASS, get_class($this));

		return $items;
	}

	public function deleteById($id)
	{
		$db = DbConnection::getInstance()->getPdo();
		$handler = $db->prepare("DELETE FROM {$this->tableName} WHERE id = :id");
		$handler->execute(['id' => $id]);
	}

	/**
	 * Check if fields satisfying the rules
	 * @var $this
	 * @return mixed
	 */
	public function validate()
	{
		$rules = $this->rules();

		foreach($rules as $rule) {
			//shift field names that specified in rule so in array remains only rule
			$subs = array_shift($rule);
			foreach ($subs as $sub) {
				//search text by name of the field and call method by key of the rule
				//so in rule 'length' => 20 we will search in $methods array a handler with key 'length'
				$text = $this->$sub;
				$method = $this->methods[key($rule)];
				$this->$method($sub, $text, $rule);
			}
		}

		return $this->hasErrors();
	}

	/**
	 * Sets rules for form fields
	 * to specify a rule write an array like [['email'], 'length' => 50]
	 * first param is a field name/names in array like ['email'] or ['name', 'email', 'text', 'filename']
	 * second param is name of the rule as a key and it parameter as limiter like 'length' => 50 - it may means that limit of field is 50 characters
	 * to set a rule you need to make sure that it register in $methods array
	 * @return array
	 */
	public function rules()
	{
		return [];
	}

	/**
	 * @param $sub - name of the field
	 * @param $text - text of the field
	 * @param $rule
	 */
	public function checkRequire($sub, $text, $rule)
	{
		if( $rule['required'] && $text == '') {
			$this->errors[$sub][] = "Field $sub must be not empty";
		}
	}

	/**
	 * @param $sub
	 * @param $text
	 * @param $rule
	 */
	public function checkLength($sub, $text, $rule)
	{
		if( strlen($text) > $rule['length'] ) {
			$this->errors[$sub][] = "Maximum length exceeded ({$rule['length']}/{$rule['length']})";
		}
	}

	/**
	 * @param $sub
	 * @param $text
	 * @param $rule
	 */
	public function checkInteger($sub, $text, $rule)
	{
		if( $rule['integer'] && !ctype_digit($text)) {
			$this->errors[$sub][] = "Type of the field should be integer";
		}
	}

	/**
	 * Checks if errors exists
	 * @return bool
	 */
	public function hasErrors()
	{
		return (!$this->errors);
	}

	public function getErrors()
	{
		return $this->errors;
	}
}
