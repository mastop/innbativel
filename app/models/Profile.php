<?php

class Profile extends BaseModel {

	/**
	* The name of the table associated with the model.
	*
	* @var string
	*/
	protected $table = 'profiles';

	public $timestamps = false;
	protected $softDelete = false;

	protected $fillable = [];
	protected $guarded = [];

	public static $rules = [
		'email' => 'required|email',
		'city' => 'required',
		'state' => 'required',
		'country' => 'required',
		'birth' => 'date|date_format:%d/%m/%Y',
	];

	public function user()
	{
		return $this->belongsTo('User');
	}
}
