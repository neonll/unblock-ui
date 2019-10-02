<?php

class Entry {

	var $url;
	var $active;

	function __construct(string $url = null, bool $active = true)
	{
		$this->url = $url;
		$this->active = $active;
	}

}