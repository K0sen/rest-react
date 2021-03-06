<?php

namespace app\models;

use app\components\DbConnection;
use app\components\Model;
use app\components\Response;
use app\components\RestException;

class Film extends Model
{
	public $title;
	public $release_date;
	public $format;
	public $actors;

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			[['title', 'format'], "required" => true],
			[['title'], 'length' => 50],
			[['format'], 'length' => 50],
			[['release_date'], 'length' => 4],
			[['release_date'], 'integer' => true],
		];
	}

	/**
	 * Returns film id if success
	 * @return bool|string
	 * @throws RestException
	 */
	public function save()
	{
		$db = DbConnection::getInstance()->getPdo();
		$handler = $db->prepare('INSERT INTO `film` VALUES (NULL, :title, :release_date, :format)');
		$params = array(
			'title' => $this->title,
			'release_date' => $this->release_date,
			'format' => $this->format
		);

		if (!$handler->execute($params)) {
			throw new RestException("Film was not added! (?)", Response::NOT_FOUND);
		}

		return $db->lastInsertId();
	}

	public function findAll()
	{
		$db = DbConnection::getInstance()->getPdo();
		// Table and Column names cannot be replaced by parameters in PDO. Hm.
		$handler = $db->query(" 
			SELECT f.id, f.title, f.release_date, f.format, GROUP_CONCAT(a.name SEPARATOR ', ') AS actors
			FROM `film` f
			JOIN `film_actor` fa ON f.id = fa.film_id
			JOIN `actor` a ON a.id = fa.actor_id
			GROUP BY f.id
		");
		$items = $handler->fetchAll(\PDO::FETCH_CLASS, get_class($this));

		return $items;
	}

	/**
	 * Checks if film array have property field names
	 * @param $film
	 *
	 * @return bool
	 */
	public function checkFieldsName($film)
	{
		return array_key_exists('title', $film) &&
		       array_key_exists('release_date', $film) &&
		       array_key_exists('format', $film) &&
		       array_key_exists('stars', $film);
	}

	/**
	 * Deletes all Films. TODO Is it safe query?
	 */
	public function deleteAllFilms()
	{
		$db = DbConnection::getInstance()->getPdo();
		$handler = $db->prepare(" 
			SET FOREIGN_KEY_CHECKS = 0;

			TRUNCATE `film_actor`;
			TRUNCATE `film`;
			TRUNCATE `actor`;
			
			SET FOREIGN_KEY_CHECKS = 1;
		");
		$handler->execute();
	}
}