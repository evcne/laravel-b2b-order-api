<?php 

namespace App\Base;

use Illuminate\Http\JsonResponse;
use App\Helpers\Helper;


class BaseResponse
{

    private Helper $helper;

    /**
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function getResponse(string $code, bool $status, string $message, ?array $data, int $responseCode): JsonResponse
    {
        $process = [
            'code' => $code,
            'status' => $status,
            'response' => $data,
            'responseCode' => $responseCode,
            'responseTime' => new \DateTime()
        ];

        return new JsonResponse(
            [
                'code' => $code,
                'status' => $status,
                'message' => $message,
                'data' => $data
            ],
            $responseCode
        );
    }

    /**
     * Error response format.
     *
     * @param  string $message
     * @param  int $statusCode
     * @param  mixed $data
     * @return JsonResponse
     */
    public function error($message = "An error occurred", $statusCode = 400, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function createSuccessResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::C000,true,$this->helper::CREATE_SUCCESS_TEXT, $data, 201);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function createFailedResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::C001,false,$this->helper::CREATE_FAILED_TEXT, $data, 400);
    }

    /**
     * @param array|null $data
     * @param string $message
     * @return JsonResponse
     */
    public function createFailedMessageResponse(?array $data, string $message): JsonResponse
    {
        return $this->getResponse($this->helper::C002,false, $message, $data, 400);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function readSuccessResponse(?array $data): JsonResponse
    {
        $message = $this->getLangMessage($this->helper::READ_SUCCESS_TEXT);
        return $this->getResponse($this->helper::R000,true,$message, $data, 200);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function readFailedResponse(?array $data = null): JsonResponse
    {
        return $this->getResponse($this->helper::R001,false,$this->helper::READ_FAILED_TEXT, $data, 200);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function readFailedForUserAuthenticationResponse(?array $data = null): JsonResponse
    {
        return $this->getResponse($this->helper::ACTIVATION_NOT_FOUND_TEXT,false,$this->helper::READ_FAILED_TEXT, $data, 200);
    }

    /**
     * @param array|null $data
     * @param string $message
     * @return JsonResponse
     */
    public function readFailedMessageResponse(?array $data, string $message): JsonResponse
    {
        return $this->getResponse($this->helper::R002,false, $message, $data, 400);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function updateSuccessResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::U000,true,$this->helper::UPDATE_SUCCESS_TEXT, $data, 200);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function updateFailedResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::U001,false,$this->helper::UPDATE_FAILED_TEXT, $data, 400);
    }

    /**
     * @param array|null $data
     * @param string $message
     * @return JsonResponse
     */
    public function updateFailedMessageResponse(?array $data, string $message): JsonResponse
    {
        return $this->getResponse($this->helper::U002,false, $message, $data, 400);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function deleteSuccessResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::D000,true,$this->helper::DELETE_SUCCESS_TEXT, $data, 200);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function deleteFailedResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::D001,false,$this->helper::DELETE_FAILED_TEXT, $data, 400);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function userFailedResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::C001, false,$this->helper::USER_NOT_FOUND, $data, 400);
    }

    /**
     * @param array|null $data
     * @param string $message
     * @return JsonResponse
     */
    public function deleteFailedMessageResponse(?array $data, string $message): JsonResponse
    {
        return $this->getResponse($this->helper::D002,false, $message, $data, 400);
    }


    /**
     * @param array $validation
     * @return JsonResponse
     */
    public function validationFailedResponse(array $validation): JsonResponse
    {
        return $this->getResponse($this->helper::S003,false, $this->helper::VALIDATION_FAILED_TEXT, $validation, 400);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function authSuccessResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::A000,true,$this->helper::AUTH_SUCCESS_TEXT, $data, 200);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function authFailedResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::A001,false,$this->helper::AUTH_FAILED_TEXT, $data, 400);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function authLogoutSuccessResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::A000,true,$this->helper::AUTH_LOGOUT_SUCCESS_TEXT, $data, 200);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function authLogoutFailedResponse(?array $data): JsonResponse
    {
        return $this->getResponse($this->helper::A000,true,$this->helper::AUTH_LOGOUT_SUCCESS_TEXT, $data, 500);
    }
}