<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

abstract class AbstractRepo
{
	/**
	 * Validate the attributes.
	 *
	 * @param  AbstractModel $model
	 * @param  array $attributes
	 * @return array
	 */
	abstract protected function validate($model, $attributes);

	/**
	 * Store the given entity
	 *
	 * @param  AbstractModel $model
	 * @param  array $attributes
	 * @return mixed
	 */
	abstract protected function store($model, $attributes);

	/**
	 * Delete the given entity.
	 *
	 * @param  AbstractModel $model
	 * @return void
	 */
	abstract public function delete($model, $id);

	/**
	 * Create a new entity.
	 *
	 * @param  AbstractModel $model
	 * @param  array $attributes
	 * @return AbstractModel
	 */
	public function create($model, $attributes)
	{
		return $this->update($model, $attributes);
	}

	/**
	 * Update an existing entity.
	 *
	 * @param  AbstractModel $model
	 * @param  array $attributes
	 * @return AbstractModel
	 */
	public function update($model, $attributes)
	{
		$data = $this->validate($model, $attributes);

		DB::transaction(function () use ($model, $data) {
			$this->store($model, $data);
		});

		return $model->fresh();
	}



	/**
	 * Restore an entity.
	 *
	 * @param  AbstractModel $model
	 * @throws \Exception
	 */
	public function restore($model, $id)
	{
		$model->restore();
	}

	public function slugify($text, string $divider = '-')
	{
		// replace non letter or digits by divider
		$text = preg_replace('~[^\pL\d]+~u', $divider, $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, $divider);

		// remove duplicate divider
		$text = preg_replace('~-+~', $divider, $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}
}
