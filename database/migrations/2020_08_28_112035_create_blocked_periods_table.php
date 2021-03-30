<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockedPeriodsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'blocked_periods', function ( Blueprint $table ) {
            $table->id();
            $table->date( 'start' );
            $table->date( 'end' );
            $table->string( 'blockable_id' )->index();
            $table->string( 'blockable_type' );
            $table->string( 'reason' )->nullable()->index();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'blocked_periods' );
    }
}
