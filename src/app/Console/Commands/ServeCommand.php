<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;

class ServeCommand extends BaseServeCommand
{
    /**
     * Get the full server command.
     *
     * @return array
     */
    protected function serverCommand()
    {
        $command = parent::serverCommand();
        
        // Sisipkan parameter INI kustom (upload_max_filesize & post_max_size) tepat setelah php binary path
        array_splice($command, 1, 0, [
            '-d', 'upload_max_filesize=10M',
            '-d', 'post_max_size=50M',
        ]);
        
        return $command;
    }
}
