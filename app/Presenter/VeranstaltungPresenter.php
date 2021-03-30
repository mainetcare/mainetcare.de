<?php

namespace App\Presenter;

use Arr;
use Illuminate\Support\Carbon;
use Laracasts\Presenter\Presenter;


class VeranstaltungPresenter extends Presenter {


    public function month() {
        /**
         * @var $date Carbon
         */
        $date =  $this->entity->startdate;
        if(!$date) {
            return '';
        }
        return $date->monthName;
    }

    public function day() {
        /**
         * @var $date Carbon
         */
        $date =  $this->entity->startdate;
        if(!$date) {
            return '';
        }
        return $date->format('d');
    }

    public function year() {
        /**
         * @var $date Carbon
         */
        $date =  $this->entity->startdate;
        if(!$date) {
            return '';
        }
        return $date->year;
    }



}
