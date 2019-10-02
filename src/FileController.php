<?php

class FileController {

	CONST URL = '/opt/etc/unblock.txt';
	CONST SCRIPT_URL = '/opt/bin/unblock_update.sh';

	private function openFile(string $mode = 'r')
	{
		$url = self::URL;
		$file = fopen($url, $mode);

		return $file;
	}

	private function closeFile($file)
	{
		return fclose($file);
	}

	public function readFileRaw()
	{
		$url = self::URL;

		return file_get_contents(self::URL);
	}

	public function readFile()
	{
		if ($file = $this->openFile('r'))
		{
			$groups = [];
			$i = -1;

			while ($line = fgets($file, 256))
			{
				$line = trim($line);

				if (strlen($line))
				{
					if (stripos($line, '###') !== false)
					{
						$i++;
						$groups[$i] = new Group(substr($line, 3), []);
					}
					else
					{
						 $entry = new Entry;

						 if (stripos($line, '#') !== false)
						 {
						 	$entry->active = false;
						 	$entry->url = substr($line, strripos($line, '#')+1);
						 }
						 else
						 	$entry->url = $line;

						 if ($entry->url)
						 	$groups[$i]->entries[] = $entry;
					}
				}

			}

			return $groups;

			if (!$this->closeFile($file))
				return 'Не удалось закрыть файл!';
		}
		else
		{
			return 'Не удалось открыть файл!';
		}
	}

	public function writeFile(string $text)
	{
		$url = self::URL;
		// $url = './unblock.txt';

		if (file_put_contents($url, $text))
		{
			shell_exec(self::SCRIPT_URL);
			return 1;
		}
		else
			return 0;
	}

}