<?php namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Marketplace Tcell Swagger API documentation example",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Server(
 *     description="MargetPlace Tcell Swagger API server",
 *     url=L5_SWAGGER_CONST_HOST,
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
 */

class Controller extends \App\Http\Controllers\Controller
{
    /**
     * @param null $data
     * @param string $message
     * @param array $headers
     * @return JsonResponse
     */
    public function respondWithError($data = null, $message = '', $headers = []): JsonResponse
    {
        $response = [
            'meta' => [
                'error' => true,
                'message' => $message,
                'statusCode' => $this->getStatusCode(),
            ],
            'data' => $data
        ];
        return response()->json($response, $this->getStatusCode(), $headers);
    }

    /**
     * @param string $message
     * @param array $data
     * @param array $headers
     * @return JsonResponse
     */
    public function respond($data = null, $message = '', $headers = []): JsonResponse
    {
        $response = [
            'meta' => [
                'error' => false,
                'message' => $message,
                'statusCode' => $this->getStatusCode(),
            ],
            'data' => $data
        ];

        return response()->json($response, $this->getStatusCode(), $headers);
    }

}
