<?php

namespace Code\Core\Traits;


trait JsonResponseTrait
{
    public function jsonResponse($status, $data, $error = false, $message = null){
        return response()->json(compact('status', 'data', 'error', 'message'), $status);
    }
}