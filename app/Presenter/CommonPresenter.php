<?php
/**
 * Created by PhpStorm.
 * User: mmai
 * Date: 10.07.17
 * Time: 10:35
 */

namespace App\Presenter;


trait CommonPresenter {

	public function mailto( $fieldname = 'email' ) {
		return '<a href="mailto:' . $this->entity->$fieldname . '">' . $this->entity->$fieldname . '</a>';
	}

	public function created_at() {
		return $this->entity->created_at ? $this->entity->created_at->format( 'Y-m-d H:i' ) : null;
	}

	protected function pp_concat(...$values ) {
		return implode(' - ', $values);
	}

	protected function br_concat(...$values ) {
		return implode('<br>', $values);
	}

}
