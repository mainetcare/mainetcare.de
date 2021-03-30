<?php


namespace App\Helpers;


use Statamic\Facades\Fieldset;
use Statamic\Facades\GlobalSet;
use Statamic\Fields\Field;

class StatamicHelper {


    /**
     * returns the label of a key => label stored Select-List
     * @param $key
     * @param $field
     * @param $fieldset
     *
     * @return mixed
     */
    public static function getLabelOfFieldsetSelect($key, $field, $fieldset) {
        /**
         * @var $fieldset \Statamic\Fields\Fieldset
         */
        $fieldset = Fieldset::find($fieldset);

        /**
         * @var $field Field
         */
        $field = $fieldset->field($field);

        return (collect($field->get('options'))->get($key));

    }

    /**
     * @param $handle
     * @param $field
     *
     * @return mixed | null
     */
    public static function getGlobalvar($handle, $field) {
        return GlobalSet::findByHandle($handle)->inCurrentSite()->get($field);
    }


}
