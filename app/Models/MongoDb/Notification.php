<?php
	namespace App\Models\MongoDb;
	use Jenssegers\Mongodb\Eloquent\Model;
	
	class Notification extends Model
	{
		protected $connection = 'mongodb';
		
		protected $fillable = [
			'id',
			'title'
		];
	}