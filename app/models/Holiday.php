<?php

class Holiday extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'holidays';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  );

    public function offer(){
        return $this->belongsToMany('Offer', 'offers_holidays', 'holiday_id', 'offer_id');
    }
    public static function getAllArray(){
        $holidays = parent::orderBy('title')->get(['id', 'title'])->toArray();
        $ret = array();
        if(!empty($holidays)){
            foreach($holidays as $c){
                $ret[$c['id']] = $c['title'];
            }
        }
        return $ret;
    }

}
