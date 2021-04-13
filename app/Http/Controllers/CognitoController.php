<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Messaging\MessageCodes;
use App\Http\Requests\Cognito\ListUserPoolsRequest;
use App\Services\CognitoService;
use Illuminate\Http\JsonResponse;
use JsonException;
use Px\Framework\AWS\Cognito\Cognito;
use Px\Framework\Http\Responder\Response;

class CognitoController extends Controller
{
    protected Cognito $cognito;

    public function __construct(CognitoService $cognitoService)
    {
        $this->cognito = $cognitoService->getConnector();
    }

    /**
     * @param ListUserPoolsRequest $listUserPoolsRequest
     * @return JsonResponse
     * @throws JsonException
     */
    public function listUserPools(ListUserPoolsRequest $listUserPoolsRequest): JsonResponse
    {
        $userPools = $this->cognito->getClient()->listUserPools(
            [
                'MaxResults' => $listUserPoolsRequest->getMaxResults()
            ]
        );

        $data = [];

        foreach ($userPools->get('UserPools') as $userPool) {
            $data[] = $userPool;
        }

        $response = new Response();
        $response->setSuccess(true);
        $response->setHttpCode(Response::HTTP_OK);
        $response->setMessage(MessageCodes::RAW, [], 'First ' . $listUserPoolsRequest->getMaxResults() . ' user pools');
        $response->setContent(
            [
                'userpools' => $data
            ]
        );

        return $response->json();
    }
}
