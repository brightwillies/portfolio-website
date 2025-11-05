<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

if (!function_exists("generate_mask")) {
    function generate_mask()
    {
        return $uuid = (string) Str::orderedUuid();
    }
}
if (!function_exists("generate_random_password")) {
    function generate_random_password($min = 1111, $max = 9999999)
    {
        return rand($min, $max);
    }


}

if (!function_exists("deleteItemOldImage")) {
    function deleteOldImage($filename, $folder)
    {
        $path = "/" . $folder . "/" . $filename;
        File::delete($path);
        // File::delete(public_path($path));
    }
}

if (!function_exists("uploadItemImage")) {
    function uploadItemImage($file, $name, $folder, $subfix = null)
    {
        $extension = $file->getClientOriginalExtension();
        $originalName = Str::slug($name) . $subfix;
        $imageName = $originalName . '.' . $extension;
        $file->move(($folder), $imageName);
        // $file->move(public_path($folder), $imageName);

        $url = url('/');
        $path = $url . '/' . $folder . '/' . $imageName;
        $result = new \stdClass();
        $result->filename = $imageName;
        $result->path = $path;
        return $result;
    }
}

if (!function_exists("generate_mask_string")) {
    function generate_mask_string($min = 1111, $max = 9999999)
    {
        return md5(uniqid(mt_rand($min, $max)));
    }
}

if (!function_exists("getMonth")) {
    function getMonth($name)
    {
        switch ($name) {
            case 1:
                return 'January';
                break;
            case 2:
                return 'February';
                break;
            case 3:
                return 'March';
                break;
            case 4:
                return 'April';
                break;
            case 5:
                return 'May';
                break;
            case 6:
                return 'June';
                break;
            case 7:
                return 'July';
                break;
            case 8:
                return 'August';
                break;
            case 9:
                return 'September';
                break;
            case 10:
                return 'October';
                break;
            case 11:
                return 'November';
                break;
            case 12:
                return 'December';
                break;

            default:
                # code...
                break;
        }
    }
}



function sendSms(
    // string $client_id,
    // string $client_secret,
    string $receiver,
    string $message

) {
    try {
        $client_user = 'dwapapabusiness@gmail.com';
        $client_password = 'Dwapapa@2023!!..';
        $sender = 'Dwapapa';
        // URL for sending message.
        $smsUrl = "http://api.smsonlinegh.com/sendsms.php";
        $user = urlencode($client_user);
        $password = urlencode($client_password);
        $message = urlencode($message);
        $sender = urlencode($sender);
        $type = 0;
        $destination = $receiver; // "0241726707,0504989952,0241492118";
        $params = "user={$user}&password={$password}&message={$message}" . "&type={$type}&sender={$sender}&destination={$destination}";
        $liveUrl = "{$smsUrl}?{$params}";
        return file_get_contents($liveUrl);
    } catch (Exception $e) {
        return null;
    }
}
