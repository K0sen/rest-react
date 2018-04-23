<?php

namespace app\models;

use app\components\DbConnection;
use app\components\Model;
use app\components\Response;
use app\components\RestException;

class FilmActor extends Model
{
	public $film_id;
	public $actor_id;

	/**
	 * @param $film_id
	 */
	public function deleteFilmConnections($film_id)
	{
		$db = DbConnection::getInstance()->getPdo();
		$handler = $db->prepare("DELETE FROM {$this->tableName} WHERE `film_id` = :film_id");
		$handler->execute(['film_id' => $film_id]);
	}

	/**
	 * @param $filmId
	 * @param $actorsId
	 *
	 * @return bool
	 * @throws RestException
	 */
	public function saveRelations($filmId, $actorsId)
	{
		$db = DbConnection::getInstance()->getPdo();
		foreach ($actorsId as $actorId) {
			$handler = $db->prepare("INSERT INTO {$this->tableName} VALUES (NULL, :film_id, :actor_id)");
			$params = array(
				'film_id' => $filmId,
				'actor_id' => $actorId,
			);
			if (!$handler->execute($params)) {
				throw new RestException("Relations was not added! (?)", Response::BAD_REQUEST);
			}
		}

		return true;
	}
}