<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendRootReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'root:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Root Email Report';

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
     * @return mixed
     */
    public function handle()
    {
        $registeredUsersCount = DB::table('users')->count();
        $locale = app()->getLocale();
        
        logger()->info('Generating Root Report');
        logger()->info('Users Count: ' . $registeredUsersCount);

        // Mail to User
        $mailParams = [
            'registeredUsersCount' => $registeredUsersCount
        ];
        Mail::send("emails.{$locale}.root.report", $mailParams, function ($mail) {
            $mail->to(env('ROOT_REPORT_MAIL'), 'Root')
                 ->subject('Root Report');
        });
    }
}
