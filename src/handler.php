<?php

include 'classes.php';

$handler = new MainController;

switch ($_GET['action']) 
{
	case 'get':
		echo $handler->getDataJson();
		break;
	case 'getraw':
		echo $handler->getDataRaw();
		break;
	case 'parse':
		if ($handler->parseData($_POST))
			echo 1;
		else
			echo 0;
		break;
	case 'saveraw':
		if ($handler->saveRaw($_POST['text']))
			echo 1;
		else
			echo 0;
		break;
	default:
		echo -1;
		break;
}
