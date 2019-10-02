<?php

class Group {

	var $title;
	var $entries;


	function __construct(string $title, array $entries)
	{
		$this->title = $title;
		$this->entries = $entries;
	}



}
