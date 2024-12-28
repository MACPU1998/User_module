<?php

namespace App\Console\Commands;

use App\Enums\ProjectStatus;
use App\Models\Admin\Setting;
use App\Models\UserProject;
use App\Models\UserProjectItem;
use Exception;
use http\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserProjectCodeGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:project-code-generator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $userProjects = UserProject::whereNull("code")->get();
            DB::beginTransaction();
            foreach ($userProjects as $project){
                $code = date("ymdis").rand(1000,9999);
                $project->update([
                    "code"=>$code,
                ]);
                sleep(1);
                dump("code: ".$code);
            }
            DB::commit();
        }
        catch (Exception $e){
            dump("error: ".$e);
            Log::error("Project code error: ".$e->getMessage());
            DB::rollBack();
        }

    }
}
