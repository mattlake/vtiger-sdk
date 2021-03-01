<?php

use Trunk\VtigerSDK\Http\Models\VtigerEntityModel;
use Trunk\VtigerSDK\Http\ResponseHandler;
use Trunk\VtigerSDK\Http\VtigerResponse;

it(
    'returns a VtigerResponse by default with successful API call',
    function () {
        $response = [
            'success' => true,
            'result' => [
                'test' => 'pass',
                'score' => 100
            ]
        ];

        expect(ResponseHandler::handle('blabla', $response))->toBeInstanceOf(VtigerResponse::class);
    }
);

it(
    'returns a VtigerResponse by default with unsuccessful API call',
    function () {
        $response = [
            'success' => false,
            'error' => [
                'code' => 'TEST_ERROR',
                'message' => 'There was an error'
            ]
        ];

        expect(ResponseHandler::handle('blabla', $response))->toBeInstanceOf(VtigerResponse::class);
    }
);

it(
    'returns a VtigerResponse when requested with successful API call',
    function () {
        $response = [
            'success' => true,
            'result' => [
                'test' => 'pass',
                'score' => 100
            ]
        ];

        expect(ResponseHandler::handle(VtigerResponse::class, $response))->toBeInstanceOf(VtigerResponse::class);
    }
);

it(
    'returns a VtigerResponse when requested with unsuccessful API call',
    function () {
        $response = [
            'success' => false,
            'error' => [
                'code' => 'TEST_ERROR',
                'message' => 'There was an error'
            ]
        ];

        expect(ResponseHandler::handle(VtigerResponse::class, $response))->toBeInstanceOf(VtigerResponse::class);
    }
);

it(
    'returns a VtigerEntityModel when requested with successful API call',
    function () {
        $response = [
            'success' => true,
            'result' => [
                'test' => 'pass',
                'score' => 100
            ]
        ];

        expect(ResponseHandler::handle(VtigerEntityModel::class, $response))->toBeInstanceOf(VtigerEntityModel::class);
    }
);

it(
    'returns a VtigerResponse when other model is requested with unsuccessful API call',
    function () {
        $response = [
            'success' => false,
            'error' => [
                'code' => 'TEST_ERROR',
                'message' => 'There was an error'
            ]
        ];

        expect(ResponseHandler::handle(VtigerEntityModel::class, $response))->toBeInstanceOf(VtigerResponse::class);
    }
);
