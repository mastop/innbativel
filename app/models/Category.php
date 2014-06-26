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
      return $this->hasMany('Offer', 'category_id')
          ->where('offers.starts_on', '<=', Carbon::now()->toDateTimeString())
          ->where('offers.ends_on'  , '>=', Carbon::now()->toDateTimeString())
          ->where('offers.is_available'  , '=', 1)
          ->where('offers.is_active'  , '=', 1);
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

    public static function getAllArray(){

        $categories = Category::orderBy('title')->get(['id', 'title'])->toArray();
        $ret = array();
        if(!empty($categories)){
            foreach($categories as $c){
                $ret[$c['id']] = $c['title'];
            }
        }
        return $ret;
    }

}
