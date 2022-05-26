<?php namespace App\Http\Controllers\API;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $statusCode = 200;
    protected $message = '';
    protected $error = false;
    protected $debugInfo = [];
    protected $errorCode = 0;

    /**
     * Function to return an error response.
     *
     * @param $message
     * @return mixed
     */
    public function respondWithError($message)
    {
        $this->error = true;
        $this->message = $message;
        return $this->respond([]);
    }

    /**
     * Function to return an unauthorized response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondUnauthorizedError($message = 'Unauthorized!')
    {
        $this->statusCode = Response::HTTP_UNAUTHORIZED;
        return $this->respondWithError($message);
    }


    /**
     * Function to return a bad request response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondBadRequestError($message = 'Bad Request!')
    {
        $this->statusCode = Response::HTTP_BAD_REQUEST;
        return $this->respondWithError($message);
    }

    /**
     * Function to return forbidden error response.
     *
     * @param string $message
     *
     * @return mixed
     */
    public function respondForbiddenError($message = 'Forbidden!')
    {
        $this->statusCode = Response::HTTP_FORBIDDEN;
        return $this->respondWithError($message);
    }

    /**
     * Function to return a Not Found response.
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Resource Not Found')
    {
        $this->statusCode = Response::HTTP_NOT_FOUND;
        return $this->respondWithError($message);
    }

    /**
     * Function to return a created response
     *
     * @param $data array The data to be included
     *
     * @return mixed
     *
     */
    public function respondCreated($data)
    {
        $this->statusCode = Response::HTTP_CREATED;
        return $this->respond($data);
    }

    /**
     * Function to return a response with a message
     *
     * @param $data array The data to be included
     *
     * @param $message string The message to be shown in the meta of the response
     *
     * @return mixed
     */
    public function respondWithMessage($data, $message)
    {
        $this->statusCode = Response::HTTP_OK;
        $this->message = $message;
        return $this->respond($data);
    }

    /**
     * Function to return a generic response.
     *
     * @param $data array to be used in response.
     * @param array $headers Headers to b used in response.
     * @return mixed Return the response.
     */
    public function respond($data = [], $headers = [])
    {
        $meta = [
            'meta' => [
                'error' => $this->error,
                'message' => $this->message,
                'statusCode' => $this->statusCode,
            ]
        ];
        if (empty($data) && !is_array($data)) {
            $data = array_merge($meta, ['response' => null]);
        } else {
            $data = array_merge($meta, ['response' => $data]);
        }

        if (!empty($this->debugInfo)) {
            $data = array_merge($data, ['debug' => $this->debugInfo]);
        }

        return response()->json($data, $this->statusCode, $headers);
    }

    public function successJson($message = '', $data = null) {
        return response()->json([
            'error' => false,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function errorJson($message, $data = null) {
        return response()->json([
            'error' => true,
            'message' => $message,
            'data' => $data
        ]);
    }
}
