<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface {

	use Illuminate\Auth\UserTrait;

	protected static $user;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'updated_at');

	public function getIdAttribute($value)
	{
		return (int) $value;
	}

	/**
	 * Validate the API key
	 * @param  string $api_key
	 * @param  integer $user_id
	 * @return boolean|object
	 */
	public static function validAPIKey($api_key, $user_id)
	{
		$user = self::where('id', $user_id)
					->where('api_key', $api_key)
					->get();

		// Wrong API key
		if ($user->count() !== 1)
		{
			return false;
		}

		static::$user = $user->first();

		// Return the users data
		return true;
	}

	/**
	 * Grab the current user
	 * @return object
	 */
	public static function getCurrent()
	{
		return static::$user;
	}
}
