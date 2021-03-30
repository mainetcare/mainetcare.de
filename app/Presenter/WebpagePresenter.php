<?php

namespace App\Presenter;

use Laracasts\Presenter\Presenter;


class WebpagePresenter extends Presenter {


    /**
     * Use with eager loading!!
     */
    public function full_slug() {
        $prefix = $this->entity->pagecategory !== null ? $this->entity->pagecategory->slug . '/' : '';
        return $prefix . $this->entity->slug;
    }


}
