<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'contacts', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'vorname' )->nullable();
            $table->string( 'name' )->index();
            $table->string( 'telefon' )->nullable();
            $table->string( 'email' )->index();
            $table->string( 'strasse' )->index()->nullable();
            $table->string( 'adresszusatz' )->nullable()->index();
            $table->string( 'plz' )->nullable()->index();
            $table->string( 'ort' )->nullable()->index();
            $table->string( 'newsletter' )->nullable();
            $table->text( 'hinweise' )->nullable();
            $table->string( 'origin' )->nullable()->index();
            $table->string( 'betreff' )->nullable();
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
        Schema::dropIfExists( 'contacts' );
    }
}
