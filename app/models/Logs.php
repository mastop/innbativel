<?php

class Logs extends BaseModel {

  /**
  * The name of the table associated with the model.
  *
  * @var string
  */
  protected $table = 'logs';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = [];

  public static function set($type, $message){
    Logs::create(['type' => $type, 'message' => $message]);
  }

  public static function debug($message){
    Logs::create(['type' => 'debug', 'message' => $message]);
  }

  public static function info($message){
    Logs::create(['type' => 'info', 'message' => $message]);
  }

  public static function notice($message){
    Logs::create(['type' => 'notice', 'message' => $message]);
  }

  public static function warning($message){
    Logs::create(['type' => 'warning', 'message' => $message]);
  }

  public static function error($message){
    Logs::create(['type' => 'error', 'message' => $message]);
  }

  public static function critical($message){
    Logs::create(['type' => 'critical', 'message' => $message]);
  }

  public static function alert($message){
    Logs::create(['type' => 'alert', 'message' => $message]);
  }

  public function getMessageAttribute($value){
    return '<pre>'.$value.'</pre>';
  }

  public function getCreatedAtAttribute($value){
    return date('d/m/Y H:i:s', strtotime($value));;
  }

  public function getUpdatedAtAttribute($value){
    return date('d/m/Y H:i:s', strtotime($value));;
  }

}
