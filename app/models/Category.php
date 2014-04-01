<?php

class Category extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'categories';

  public static $sluggable = array(
    'build_from' => 'title',
    'save_to'    => 'slug',
  );

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  	'slug' => 'required'
  );

  public function offer()
  {
      return $this->hasMany('Offer', 'category_id');
  }

  public function scopeMenu($query)
  {
  	$value = Cache::remember('category.menu.scope', 1, function() use ($query)
  	{
  	    $select  = $query->select(['title', 'slug'])
  					 	   ->orderBy('display_order', 'asc')
  					  	 ->get()
  					  	 ->toArray();

  		$result = [];

          foreach ($select as $value) {
          	$result[] = [$value['title'], $value['slug']];
          }

          return $result;
  	});

  	return $value;
  }

}
