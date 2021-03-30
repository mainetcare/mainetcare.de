<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'cart_items', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'cart_id' )->constrained( 'carts' )->onDelete( 'cascade' );
            $table->foreignId( 'parent_id' )->nullable()->constrained( 'cart_items' )->onDelete( 'cascade' );
            $table->string( 'cat' );
            $table->string( 'title' );
            $table->string( 'unit' )->nullable();
            $table->string( 'class' )->nullable();
            $table->string( 'content' )->nullable();
            $table->string( 'model_id' )->nullable();
            $table->unsignedInteger( 'amount' )->nullable();
            $table->unsignedInteger( 'order_column' )->nullable();
            $table->float( 'total' )->nullable();
            $table->string( 'editroute' )->nullable();
            $table->json( 'data' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'cart_items' );
    }
}
