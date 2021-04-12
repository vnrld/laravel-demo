<?php

declare(strict_types=1);

namespace App\Http\Controllers;


use App\Contracts\UserRepositoryContract;
use App\Exceptions\User\NotFoundException;
use App\Http\Messaging\MessageCodes;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\ReadUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;
use Px\Framework\Http\Responder\Response;

class UsersController extends Controller
{
    private UserRepositoryContract $userRepository;

    private LoggerInterface $logger;

    public function __construct(UserRepositoryContract $userRepository, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    public function createUser(CreateUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $response = new Response();

        try {
            $user = $this->userRepository->create(new User($data));
            $response->setMessage(MessageCodes::USER_CREATED, [$user->id]);
        } catch (QueryException $queryException) {
            $this->logger->error('Cannot create a new user: ' . $queryException->getMessage(), [__METHOD__]);
            $response->setCode(Response::HTTP_CONFLICT);
            $response->setMessage(MessageCodes::USER_ALREADY_EXISTS, [$request->getEmail()]);

            // $user = null;

            $user = $this->userRepository->findByEmail($request->getEmail());
        }

        $response->setContent($user);

        return $response->json();
    }

    public function readUser(ReadUserRequest $request): JsonResponse
    {
        $userId = $request->getId();

        $user = $this->userRepository->read($userId);

        $response = new Response();
        $response->setSuccess(true);

        if ($user instanceof User) {
            $response->setCode(Response::HTTP_OK);
        } else {
            $response->setCode(Response::HTTP_NOT_FOUND);
            $response->setMessage(MessageCodes::USER_NOT_FOUND, [$userId]);
        }

        $response->setContent($user);
        return $response->json();
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $response = new Response();

        $user = null;

        try {
            $user = $this->userRepository->update(new User($data));
        } catch (QueryException $queryException) {
            $this->logger->error(
                'Cannot update the user: ' . $request->getId() . ' : ' . $queryException->getMessage(),
                [__METHOD__]
            );
            $response->setSuccess(false);
            $response->setCode(Response::HTTP_CONFLICT);
            $response->setMessage(MessageCodes::USER_ALREADY_EXISTS, [$request->getEmail()]);
        } catch (NotFoundException $notFoundException) {
            $this->logger->warning(
                'Cannot update the user: ' . $request->getId() . ' : ' . $notFoundException->getMessage(),
                [__METHOD__]
            );
            $response->setSuccess(false);
            $response->setCode(Response::HTTP_NOT_FOUND);
            $response->setMessage(MessageCodes::USER_NOT_FOUND, [$request->getId()]);
        }

        $response->setContent($user);
        return $response->json();
    }

    public function deleteUser(DeleteUserRequest $request): JsonResponse
    {
        $userId = $request->getId();

        $response = new Response();

        try {
            $isDeleted = $this->userRepository->delete($userId);
            $response->setMessage(MessageCodes::USER_DELETED, [$userId]);
        } catch (NotFoundException $notFoundException) {
            $isDeleted = false;
            $response->setMessage(MessageCodes::USER_NOT_FOUND, [$userId]);
        }

        $response->setSuccess($isDeleted);
        $response->setContent(['deleted' => $isDeleted]);

    }
}
