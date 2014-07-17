<?php

class Included extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'included';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  	'description' => 'required',
  	'icon' => 'required',
  );

  public function offer(){
  	return $this->belongsToMany('Offer', 'offers_included', 'included_id', 'offer_id')->withPivot('display_order');
  }

  public function __toString(){
      return '<span class="map-icon map-icon-'.$this->icon.'"></span> '.$this->title;
  }

    public static function getAllArray(){

        $genres = parent::orderBy('title')->get(['id', 'icon', 'title'])->toArray();
        $ret = array();
        if(!empty($genres)){
            foreach($genres as $c){
                $ret[$c['title']] = array('value'=>$c['id'], 'data-icon'=>$c['icon']);
            }
        }
        return $ret;
    }

}