<?php

/*
	SEMPRE INSERIR O ORIGINAL PRIMEIRO - SEMPRE
*/

return [

	'offer' => [
		'cover' => [
			'original' => [
				's3'     => false,
				'path'   => public_path() . '/assets/uploads/images/offers/cover/original/',
				'mimes'  => ['image/jpg', 'image/jpeg', 'image/png'],
				'style' => [
					'width' => null,
					'height' => null,
				],
			],
			'full' => [
				's3'     => false,
				'path'   => public_path() . '/assets/uploads/images/offers/cover/full/',
				'mimes'  => ['image/jpg', 'image/jpeg', 'image/png'],
				'style' => [
					'width' => 1140,
					'height' => 380,
				],
			],
			'normal' => [
				's3'     => false,
				'path'   => public_path() . '/assets/uploads/images/offers/cover/normal/',
				'mimes'  => ['image/jpg', 'image/jpeg', 'image/png'],
				'style' => [
					'width' => 555,
					'height' => 225,
				],
			],
			'thumb' => [
				's3'     => false,
				'path'   => public_path() . '/assets/uploads/images/offers/cover/thumb/',
				'mimes'  => ['image/jpg', 'image/jpeg', 'image/png'],
				'style' => [
					'width' => 100,
					'height' => null,
				],
			],
			'preview' => [
				's3'     => false,
				'path'   => public_path() . '/assets/uploads/images/offers/cover/preview/',
				'mimes'  => ['image/jpg', 'image/jpeg', 'image/png'],
				'style' => [
					'width' => 200,
					'height' => 86,
				],
			],
		],
	],

];
