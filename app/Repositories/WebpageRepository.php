<?php


namespace App\Repositories;

use App\Models\Webpage;

class WebpageRepository {

    /**
     * @var Webpage|null
     */
    protected $page = null;

    public function __construct(Webpage $page = null) {
        if($page === null) {
            $this->page = new Webpage();
        }
    }

    /**
     * @return mixed
     */
    public function getHomepage() {
        $this->page = new Webpage();
        return $this->page->where('is_homepage', 1)->first();
    }


}
