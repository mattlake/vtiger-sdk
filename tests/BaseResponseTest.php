<?php

it('can be constructed from successful response', function(){
    $response = [
        'success' => true,
        'result' => [
            'test' => 'pass',
            'score' => 100
        ]
    ];

    $testResponse = new \Trunk\VtigerSDK\Http\BaseResponse($response);
    expect($testResponse)->toBeInstanceOf(\Trunk\VtigerSDK\Http\BaseResponse::class);
    expect($testResponse->responseArray)->toBeArray();
    expect($testResponse->success)->toBeTrue();
    expect($testResponse->errorCode)->toBeNull();
    expect($testResponse->errorMessage)->toBeNull();
});

it('can be constructed from unsuccessful response', function(){
    $response = [
        'success' => false,
        'error' => [
            'code' => 'TEST_ERROR',
            'message' => 'There was an error'
        ]
    ];

    $testResponse = new \Trunk\VtigerSDK\Http\BaseResponse($response);
    expect($testResponse)->toBeInstanceOf(\Trunk\VtigerSDK\Http\BaseResponse::class);
    expect($testResponse->responseArray)->toBeArray();
    expect($testResponse->success)->toBeFalse();
    expect($testResponse->errorCode)->toBe('TEST_ERROR');
    expect($testResponse->errorMessage)->toBe('There was an error');
});