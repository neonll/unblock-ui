<?php

class MainController {

	public function getDataJson()
	{
		$text = '';
		$file = new FileController;
		$groups = $file->readFile();

		return json_encode($groups);
	}

	public function getDataRaw()
	{
		$file = new FileController;
		return $file->readFileRaw();
	}

	public function parseData($data)
	{
		$text = '';
		foreach ($data as $key => $group) 
		{
			$text .= '###'.$group['title'].PHP_EOL;
			foreach ($group['entries'] as $entry) 
			{
				$text .= (isset($entry['active']) ? '' : '#').$entry['url'].PHP_EOL;
			}
			$text .= PHP_EOL;
		}

		$file = new FileController;
		if ($file->writeFile($text))
			return 1;
		else
			return 0;

	}

	public function saveRaw(string $text)
	{
		$file = new FileController;
		if ($file->writeFile(str_replace(["\x0A\x0D","\x0D\x0A","\x0A","\x0D"], PHP_EOL, $text)))
			return 1;
		else
			return 0;
	}

}