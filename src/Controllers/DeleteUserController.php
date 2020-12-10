<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Validators\EmailValidator;
use App\Interfaces\UserModelInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeleteUserController extends Controller
{
    private $userModel;

    /**
     * DeleteUserController constructor.
     */
    public function __construct(UserModelInterface $userModel)
    {
        $this->userModel = $userModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $email = $args['email'];

        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];

        try {
            $email = EmailValidator::validateEmail($sku);

        } catch (\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $exists = $this->userModel->checkUserExists($email);

            if ($exists) {
                $deleteUser = $this->userModel->deleteUserByEmail($email);

                if ($deleteUser){
                    $responseData['success'] = true;
                    $responseData['message'] =
                        "User successfully deleted";

                    return $this->respondWithJson($response, $responseData, 200);

                } else {
                    $responseData['message'] =
                        "User couldn't be deleted at this time, please try again";

                    return $this->respondWithJson($response, $responseData, 500);
                }
            }

            $responseData['message'] =
                "User doesn't exist, therefore couldn't be deleted, please try again";

            return $this->respondWithJson($response, $responseData, 400);

        } catch(\Throwable $e) {
            $responseData['message'] =
                "Something went wrong, please try again later";

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}