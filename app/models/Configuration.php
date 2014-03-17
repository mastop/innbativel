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

}
