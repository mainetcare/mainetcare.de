<?php


namespace App\Models;


use Statamic\Assets\Asset;

/**
 * Class EntryModel, Wrapper for Statamic Entry as Data-Storage
 * @todo needs architectal improvement
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class EntryModel extends MncModel {

    protected $guarded = [];

    /**
     * We use the entry key
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var null | \Statamic\Entries\Entry
     */
    public $entry = null;

    /**
     * @param $status
     * @param $statusmessage
     *
     * @return $this
     */
    public function setStatus( string $status, string $statusmessage ) {
        $this->status                   = $status;
        $this->statusmessage            = $statusmessage;
        $this->entry->app_status        = $status;
        $this->entry->app_statusmessage = $statusmessage;

        return $this;
    }

    public function resetStatus() {
        $this->entry->app_status        = '';
        $this->entry->app_statusmessage = '';
    }

    /**
     * @param float $price
     */
    public function setCurrentPrice( float $price ) {
        $this->entry->set( 'current_price', $price );
    }

    /**
     * @return float
     */
    public function getCurrentPrice() {
        return (float) $this->entry->get( 'current_price' );
    }

    public function getTitleAttribute() {
        return $this->entry->get( 'title' );
    }

    public function getSlugAttribute() {
        return $this->entry->slug();
    }

    /**
     * Getter for Teaser Image
     *
     * @return null | Asset
     */
    public function getColImgAttribute() {
        if ( $already_fetched = $this->getAttributeFromArray( 'col_img' ) ) {
            return $already_fetched;
        }
        if ( $image = $this->entry->augmentedValue( 'col_img' )->value() ) {
            $this->setAttribute( 'col_img', $image );

            return $image;
        }

        return null;

    }


}
