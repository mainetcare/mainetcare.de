<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetProduction extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prod:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy the production Database into local and all contents from public/media. mysqldump with add-drop-tables ; preserves added files in local media folder';

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
        if(env('APP_ENV') != 'local') {
            $this->error('This command is for local environment only');
            return 0;
        }
        $this->line( 'Backup production database via SSH to local database: '.env('DB_DATABASE').' ...' );
        $cmd = sprintf( "ssh mnc 'mysqldump -h'%s' --port='%s' -u'%s' --password='%s' '%s' | bzip2 -c ' | bunzip2 -dc | mysql -h'%s' --port='%s' -u'%s' -p'%s' --database='%s'",
            env( 'DB_HOST_PROD' ),
            env( 'DB_PORT_PROD' ),
            env( 'DB_USERNAME_PROD' ),
            env( 'DB_PASSWORD_PROD' ),
            env( 'DB_DATABASE_PROD' ),

            env('DB_HOST'),
            env('DB_PORT'),
            env( 'DB_USERNAME' ),
            env( 'DB_PASSWORD' ),
            env( 'DB_DATABASE' )
        );
        echo( $cmd );
        $this->info('Done!');
        $this->line( 'Backup media Folder to local media folder ... ' );
        $cmd = sprintf("rsync -av mnc:~/rkb.mainetcare/public/assets/ %s/",
        public_path('assets')
        );
        echo( $cmd );

        $cmd = sprintf("rsync -av mnc:~/rkb.mainetcare/public/assets/ %s/",
            public_path('assets')
        );
        echo( $cmd );

        $this->info('done.');
        return 0;
    }
}
