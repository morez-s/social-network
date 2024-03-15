<?php

if (! function_exists('prepareSuccessfulResponse')) {
    function prepareSuccessfulResponse($message, $data = null, $pagination = null, $status_code = 200)
    {
        return response()->json([
            'successful' => true,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data,
            'pagination' => $pagination,
        ]);
    }
}

if (! function_exists('prepareUnsuccessfulResponse')) {
    function prepareUnsuccessfulResponse($message, $status_code, $data = null)
    {
        return response()->json([
            'successful' => false,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }
}
