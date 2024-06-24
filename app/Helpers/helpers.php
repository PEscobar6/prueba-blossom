<?php

function jsonResponse($data = [], $message = '', $status = 200, $errors = [])
{
    return response()->json(compact('message', 'data', 'status', 'errors'), $status);
}
