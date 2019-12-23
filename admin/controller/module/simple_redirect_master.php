<?php

use SimpleRedirectMaster\Admin\Controller as AdminController;

class ControllerModuleSimpleRedirectMaster extends AdminController {

	const SUBVERSION = 's';

	public static final function getVersion() {
		return parent::getVersion() . self::SUBVERSION;
	}

}