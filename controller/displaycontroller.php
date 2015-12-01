<?php

namespace OCA\LibreOnline\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\IURLGenerator;

class DisplayController extends Controller {

	/** @var IURLGenerator */
	private $urlGenerator;

	/**
	 * @param string $AppName
	 * @param IRequest $request
	 * @param IURLGenerator $urlGenerator
	 */
	public function __construct($AppName,
								IRequest $request,
								IURLGenerator $urlGenerator) {
		parent::__construct($AppName, $request);
		$this->urlGenerator = $urlGenerator;
	}

	/**
	 * @PublicPage
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function showLibreOnline() {
		$params = [
			'urlGenerator' => $this->urlGenerator
		];
		$response = new TemplateResponse($this->appName, 'online', $params, 'blank');

		$policy = new ContentSecurityPolicy();
		$policy->addAllowedChildSrcDomain('*');
		$policy->addAllowedScriptDomain("*");
		$policy->addAllowedConnectDomain("*");
		$policy->addAllowedStyleDomain("*");
		$policy->addAllowedMediaDomain("*");
		$policy->addAllowedFontDomain('*');
		$policy->addAllowedImageDomain('*');
		$policy->addAllowedFrameDomain('*');
		$policy->addAllowedObjectDomain('*');
		$policy->allowInlineScript(True);
		$policy->allowInlineStyle(True);
		$policy->allowEvalScript(True);
		$response->setContentSecurityPolicy($policy);

		return $response;
	}

}
