<?php
// 'tags'

class TagsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
	$tags = [
		[ 'title' => 'natal' ],
		[ 'title' => 'páscoa' ],
		[ 'title' => 'feriado' ],
		[ 'title' => 'copa do mundo 2014' ],
		[ 'title' => 'olimíadas 2016' ],
	];

    foreach ($tags as $tag)
    {
      Tag::create($tag);
    }
  }
}
