<?php

namespace OCA\LibreOnline\AppInfo;

return ['routes' => [
	['name' => 'api#saveFile', 'url' => '/save/', 'verb' => 'GET'],
	['name' => 'api#generateFileURL', 'url' => '/generateFileURL/', 'verb' => 'GET'],
	['name' => 'display#showLibreOnline', 'url' => '/', 'verb' => 'GET']

]];
