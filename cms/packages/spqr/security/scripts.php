<?php

use Doctrine\DBAL\Schema\Comparator;

return [
    
    /*
     * Installation hook
     *
     */
    'install'   => function ($app) {
        
        $util = $app['db']->getUtility();
        
        if ($util->tableExists('@security_ban') === false) {
            $util->createTable('@security_ban', function ($table) {
                $table->addColumn('id', 'integer', [
                        'unsigned'      => true,
                        'length'        => 10,
                        'autoincrement' => true,
                    ]);
                $table->addColumn('ip', 'string', ['length' => 255]);
                $table->addColumn('status', 'smallint');
                $table->addColumn('reason', 'text');
                $table->addColumn('jail', 'string', ['length' => 255]);
                $table->addColumn('data', 'json_array', ['notnull' => false]);
                $table->addColumn('date', 'datetime', ['notnull' => false]);
                $table->addColumn('modified', 'datetime');
                $table->setPrimaryKey(['id']);
            });
        }
        
        if ($util->tableExists('@security_entry') === false) {
            $util->createTable('@security_entry', function ($table) {
                $table->addColumn('id', 'integer', [
                        'unsigned'      => true,
                        'length'        => 10,
                        'autoincrement' => true,
                    ]);
                $table->addColumn('event', 'string', ['length' => 255]);
                $table->addColumn('ip', 'string', ['length' => 255]);
                $table->addColumn('referrer', 'string', ['length' => 255]);
                $table->addColumn('data', 'json_array', ['notnull' => false]);
                $table->addColumn('date', 'datetime', ['notnull' => false]);
                $table->setPrimaryKey(['id']);
            });
        }
        
    },
    
    /*
     * Enable hook
     *
     */
    'enable'    => function ($app) {
    },
    
    /*
     * Uninstall hook
     *
     */
    'uninstall' => function ($app) {
        // remove the tables
        $util = $app['db']->getUtility();
        
        if ($util->tableExists('@security_ban')) {
            $util->dropTable('@security_ban');
        }
        
        if ($util->tableExists('@security_entry')) {
            $util->dropTable('@security_entry');
        }
        
        // remove the config
        $app['config']->remove('spqr/security');
    },
    
    /*
     * Runs all updates that are newer than the current version.
     *
     */
    'updates'   => [],

];