<?php

/**
 *  Copyright (C) 2018 Appinventiv Technologies Pvt. Ltd.
 */

/**
 * Function to generate Hash String.
 * Using Argon2 Algorithm
 *
 * @param string $string
 * @return string generated Hash String
 */
function createHash(string $string)
{

    
    $hashed = Hash::make($string);

    if (Hash::needsRehash($hashed)) {
        $hashed = Hash::make($string);
    }

    return $hashed;

}



/**
 * Get User IP Address
 *
 * @return type
 */
function getIp()
{
    foreach (array ('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }

}



function accessDenied(string $msg)
{
    $message = '' != $msg ? $msg : 'Access Denied';
    abort(ACCESS_DENIED, $message);

}



/**
 * @function queryStringBuilder
 * @desc will convert query string into encrypted string
 * @param sting/array $QueryString
 *
 * @return string encrypted query string
 */
function queryStringBuilder($QueryString)
{

    if ( ! is_array($QueryString)) {
        $QueryString = queryStringToArray($QueryString);
    }

    return encryptDecrypt(json_encode($QueryString));

}



/**
 * Used to set default values to needed array index
 * pass to array First for values and Second for default values with same indexes
 * If in value array index has value then Ok
 * Otherwise second array index value will set
 *
 *
 * @function defaultValue
 * @description To set default value to the arrays required fields
 *
 * @param array $value array to check values
 * @param array $default Array having default values
 */
function defaultValue($value = array (), $default = array ())
{
    $response = array ();
    foreach ($default as $key => $values) {
        $response[$key] = (isset($value[$key]) && ! empty($value[$key])) ? $value[$key] : $default[$key];
    }
    return( $response );
    exit();

}



/**
 * @function jsonValidation
 * @description function to validate input JSON
 *
 * @param string $string String in JOSN Format
 */
function jsonValidation($string)
{
    json_decode($string);
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            return true;
            break;
        case JSON_ERROR_DEPTH:
            return false;
            break;
        case JSON_ERROR_STATE_MISMATCH:
            return false;
            break;
        case JSON_ERROR_CTRL_CHAR:
            return false;
            break;
        case JSON_ERROR_SYNTAX:
            return false;
            break;
        case JSON_ERROR_UTF8:
            return false;
            break;
        default:
            return false;
            break;
    }

}



/**
 * @function queryStringToArray
 * @description Function will convert query string into array
 *
 * @param string $queryString query string or array as input from calling function
 * @return array
 *
 * Ex :
 * queryString : "id=1&type=a"
 * result  : array("id"=>1, "type" => a)
 */
function queryStringToArray($queryString)
{

    if (is_array($queryString)) {
        return $queryString;
    }

    parse_str(trim($queryString), $temp);
    return $temp;

}



/**
 * @function encryptDecrypt
 * @description A common function to encrypt or decrypt desired string
 *
 * @param string $string String to Encrypt
 * @param string $type option encrypt or decrypt the string
 * @return type
 */
function encryptDecrypt($string, $type = 'encrypt')
{

    if ($type == 'decrypt') {
        #$enc_string = decrypt_with_openssl($string);
        $enc_string = base64decryption($string);
    }
    if ($type == 'encrypt') {
        #$enc_string = encrypt_with_openssl($string);
        $enc_string = base64encryption($string);
    }
    return $enc_string;

}



/**
 * @funciton base64encryption
 * @description will Encrypt data in base64
 *
 * @param type $string
 */
function base64encryption($string)
{
    return base64_encode($string);

}



/**
 * @funciton base64decryption
 * @description will decrypt data in base64
 *
 * @param type $string
 */
function base64decryption($string)
{
    return base64_decode($string);

}



/**
 * @function getRequertParams
 * @description to convert encrypted query string to array
 *
 * @param string $string
 * @return array Array of Requested parameters
 */
function getRequestParams($string)
{
    $response = [];
    if ( ! empty($string)) {

        $temp = encryptDecrypt($string, 'decrypt');

        // validate JSON
        if ( ! jsonValidation($temp)) {

            // Redirect to 404 if JSON string is tempared
            abort(404);
            return;
        }

        // JSON to Array Conversion
        $encQuery = json_decode($temp, true);

        foreach ($encQuery as $key => $value) {
            $response[$key] = $value;
        }
    }

    return $response;

}



// /**
//  *
//  * @param string $inputDateTime
//  * @return type
//  */
// function changeDateFormat($inputDateTime)
// {
//     $date = date_create($inputDateTime);
//     return date_format($date, DATE_FORMAT);

// }



/**
 * @function generate_filename
 * @description Function to get Filename
 *
 * @return string generating random string to upload file
 */
function generate_filename($file_name_in)
{
    $name = explode('.', $file_name_in);
    $ext  = array_pop($name);

    $file_name = uniqid() . time() . rand(10000, 99999) . '.' . $ext;
    return $file_name;

}



/**
 * Function to Show 500 pages on any Exception
 * If environment is local or staging, Actual error will be shown otherwise "Something went wrong"
 *
 * @param string $msg
 */




function sendIOSPush($deviceToken, $payload)
{
    if (env('USE_SNS')) {
        if (count($deviceToken) > 0) {
            foreach ($deviceToken as $token) {
                $temp[0] = $token;
                snsPush($temp, $payload);
            }
        }
        else {
            snsPush($deviceToken, $payload);
        }
    }
    else {
        sendPushfirebaseios($deviceToken, $payload);
    }

}



function sendAndroidPush($deviceToken, $payload)
{
    if (env('USE_SNS')) {
        if (count($deviceToken) > 0) {
            foreach ($deviceToken as $token) {
                $temp[0] = $token;
                snsAndroidPush($temp, $payload);
            }
        }
        else {
            snsAndroidPush($deviceToken, $payload);
        }
    }
    else {
        androidPush($deviceToken, $payload);
    }

}



/**
 *
 * @param type $deviceToken
 * @param type $payload
 */
function snsPush($deviceToken, $payload)
{
    try {
        $sns = App::make('aws')->createClient('sns');

        $endPointArn = array ("EndpointArn" => $deviceToken[0]);

        $endpointAtt = $sns->getEndpointAttributes($endPointArn);

        if ($endpointAtt != 'failed' && $endpointAtt['Attributes']['Enabled'] != 'false') {


//            $payload['attachment-url'] = 'https://www.w3schools.com/html/mov_bbb.mp4';
//            $payload['content_type']   = 'video';

            $payload['attachment-url'] = 'https://www.w3schools.com/html/mov_bbb.mp4';
            $payload['content_type']   = 'audio';

            $fcmPayload = json_encode(
                [
                    "aps" => $payload
                ]
            );

            $message    = json_encode(["default" => "", 'APNS_SANDBOX' => $fcmPayload]);
            $result     = $sns->publish([
                'TargetArn'        => $deviceToken[0],
                'Message'          => $message,
                'MessageStructure' => 'json'
            ]);
            return($result);
        }
    }
    catch (SnsException $e) {
        echo ($e->getMessage());
    }
    exit;

}



/**
 *
 * @param type $deviceToken
 * @param type $payload
 */
use Aws\Sns\Exception\SnsException;

function snsAndroidPush($deviceToken, $payload)
{
    try {
        $sns = App::make('aws')->createClient('sns');

        $endPointArn = array ("EndpointArn" => $deviceToken[0]);

        $endpointAtt = $sns->getEndpointAttributes($endPointArn);

        if ($endpointAtt != 'failed' && $endpointAtt['Attributes']['Enabled'] != 'false') {
            $fcmPayload = json_encode(
                [
                    "data" => $payload
                ]
            );
            $message    = json_encode(["default" => "", "GCM" => $fcmPayload]);

            $result = $sns->publish([
                'TargetArn'        => $deviceToken[0],
                'Message'          => $message,
                'MessageStructure' => 'json'
            ]);
            return($result);
        }
    }
    catch (SnsException $e) {
        echo ($e->getMessage());
    }
    exit;

}



/**
 * Send Android Push notification
 *
 * @param type $deviceToken
 * @param type $payload
 * @return type
 */
function androidPush($deviceToken, $payload)
{

    $deviceToken = is_array($deviceToken) ? $deviceToken : array ($deviceToken);

    $fields = ['registration_ids' => $deviceToken, 'data' => $payload];

    $pushKey = env('ANDROID_PUSH_KEY');

    $headers = ['Authorization: key=' . $pushKey, 'Content-Type: application/json'];

    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fcmUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;

}



/**
 * Send IOS Push notifications
 *
 * @param type $registrationIds
 * @param type $msg
 * @return type
 */
function sendPushfirebaseios($registrationIds, $msg)
{
    #dev key
    $key = env('ANDROID_PUSH_KEY');


    # payload data
    $fields = ['to' => json_encode($registrationIds), 'notification' => $msg];

    $headers = ['Authorization: key=' . $key, 'Content-Type: application/json'];

    #Send Reponse To FireBase Server
    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;

}



/**
 * Send Notification
 *
 * @param array $deviceTokens
 * @param array $payloadData
 * @param string $platform ios | Android
 */
function sendNotification(array $deviceTokens, array $payloadData, string $platform)
{
    $result = null;
    switch ($platform) {
        case 'android':
            $result = sendAndroidPush($deviceTokens, $payloadData);
            break;
        case 'ios':
            $result = sendPushfirebaseios($deviceTokens, $payloadData);
            break;
    }
    return $result;

}





function setCache($cacheId, $data)
{
    try {
        Redis::setex($cacheId . '.data', CACHE_TIME, $data);
    }
    catch (Exception $ex) {
        return false;
    }

}



function getCache($cacheId)
{
    try {
        return Redis::get($cacheId . '.data');
    }
    catch (Exception $ex) {
        return false;
    }

}



function deleteCache($cacheId)
{
    try {
        Redis::command('DEL', [$cacheId . '.data']);
    }
    catch (Exception $ex) {
        return false;
    }

}



function deleteHashKey($key)
{
    $hKeys = ['user_id', 'device_id', 'status', 'salt'];
    try {
        foreach ($hKeys as $hKey) {
            Redis::hdel($key, $hKey);
        }
    }
    catch (Exception $ex) {
        return false;
    }

}






