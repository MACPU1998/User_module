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

class ProjectItemInquery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:project-item-inquery';

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
            $userProjects = UserProject::whereIn("status",[ProjectStatus::PENDING->value, ProjectStatus::REVIEW->value])->get();
            DB::beginTransaction();
            foreach ($userProjects as $project){
                $items = $project->items;
                foreach ($items as $item){
                        $normalizedSerial = $this->normalizeSerial($item->serial);
                        $result = $this->curlRequest($normalizedSerial);
                        if($result){
                            $checkDuplicate = UserProjectItem::whereHas('project', function ($query) {
                                return $query->whereIn('status', [1,2]);
                            })->where("serial",'LIKE', '%'.$item->serial.'%')->get();

                            $item->update([
                                "title" => $result["GoodsTitle"],
                                "attribute" => $result["GoodsAttribute"],
                                "status" => count($checkDuplicate)>1?4:2
                            ]);

                        }
                        else
                            $item->update([
                                "status" => 3
                            ]);
                }
                $this->calcCredit($project);
            }
            DB::commit();
        }
        catch (Exception $e){
            Log::error("ProjectItemInquery error: ".$e->getMessage());
            DB::rollBack();
        }

    }

    public function calcCredit($project)
    {
        $eligible = true;
        $liters = 0;
        foreach ($project->items as $item){
            $liters += $item->attribute??0;
            if(in_array($item->status,[1,3,4]))
                $eligible = false;
        }
        if($eligible){
            $setting = Setting::where("key","coin_count_per_100_litr")->first();
            if($setting && is_numeric($setting->value)){
                $credit = $liters/100* (int)$setting->value;
                $credit = $credit + $project->credit;
                if($project->credit==0)
                    $project->update([
                        "credit" => $credit
                    ]);
            }
        }
        else
            $project->update([
                "credit" => 0
            ]);
    }

    public function curlRequest($code){
        try {
            $curl = curl_init();
            if ($curl === false) {
                throw new Exception('failed to initialize');
            }
            curl_setopt_array($curl, [
                CURLOPT_URL => env("ISYNCH_URL").$code,
                //CURLOPT_URL => "http://127.0.0.1:8484/checkBarcode/64654",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => [
                    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:105.0) Gecko/20100101 Firefox/105.0',
                    'Accept: */*',
                    'Accept-Language: en-US,en;q=0.5',
                    'Accept-Encoding: gzip, deflate, br',
                    'content-type: application/json',
                    'Connection: keep-alive',
                    'Sec-Fetch-Dest: empty',
                    'Sec-Fetch-Mode: cors',
                    'Sec-Fetch-Site: same-origin',
                    'TE: trailers',
                ],
            ]);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($curl);

            if ($response === false) {
                throw new Exception(curl_error($curl), curl_errno($curl));
            }
            curl_close($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if($httpcode==200){
                Log::info("ProjectItemInquery: ".$response);
                $response = json_decode($response, true);
                if(count($response["message"])>=1)
                    $response = $response["message"][0];
                else
                    $response = null;
                return $response;
            }
            else if($httpcode==500){
                Log::error("ProjectItemInquery error: ".$response);
                return null;
            }
            else
                Log::error("undefined response: ".$response);
                return null;
        } catch (Exception $exception) {
            Log::error($exception);
            return null;
        }
    }

    public function normalizeSerial(string $serial): string
    {
        $serial = str_replace("p","P",$serial);
        $serial = str_replace("g","G",$serial);
        if(strlen($serial)>7){
            if(is_int(strpos($serial,"P")))
                $serial = substr($serial, strpos($serial, "P"));
            elseif (is_int(strpos($serial,"G")))
                $serial = substr($serial, strpos($serial, "G"));
        }
        return $serial;
    }
}
