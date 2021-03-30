<?php

namespace App\Http\Livewire;

use App\Factories\AngebotFactory;
use App\Jobs\ProcessAddAngebotToCart;
use App\Models\Angebot;
use App\Services\BulkPrices;
use App\Services\Pluralizer;
use Livewire\Component;
use Validator;

class AddAngebotToCart extends Component {

    public $unit;
    public $variant;

    public $max_amount;
    public $default_amount;

    public $max_multiplier;
    public $default_multiplier;

    public $multiplier_label;

    public $entry_id;
    public $price;

    protected $angebot = null;
    protected $has_multiplier = true;

    public function mount( Angebot $angebot, string $unit, string $variant = null ) {

        $nights = cart()->nights;

        $this->default_amount = $unit == 'tag' ? $nights : 1;
        $this->max_amount     = $nights > 20 ? $nights : 20;

        $this->entry_id = $angebot->id;
        $this->unit     = $unit;
        $this->variant  = $variant;
        $this->angebot  = $angebot;

        $this->initData();

    }

    public function initData() {
        $bulkprices             = app( BulkPrices::class, [
            'model'   => $this->angebot,
            'unit'    => $this->unit,
            'variant' => $this->variant
        ] );
        $this->has_multiplier   = $bulkprices->hasMultiplier();
        $this->multiplier_label = 'Wie viele ' . Pluralizer::get( $bulkprices->getMultiplier() );
        // @todo make this configurable per unit
        $this->max_multiplier     = 10;
        $this->default_multiplier = 1;
    }

    /**
     * @param $id
     *
     * @return Angebot
     */
    protected function getModel( $id ) {
        return app( AngebotFactory::class )->initById( $id );
    }

    public function submit( $formData ) {

        $multiplier = $formData['multiplier'];
        $amount     = $formData['amount'];
        $unit       = $formData['unit'];

        $model = $this->getModel( $formData['entry_id'] );
        if ( ! $model ) {
            $this->addError( 'init', 'Fehler. Angebot konnte nicht hinzugefügt werden.' );
        }
        $this->angebot = $model;

        $data = Validator::make(
            [
                'multiplier' => $multiplier,
                'amount'     => $amount,
                'unit'       => $unit
            ],
            [
                'multiplier' => [
                    'required',
                    'numeric',
                    [ 'max', $this->max_multiplier ]
                ],
            ],
            [
                'required' => 'Bitte :attribute wählen',
                'numeric'  => ':attribute ist keine Zahl',
                'max'      => 'Maximalwert von ' . $this->max_multiplier . ' überschritten',
            ]
        )->validate();

        $this->addToCart( $model, $formData );

        // rerender Cart:
        $this->emit( 'refreshCart' );

        $this->dispatchBrowserEvent( 'ltoast', [
            'type'    => 'success',
            'message' => $model->title . ' wurde hinzugefügt / aktualisiert',
        ] );

        $this->initData();

    }

    protected function addToCart( Angebot $angebot, $data ) {

        $cart = cart();
        app( ProcessAddAngebotToCart::class, [
            'arrSelection' => [
                'angebot'    => $angebot,
                'cart'       => $cart,
                'unit'       => $data['unit'],
                'variant'    => $this->variant,
                'amount'     => $data['amount'],
                'multiplier' => $data['multiplier']
            ]
        ] )->handle();

    }

    public function render() {
        return view( 'livewire.add-angebot-to-cart', [
            'angebot'          => $this->angebot,
            'has_multiplier'   => $this->has_multiplier,
            'multiplier_label' => $this->multiplier_label
        ] );
    }


}
