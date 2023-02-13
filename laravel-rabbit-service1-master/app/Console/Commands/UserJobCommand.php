<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Jobs\UserCreated;
use Illuminate\Console\Command;

class UserJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        UserCreated::dispatch(User::inRandomOrder()->first()->toArray());
    }
}
