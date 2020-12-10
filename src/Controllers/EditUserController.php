<?php

namespace App\Controllers;

use App\Abstracts\Controller;
use App\Entities\UserEntity;
use App\Interfaces\UserModelInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateUserController extends Controller
{
    private $userModel;

    /**
     * UpdateUserController constructor.
     * @param $userModel
     */
    public function __construct(UserModelInterface $userModel)
    {
        $this->userModel = $userModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $userData = $request->getParsedBody()['user'];

        $responseData = [
            'success' => false,
            'message' => '',
            'data' => []
        ];

        try {
            $user = new UserEntity(
                $args['email'] ?? '',
                $userData['firstname'] ?? '',
                $userData['surname'] ?? '',
                $userData['dateOfBirth'] ?? '',
                $userData['phoneNumber'] ?? ''
            );

        } catch(\Throwable $e) {
            $responseData['message'] = $e->getMessage();

            return $this->respondWithJson($response, $responseData, 400);
        }

        try {
            $userExists = $this->userModel->checkUserExists($user->getEmail());

            if($userExists && $userExists['deleted'] === "0") {
                $query_response = $this->userModel->updateUser($user);

                if($query_response) {
                    $responseData['success'] = true;
                    $responseData['message'] = 'User updated successfully.';

                    return $this->respondWithJson($response, $responseData, 200);
                }
                $responseData['message'] = 'Could not update user; please try again.';

                return $this->respondWithJson($response, $responseData, 500);
            }
            $responseData['message'] =
                'User does not exist in the database. Please add as a new user.';

            return $this->respondWithJson($response, $responseData, 400);

        } catch(\Throwable $e) {
            $responseData['message'] = 'Oops! Something went wrong; please try again later.';

            return $this->respondWithJson($response, $responseData, 500);
        }
    }
}