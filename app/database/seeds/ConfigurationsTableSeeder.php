<?php

class ConfigurationsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $configurations = [
      [
        'name' => 'merchant_id', 'value' => '1234',
      ],
      [
        'name' => 's3access', 'value' => 'AKIAI363KZF7K272NNDQ',
      ],
      [
        'name' => 's3secret', 'value' => '4cOD4MaYbrVQ+A+ftLfvuXXFoslI2NKTt4TbH+IY',
      ],
      [
        'name' => 's3bucket', 'value' => 'innbativel-dev',
      ],
      [
        'name' => 's3region', 'value' => 'sa-east-1',
      ],
      [
        'name' => 's3url', 'value' => 'innbativel-dev.s3.amazonaws.com',
      ],
      [
        'name' => 'popup_time', 'value' => '30',
      ],
      [
        'name' => 'credit', 'value' => '30',
      ],
      [
        'name' => 'braspag_return_url', 'value' => 'http://www.innbativel.com.br/braspag',
      ],
      [
        'name' => 'email', 'value' => 'faleconosco@innbativel.com.br',
      ],
      [
        'name' => 'enable_donations', 'value' => 'true',
      ],
      [
        'name' => 'donation_value', 'value' => '1',
      ],
      [
        'name' => 'enable_comment_moderation', 'value' => 'true',
      ],
      [
        'name' => 'privacy_policy', 'value' => 'PREENCHER DEPOIS DE LANÇAR',
      ],
      [
        'name' => 'terms', 'value' => 'PREENCHER DEPOIS DE LANÇAR',
      ],
    ];

    foreach ($configurations as $configuration)
    {
      Configuration::create($configuration);
    }
  }
}
