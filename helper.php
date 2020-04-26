<?php

function json($code, $msg, $data = null)
{
    return json_encode(['code' => $code, 'data' => $data, 'msg' => $msg]);
}