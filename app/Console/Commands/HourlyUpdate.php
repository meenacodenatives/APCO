<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Mail;
class HourlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an hourly email to all the users';

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
            //return 0;
        $result = DB::select("select * from email_notification where is_active = true AND notify_status=1");
        foreach ($result as $details)
        {
            Mail::to($details->email_to)->send(new \App\Mail\mail($details));
            $param['notify_status'] = 0;
            DB::table('email_notification')
                ->where('email_to', $details->email_to)
                ->update($param);
             // check for failures
        if (Mail::failures()) {
            // return response showing failed emails
            $this->info('Mail has been not sent successfully'.$details->email_to);
        }
        else
        {
            $this->info('Mail has been sent successfully');
        }
        }
       
    }
}