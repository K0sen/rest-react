<?php

namespace app\models;

use app\components\DbConnection;
use app\components\Model;
use app\components\RestException;
use app\components\Response;

class Actor extends Model
{
	public $name;

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			[['name'], "required" => true],
			[['name'], 'length' => 50],
		];
	}

	/**
	 * Saves list of film actors and returns their ids
	 *
	 * @param $stars
	 *
	 * @return array
	 * @throws RestException
	 */
	public function saveActors($stars)
	{
		$actorsId = [];
		foreach ( $stars as $star ) {
			$actor = $this->findByName(['name' => $star]);
			if (!empty($actor)) {
				$actorsId[] = $actor->id;
			} else {
				$this->name = $star;
				if (!$this->validate()){
					$errorMessage = json_encode(['Actor was not added. Incorrect fields' => $this->getErrors()]);
					throw new RestException($errorMessage, Response::BAD_REQUEST);
				}

				$actorsId[] = $this->save();
			}
		}

		return $actorsId;
	}

	/**
	 * Saves and returns id if success
	 * @return bool|string
	 * @throws RestException
	 */
	public function save()
	{
		$db = DbConnection::getInstance()->getPdo();
		$handler = $db->prepare("INSERT INTO {$this->tableName} VALUES (NULL, :name)");
		$params = array(
			'name' => $this->name,
		);

		if (!$handler->execute($params)) {
			throw new RestException("Actor was not added! (?)", Response::NOT_FOUND);
		}

		return $db->lastInsertId();
	}
}