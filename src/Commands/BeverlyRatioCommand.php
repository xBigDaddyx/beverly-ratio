<?php

namespace Xbigdaddyx\BeverlyRatio\Commands;

use Illuminate\Console\Command;

class BeverlyRatioCommand extends Command
{
    public $signature = 'beverly-ratio';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
