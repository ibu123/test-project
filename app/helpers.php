<?php
if (!function_exists('sendError')) {
    function sendError($code = 500, $error = [])
    {


        if (!empty($exceptionMsg)) {
            \Log::error($exceptionMsg);
        }

        $response = [
            'success' => false,
            'message' => (empty($error) ? __('general.error_message') : $error),
            'code' => $code
        ];

        return response()->json($response, $code);

    }
}

if (!function_exists('sendResponse')) {
    function sendResponse($result, $message = "")
    {

        $data = [
            'success' => true,
            'data'    => $result,
            'message' => (empty($message) ? __('general.success') : $message),
        ];

        return response()->json($data, 200);

    }
}
