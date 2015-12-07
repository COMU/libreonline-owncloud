<?php

namespace OCA\LibreOnline\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\Files\IRootFolder;
use OCP\IURLGenerator;

class ApiController extends Controller {

	/** @var IURLGenerator */
	private $urlGenerator;
	private $rootFolder;
	private $userId;

	/**
	 * @param string $AppName
	 * @param IRequest $request
	 * @param IURLGenerator $urlGenerator
	 */
	public function __construct($AppName,
								IRootFolder $rootFolder,
								IRequest $request,
								IURLGenerator $urlGenerator,
								$userId) {
		parent::__construct($AppName, $request);

		$this->urlGenerator = $urlGenerator;
		$this->userId = $userId;
		$this->rootFolder = $rootFolder;
	}

	/**
	 * @PublicPage
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function saveFile($ip, $port, $jail, $dir, $name, $target) {

		$url = "http://$ip:$port/$jail/$dir/$name";
		file_put_contents(\OC::$SERVERROOT . "/data/" . $this->userId . "/files$target", file_get_contents($url));
	}


	/**
	 * @PublicPage
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function generateFileURL($file) {
		$url = sha1($file . mt_rand());
		$app_path = \OC_App::getAppPath("libreonline");
		$tmp_path = $app_path . '/tmp';
		copy(\OC::$SERVERROOT . "/data/" . $this->userId . "/files$file", "$tmp_path/$url");
		$uri = \OC_App::getAppWebPath('libreonline') . "/tmp/$url";
		return $uri;
	}
}
