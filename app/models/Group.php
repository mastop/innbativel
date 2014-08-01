<?php

class Group extends Eloquent {

    /**
    * The name of the table associated with the model.
    *
    * @var string
    */
    protected $table = 'groups';

    protected $guarded = [];
    protected $fillable = [];

    protected $softDelete = false;
    public $timestamps = false;

    public static $rules = array(
    'title' => 'required',
    );

    public function offer(){
    return $this->belongsToMany('Offer', 'offers_groups', 'group_id', 'offer_id')
                ->where('offers.starts_on', '<=', Carbon::now()->toDateTimeString())
                ->where('offers.ends_on'  , '>=', Carbon::now()->toDateTimeString())
                ->where('offers.is_available'  , '=', 1)
                ->where('offers.is_active'  , '=', 1)
                ->orderBy('offers.display_order', 'asc');
    }

    public static function getAllArray(){

        $groups = parent::orderBy('title')->get(['id', 'title'])->toArray();
        $ret = array();
        if(!empty($groups)){
            foreach($groups as $c){
                $ret[$c['id']] = $c['title'];
            }
        }
        return $ret;
    }

}
