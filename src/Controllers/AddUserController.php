<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Entities\UserEntity;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddUserController extends Controller
{
    private $userModel;

    /**
     * AddUserController constructor.
     * @param $userModel
     */
    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $newUserData = $request->getParsedBody()['user'];

        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];

        try {
            $newUser = new UserEntity(
                $newUserData['firstname'] ?? '',
                $newUserData['surname'] ?? '',
                $newUserData['dateOfBirth'] ?? '',
                $newUserData['phoneNumber'] ?? '',
                $newUserData['email'] ?? '');

        } catch (\Throwable $e) {
            $responseData['message']= $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $existingUser = $this->userModel->checkUserExists($newUser->getEmail());

            if ($existingUser) {
                $responseData['message'] = 'User exists with the provided email';
                $responseData['data'] = ['user' => $existingUser];

                return $this->respondWithJson($response, $responseData, 400);
            }
            $query_success = $this->userModel->addUser($newUser);

            if ($query_success) {
                $responseData['success'] = true;
                $responseData['message'] = 'User successfully added.';

                return $this->respondWithJson($response, $responseData, 200);
            }
            $responseData['message'] = 'An error occurred, could not add user please try again.';

            return $this->respondWithJson($response, $responseData, 500);

        } catch (\Throwable $e) {
            $responseData['message']= 'Oops! Something went wrong. Please try again later.';

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}