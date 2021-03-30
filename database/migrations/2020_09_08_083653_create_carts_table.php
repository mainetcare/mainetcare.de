<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'carts', function ( Blueprint $table ) {
            $table->id();
            $table->date( 'checkin' )->nullable();
            $table->date( 'checkout' )->nullable();
            $table->unsignedInteger( 'teilnehmer' )->nullable();
            $table->unsignedInteger( 'gaeste' )->nullable();
            $table->string( 'saison' )->nullable();
            $table->text( 'note' )->nullable();
            $table->string( 'status' )->nullable()->index();
            $table->unsignedInteger( 'step' )->nullable();
            $table->foreignId( 'contact_id' )->nullable();
            $table->timestamp( 'sent_at' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'carts' );
    }
}
