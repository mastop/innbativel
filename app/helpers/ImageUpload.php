<?php

class ImageUpload {

	public static function upload($file, $directory, $id, $name){
        $s3access = Configuration::get('s3access');
        $s3secret = Configuration::get('s3secret');
        $s3region = Configuration::get('s3region');
        $s3bucket = Configuration::get('s3bucket');

        $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

        $s3 = Aws\S3\S3Client::factory(
            array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
        );

        $path = $file->getRealPath();
        $mime = $file->getMimeType();
        $newpath = "$directory/$id/$name";
        
        $s3->putObject(array(
            'Bucket'     => $s3bucket,
            'Key'        => $newpath,
            'Body'      => file_get_contents($path),
            'ACL'        => 'public-read',
            'CacheControl' => 'max-age=315360000',
            'ContentType' => $mime,
            'Expires'    => $expires
        ));

        return '//'.Configuration::get('s3url').'/'.$newpath;
    }

}
