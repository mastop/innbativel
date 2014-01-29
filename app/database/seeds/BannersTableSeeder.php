<?php

class BannersTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $banners = [
      [
        'img' => 'https://innbativel.com.br/admin/fotos/b_476579db5ad24e34c31acb86c084c36510418.png',
        'link' => 'http://innbativel.com.br/youtube-chile.html',
      ],
    ];

    foreach ($banners as $banner)
    {
      Banner::create($banner);
    }
  }
}
