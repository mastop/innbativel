<?php

class Faq extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'faqs';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'question' => 'required',
    'answer' => 'required',
  	'faq_group_id' => 'required',
  );

  public function group(){
    return $this->belongsTo('FaqGroup', 'faq_group_id');
  }

  public static function get(){
      // Cache::forget('faq'); // Deleta do cache para atualizar o valor
      $val = Cache::rememberForever('faq', function()
      {
          $faqs_groups = FaqGroup::with(['faq'])
                                 ->orderBy('display_order', 'asc')
                                 ->get();

          echo View::make('admin.faq.display', compact('faqs_groups'));
      });

      return trim($val);
  }

}
