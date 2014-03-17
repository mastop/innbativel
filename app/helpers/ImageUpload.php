<?php

class ImageUpload {

	protected $s3;
	protected $basePath;
	protected $style;

    public function __construct(AWS $aws)
    {
        $this->s3 = $aws->get('s3');
    }

    private static function generateName($path)
    {
    	$name = Str::lower(Str::random(32));

    	if (!File::exists($path))
    	{
    		File::makeDirectory($path,  $mode = 0777, $recursive = true);
    	}

    	if (File::exists($path . $name))
    	{
    		static::generateName($path);
    	}

    	return $name;
    }

	public static function createFrom($input = null, $style = null)
	{
		if (is_null($input) || is_null($style))
		{
			return null;
		}

		$return = [];

		$file = $input;
		$mime = $file->getMimeType();
		$mext = FileMime::get($mime);
		$type = '.' . $mext;

		foreach ($style as $styleName) {
			foreach ($styleName as $key => $val) {
				if (!in_array($mime, $val['mimes']))
				{
					return null;
				}

				if ($key === 'original')
				{
					$name = static::generateName($val['path']);
					$full = $val['path'] . $name . $type;
					$file->move($val['path'], $name . $type);
				}

				else
				{
					if (isset($full)) {
						$name = static::generateName($val['path']);
						Image::make($full)
							// ->resize($val['style']['width'], $val['style']['height'], true, true)
							->grab($val['style']['width'], $val['style']['height'])
							->save($val['path'] . $name . $type);
					}
				}

				$pathToDb = str_replace(public_path(), '', $val['path'] . $name . $type);

				$return[] = $key . ':' . $pathToDb;
			}
		}

		// // $s3 = AWS::get('s3');
		// // $s3->putObject(array(
		// //     'Bucket'     => 'innbativel',
		// //     'Key'        => Str::random(16) . $cover_img_name,
		// //     'SourceFile' => $cover_img_normal . $cover_img_name,
		// // ));

		return implode($return, ',');
		// die;
	}

}
