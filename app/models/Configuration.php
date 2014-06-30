<?php

class Configuration extends BaseModel {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'configurations';

  protected $guarded = [];
  protected $fillable = ['name', 'value'];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = [];

    public static function get($name){

        $val = Cache::rememberForever('conf.'.$name, function() use ($name)
        {
            $conf = Configuration::where('name', $name)->first();
            return ($conf) ? $conf->value : '';
        });
        return trim($val);
    }

}
