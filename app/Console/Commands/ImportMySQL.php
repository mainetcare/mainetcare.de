<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportMySQL extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the MySQL-Database from storage/sqlfiles/dump.sql';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        if ( env( 'APP_ENV' ) != 'local' ) {
            $this->error( 'This command is for local environment only' );

            return 0;
        }
        $this->line( 'Restore database  ' . env( 'DB_DATABASE' ) . ' ...' );
        $cmd = sprintf( "mysql -h'%s' --port='%s' -u'%s' --password='%s' '%s' < %s",
            env( 'DB_HOST' ),
            env( 'DB_PORT' ),
            env( 'DB_USERNAME' ),
            env( 'DB_PASSWORD' ),
            env( 'DB_DATABASE' ),
            storage_path( 'app/sqlfiles/dump.sql' )
        );
        exec( $cmd );
        $this->info( 'Done!' );
        return 0;
    }
}
