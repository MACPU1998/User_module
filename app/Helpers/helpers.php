<?php

use App\Enums\ActiveStatus;
use App\Models\Admin\Admin;
use App\Models\Admin\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

if (!function_exists('getFile')) {
    function getFile($slug) {
        return Storage::disk('public')->url($slug);
    }
}
if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('buildTree')) {
    function buildTree(array &$elements,$parentColumn="parent_id", $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element[$parentColumn] == $parentId) {
                $children = buildTree($elements,$parentColumn, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id']] = $element;
                unset($elements[$element['id']]);
            }
        }
        return $branch;
    }
}



if(!function_exists('shamsiToTime'))
{
    function shamsiToTime($datetime,$seprator="/")
    {
        $dateTimeArray=explode(" ",numberToEnglish($datetime));
        $date=$dateTimeArray[0];
        $time=isset($dateTimeArray[1]) ? $dateTimeArray[1] :"00:00:00";
        list($y,$m,$d)=explode($seprator,$date);
        list($h,$i,$s)=explode(":",$time);
        return jmktime($h,$i,$s,$m,$d,$y);
    }
}

if(!function_exists('dateValue'))
{
    function dateValue($value,$seprator="/",$time=false)
    {
        $timestamps=strtotime($value);
        if(strtotime($value) < 0)
            return $value;
        else
            return jdate("Y",$timestamps).$seprator.jdate("m",$timestamps).$seprator.jdate("d",$timestamps);
    }
}


if(!function_exists('numberToEnglish'))
{
    function numberToEnglish($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }
}


if(!function_exists('multi_dim'))
{
    function multi_dim( $my_arr )
    {
    rsort( $my_arr );
    return isset( $my_arr[0] ) && is_array( $my_arr[0] );
    }
}

if (!function_exists('getRoutNameOfUrl')) {
    function getRoutNameOfUrl($url) {
        $url= str_replace(URL::to('/'),"",$url);
        $routes = Route::getRoutes();
        foreach ($routes as $route) {
            // Check if the route matches the given URL
            if ($route->matches(request()->create($url))) {
                return $route->getName();
            }
        }
    }
}


if (!function_exists('checkFilter')) {
    function checkFilter($tableName) {
       $current_route_name=Route::currentRouteName();
       $previous_route_name=getRoutNameOfUrl(url()->previous());


       if($current_route_name != $previous_route_name)
       {
          if(!session()->has("hasFilter"))
            session()->forget($tableName."_filter");
       }
    }
}
if(!function_exists('checkPermission'))
{
    function checkPermission($permission) {
        $role = auth()->guard("admin")->user()->roles()->first();
        $permissions_access = $role->permissions->pluck("name")->toArray();

        if(
            $role->name == "super admin"
            || ((isset($permission) && !$permission) || !isset($permission))
        )
            return true;
        else if (strpos($permission, "*") !== false) {

            $permission_check = substr($permission, 0, strpos($permission, "*") - 1);

            foreach ($permissions_access as $string) {
                if (str_contains($string, $permission_check)) {
                    return true;
                    break; // Exit the loop once the character is found in one string
                }
            }
        }
        else
            return $role->hasPermissionTo($permission,"admin");

    }
}

if(!function_exists('numtToEnglish'))
{
    function numtToEnglish($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }
}

if (!function_exists('getGeneralStatus')) {
    function getGeneralStatus($value)
    {
        $result = NUll;
        if ($value == ActiveStatus::ACTIVE->value)
            $result = '<span class="badge bg-label-success me-1">فعال</span>';
        elseif ($value == ActiveStatus::DEACTIVE->value)
            $result = '<span class="badge bg-label-warning me-1">غیرفال</span>';
        return $result;
    }
}

if (!function_exists('generateObjectForComponent')) {
    function generateObjectForComponent($data,$nameColumn,$valueColumn)
    {

        if(!is_a($data, 'Illuminate\Database\Eloquent\Collection') && !is_a($data, 'Illuminate\Support\Collection'))
            throw new Exception("input data must be collection");
        $data=$data->map(function ($item) use($nameColumn,$valueColumn){
            $final_array=[];
            $final_array['name'] = $item[$nameColumn];
            $final_array['value'] = $item[$valueColumn];
            return $final_array;
        });
        $data=arrayToObject($data);
        return $data;
    }
}

if(!function_exists('arrayToObject'))
{
    function arrayToObject($array)
    {
        return json_decode(json_encode($array),false);
    }
}

if(!function_exists('getPageTitle'))
{
    function getPageTitle()
    {
        $current_route_name = Route::currentRouteName();
        $permission = Permission::where("name",$current_route_name)->first();
        return __("permissions.".$permission->slug);
    }
}
if(!function_exists('errorMessage'))
{
    function errorMessage(\Throwable $th)
    {
        if(env('APP_DEBUG') == true)
            return $th->getMessage();
        else
            return __("message.error_occured");
    }
}

if (!function_exists('imageGenerator')) {
    function imageGenerator($value,$class=null,$defaultValue="nopic",$disk="public",$htmlTemplate=false)
    {
        $defaultValue=$defaultValue == "nopic" ? "noImage.jpg" : $defaultValue = "avatar.jpg";
        $value= (pathinfo($value,PATHINFO_EXTENSION) && Storage::disk($disk)->exists($value) )? Storage::disk($disk)->url($value) : asset("assets/img/default/{$defaultValue}");
        return $htmlTemplate ? "<div class='w-60px h-60px'><img src='{$value}' class='img-fluid object-fit-contain {$class}' alt=''/></div>" : $value;
    }
}

if (!function_exists('checkRouteExist')) {
    function checkRouteExist($routeName)
    {
        return Route::has($routeName);
    }
}
if (!function_exists('getPageTitle')) {
    function getPageTitle($routeName)
    {
        $permission = Permission::where("name",$routeName)->select("slug")->first();
        $permission_title = $permission ? __("permission.".$permission->slug) : __("general.not_found");
        return $permission_title;
    }
}
if (!function_exists('adminDepartmentAccess')) {
    function adminDepartmentAccessIds(Admin $admin = null)
    {
        $result = $admin ?  $admin->departments?->pluck("id")->toArray() : auth()->guard("admin")->user()->departments->pluck("id")->toArray();

        return count($result) > 0 ? $result : ["-1"];
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        return cache('settings_results')->where("key",$key)->first()?->value;
    }
}
if (!function_exists('getDownloadLink')) {
    function getDownloadLink($path)
    {
        $token = encrypt($path);
        return route("admin.file.download",$token);
    }
}
if (!function_exists('getApiDownloadLink')) {
    function getApiDownloadLink($path)
    {
        $token = encrypt($path);
        return route("api.v1.user.file.download",$token);
    }
}

if (!function_exists('updateSettings')) {
    function updateSettings($settingsData)
    {

        $query = "UPDATE settings SET value = CASE `key`";  // استفاده از `key`

        foreach ($settingsData as $key => $value) {
            $query .= " WHEN '{$key}' THEN '{$value}'";
        }

        $query .= " END WHERE `key` IN ('" . implode("','", array_keys($settingsData)) . "')";

        DB::statement($query);
    }
}

if (!function_exists('getUserType')) {
    function getUserType(): int
    {
        $user = auth()->user();
        $userClass = get_class($user);
        if($userClass=="App\Models\User")
            return 1;
        elseif($userClass=="App\Models\Admin\SalePartner")
            return 2;
        return 1;
    }
}

if (!function_exists('getGuard')) {
    function getGuard(): ?string
    {
        foreach(array_keys(config('auth.guards')) as $guard){

            if(auth()->guard($guard)->check()) return $guard;

        }
        return null;
    }
}

if (!function_exists('dropzoneStoreFiles')) {
    function dropzoneStoreFiles($model,$inputName,$collectionName)
    {

        foreach (request()->input($inputName, []) as $file) {
            $model->addMedia(storage_path('tmp/uploads/' . $file))
            ->toMediaCollection($collectionName);
        }
    }
}
if (!function_exists('dropzoneUpdateFiles')) {
    function dropzoneUpdateFiles($model,$inputName,$collectionName="*")
    {
        if (count($model->getMedia($collectionName)) > 0) {
            foreach ($model->getMedia($collectionName) as $media) {
                if (!in_array($media->file_name, request()->input($inputName, []))) {
                    $media->delete();
                }
            }
        }
        $media = $model->getMedia($collectionName)->pluck('file_name')->toArray();
        foreach (request()->input($inputName, []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $model->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection($collectionName);
            }
        }
    }
}
if (!function_exists('dropzoneDeleteFiles')) {
    function dropzoneDeleteFiles($model,$collectionName="*")
    {
        if (count($model->getMedia($collectionName)) > 0) {
            foreach ($model->getMedia($collectionName) as $media)
                    $media->delete();
        }
    }
}


