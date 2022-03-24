<?php

return [

	'user-field-types' => [
						'Text' => 'Text', 
						'Long Text' => 'Long Text', 
						'Number' => 'Number', 
						'Date' => 'Date', 
						'Time' => 'Time', 
						'Timestamp' => 'Timestamp', 
						'Decimal'=>'Decimal', 
						'Dropdown'=>'Dropdown', 
						'Multiple selection'=>'Multiple selection'
					],


	'operators' => [
		'equals' 				=> 'equals',
		'not equals' 			=> 'notequals',	
		'contains'				=> 'contains',
		'does not contains' 	=> 'does not contains',
		'starts with'			=> 'starts with',
		'does not starts with'	=> 'does not starts with',
		'ends with'			=> 'starts with',
		'does not ends with'	=> 'does not starts with',
		'is empty'				=> 'is empty',
		'is not empty'			=> 'is not empty',
		'>'						=> '>',
		'>='					=> '>=',
		'<'						=> '<',
		'>='					=> '>=',
		'between'				=> 'between',
	],		

	'operator_options' => [
		'equals' 				=> 1,
		'not equals' 			=> 1,	
		'contains'				=> 1,
		'does not contains' 	=> 1,
		'starts with'			=> 1,
		'does not starts with'	=> 1,
		'ends with'			=> 1,
		'does not ends with'	=> 1,
		'is empty'				=> 0,
		'is not empty'			=> 0,
		'>'						=> 1,
		'>='					=> 1,
		'<'						=> 1,
		'>='					=> 1,
		'between'				=> 2,
	],				

];