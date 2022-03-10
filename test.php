<?php
/*
	task
	1. Напишите функцию подготовки строки, которая заполняет шаблон данными из указанного объекта
	2. Пришлите код целиком, чтобы можно его было проверить
	3. Придерживайтесь code style текущего задания
	4. По необходимости - можете дописать код, методы
	5. Разместите код в гите и пришлите ссылку
*/

/**
 * Класс для работы с API
 *
 * @author		User Name
 * @version		v.1.0 (dd/mm/yyyy)
 */
class Api
{
	public function __construct()
	{
	
	}


	/**
	 * Заполняет строковый шаблон template данными из объекта object
	 *
	 * @author		User Name
	 * @version		v.1.0 (dd/mm/yyyy)
	 * @param		array $array
	 * @param		string $template
	 * @return		string
	 */
	public function get_api_path1(array $array, string $template) : string
	{
		$result = '';
		$search = [];
		$replace = [];
		foreach ($array as $key => $value) {
			$search[] = '%' . $key . '%';
			$replace[] = $value;
		}
		$result = str_replace($search, $replace, $template);
		return $result;
	}
	/* 
		минус "/api/items/id/%id%/%name%" в таком варианте id
		без предстоящих знаков %% тоже заменит на соответсвующее
		значение из $array
	*/
	public function get_api_path2(array $array, string $template) : string {
		$result = '';
		$result = str_replace(array_keys($array), array_values($array), str_replace("%", "", $template));
		return $result;
	}
}

$user =
[
	'id'		=> 20,
	'name'		=> 'John Dow',
	'role'		=> 'QA',
	'salary'	=> 100
];

$api_path_templates =
[
	"/api/items/%id%/%name%",
	"/api/items/%id%/%role%",
	"/api/items/%id%/%salary%"
];

$api = new Api();
for ($i = 1; $i <= 2; $i++) {	
	$api_paths = array_map(function ($api_path_template) use ($api, $user, $i)
	{
		$func = 'get_api_path' . $i;
		return $api->$func($user, $api_path_template);
	}, $api_path_templates);
	echo 'Вариант ' . $i .': '. '<br>';
	echo json_encode($api_paths, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
	echo '<br>';
}
$expected_result = ['/api/items/20/John%20Dow','/api/items/20/QA','/api/items/20/100'];
