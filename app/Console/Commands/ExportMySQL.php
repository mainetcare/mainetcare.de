<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportMySQL extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export a MySQL-Database into storage/sqlfiles/dump.sql';

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
        $this->line( 'Backup database  ' . env( 'DB_DATABASE' ) . ' ...' );
        $cmd = sprintf( "mysqldump -h'%s' --port='%s' -u'%s' --password='%s' '%s' > %s",
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
