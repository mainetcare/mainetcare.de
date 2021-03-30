<?php

namespace Tests;

use DB;

trait DBSwitcher {

	protected function switchToMysql() {
		$this->refreshApplication();
		DB::setDefaultConnection('mysql');
	}


}
