<?php

namespace HesamRad\Flashlight\Drivers;

use Illuminate\Support\Facades\DB;

class Database implements Loggable
{
     /**
     * The table where the logs are stored.
     *
     * @var string
     */
    protected string $path;

    /**
     * Create a new instance of this class.
     *
     * @param  string  $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Log the given data in the database.
     *
     * @param  array  $data
     * @return void
     */
    public function log($data)
    {
        DB::table($this->path)
            ->insert($data);
    }
}
