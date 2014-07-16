<?php

class FaqGroup extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'faqs_groups';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  );

  public function faq(){
    return $this->hasMany('Faq', 'faq_group_id')->orderBy('faqs.display_order', 'asc');
  }

}
