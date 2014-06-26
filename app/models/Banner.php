<?php

class Banner extends BaseModel {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'banners';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'img' => 'required',
  	'link' => 'required|url'
  );
    /**
     * Formata a imagem
     * @param $value
     * @return string
     */
    public function getImgAttribute($value)
    {
        if(empty($value) || substr($value, 0, 4) == 'http')
            return $value;
        return '//'.Configuration::get('s3url').'/banners/'.$this->id.'/'.$value;
    }
    /**
     * Formata a URL
     * como $banner->url
     * @return string
     */
    public function getUrlAttribute()
    {
        // Converter o ID do Banner
        $id_str = (string) $this->id;
        $offset = rand(0, 9);
        $encoded = chr(79 + $offset);
        for ($i = 0, $len = strlen($id_str); $i < $len; ++$i) {
            $encoded .= chr(65 + $id_str[$i] + $offset);
        }
        return route('banner', $encoded);
    }

}
