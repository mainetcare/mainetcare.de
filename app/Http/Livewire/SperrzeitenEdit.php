<?php

namespace App\Http\Livewire;

use App\Factories\AppartementFactory;
use App\Models\Appartement;
use App\Models\BlockedPeriod;
use Livewire\Component;
use Validator;

class SperrzeitenEdit extends Component {

    public $blocked_periods = null;

    public $new = [];

    public $appartement_id = '';

    /**
     * @var null | Appartement
     */
    protected $appartement = null;

    protected $periods = null;

    public $sperrzeiten = [];


    protected $rules = [
        'new.von'    => 'required|date',
        'new.bis'    => 'required|date',
        'new.status' => 'required',
    ];

    protected $messages = [
        'new.von.required'    => 'Bitte "von" für neue Sperrzeit ausfüllen',
        'new.bis.required'    => 'Bitte "bis" für neue Sperrzeit ausfüllen',
        'new.status.required' => 'Bitte "Status" für neue Sperrzeit ausfüllen',
    ];

    public function mount( $appartement_id ) {
        $this->initAppartement( $appartement_id );
        $this->initSperrzeiten();
    }

#
    public function newPeriod() {
        $this->validate();

        $this->appartement->block( $this->new['von'], $this->new['bis'], $this->new['status'] );
        $this->dispatchBrowserEvent( 'ltoast', [
            'type'    => 'success',
            'message' => 'Neue Sperrzeit wurde hinzugefügt',
        ] );

    }

    public function updateSperrzeit( $period_id ) {
        $period   = $this->getBlockedPeriod( $period_id );
        $raw_data = $this->sperrzeiten[ $period_id ];
        $data     = Validator::make(
            [
                'start'  => $raw_data['start'],
                'end'    => $raw_data['end'],
                'reason' => $raw_data['reason']
            ],
            [
                'start'  => 'required|date',
                'end'    => 'required|date',
                'reason' => 'required'
            ],
            [
                'required' => 'Bitte :attribute wählen',
                'date'     => ':attribute ist kein Datum'
            ]
        )->validate();

        $period->update( [
            'start'  => $data['start'],
            'end'    => $data['end'],
            'reason' => $data['reason']
        ] );

        $this->dispatchBrowserEvent( 'ltoast', [
            'type'    => 'success',
            'message' => 'Sperrzeit wurde aktualisiert',
        ] );


    }

    public function deleteSperrzeit( $period_id ) {
        $this->getBlockedPeriod($period_id)->delete();
        $this->dispatchBrowserEvent( 'ltoast', [
            'type'    => 'success',
            'message' => 'Sperrzeit wurde gelöscht',
        ] );
    }

    protected function refreshPage() {
        return redirect()->to(route('sperrzeiten.edit', ['id' => $this->appartement->id]));
    }


    public function hydrate() {
        $this->initAppartement();
        $this->initSperrzeiten();
    }

    /**
     * @param $id
     *
     * @return BlockedPeriod
     */
    protected function getBlockedPeriod( $id ) {

        // Id is saved in form "id" + Id eg "id2"
        $id = (int) str_replace('id', '', $id );

        try {
            $period = BlockedPeriod::findOrFail( $id );
        } catch (\Exception $e) {
            $this->addError( 'fail', $e->getMessage() );
            return null;
        }
        return $period;
    }

    protected function initSperrzeiten() {
        $this->sperrzeiten = [];
        $this->periods     = $this->appartement->blockedPeriods()->get();
        foreach ( $this->periods as $period ) {
            $this->sperrzeiten[ 'id'  . $period->id ] = [
                'id'     => $period->id,
                'start'  => $period->start,
                'end'    => $period->end,
                'reason' => $period->reason,
            ];
        }
    }

    protected function initAppartement( $app_id = null ) {
        if ( $app_id ) {
            $this->appartement_id = $app_id;
        }
        $this->appartement = app( AppartementFactory::class )->initById( $this->appartement_id );
        if ( ! $this->appartement ) {
            throw new \Exception( 'Appartement nicht geladen' );
        }
    }

    public function render() {
        $this->initSperrzeiten();

        return view( 'livewire.sperrzeiten-edit',
            [
                'appartement' => $this->appartement,
                'periods'     => $this->periods,
            ] );
    }
}
