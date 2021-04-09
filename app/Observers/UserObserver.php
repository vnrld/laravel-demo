<?php
declare(strict_types=1);

namespace App\Observers;

use App\Contracts\UserHistoryRepositoryContract;
use App\Models\UserHistory;
use DateTime;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use PDOException;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class UserObserver
 * @package App\Observers
 */
class UserObserver
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var UserHistoryRepositoryContract
     */
    private UserHistoryRepositoryContract $userHistoryRepository;

    /**
     * @var DateTime
     */
    private DateTime $dateTime;

    /**
     * @var ConnectionInterface
     */
    private ConnectionInterface $db;


    /**
     * UserObserver constructor.
     * @param LoggerInterface $logger
     * @param UserHistoryRepositoryContract $userHistoryRepository
     * @param DateTime $dateTime
     * @param ConnectionInterface $db
     */
    public function __construct(
        LoggerInterface $logger,
        UserHistoryRepositoryContract $userHistoryRepository,
        DateTime $dateTime,
        ConnectionInterface $db
    ) {
        $this->logger = $logger;
        $this->userHistoryRepository = $userHistoryRepository;
        $this->dateTime = $dateTime;
        $this->db = $db;
    }

    /**
     * @param Model $model
     */
    public function creating(Model $model): void
    {
        $uuid = Uuid::uuid4()->toString();

        $this->logger->info('Creating new user\'s model with id: ' . $uuid, [__METHOD__, $uuid]);

        $model->id = $uuid;

        // Example
        $model->email_verified_at = $this->dateTime->getTimestamp();
    }

    /**
     * @param Model $model
     */
    public function created(Model $model): void
    {
        $this->db->beginTransaction();

        $uuid = $model->id;

        try {
            $message = 'Created new user with id: ' . $uuid;

            $this->logger->info($message, [__METHOD__, $uuid]);
            $this->addHistoryEntry(Uuid::uuid4()->toString(), $uuid, $message);
            $this->db->commit();
        } catch (PDOException | QueryException $exception) {
            $this->db->rollBack();
            $this->logger->warning(
                'Cannot create a history entry for the user: ' . $uuid . ': ' . $exception->getMessage(),
                [__METHOD__, $uuid]
            );
        }
    }

    public function updated(Model $model): void
    {
        $this->db->beginTransaction();

        $uuid = $model->id;

        try {
            $message = 'Updated user with id: ' . $uuid;

            $this->logger->info($message, [__METHOD__, $uuid]);
            $this->addHistoryEntry(Uuid::uuid4()->toString(), $uuid, $message);
            $this->db->commit();
        } catch (PDOException | QueryException $exception) {
            $this->db->rollBack();
            $this->logger->warning(
                'Cannot create a history entry for the user: ' . $uuid . ': ' . $exception->getMessage(),
                [__METHOD__, $uuid]
            );
        }
    }

    public function deleted(Model $model): void
    {
        $this->db->beginTransaction();

        $uuid = $model->id;

        try {
            $message = 'Deleted user with id: ' . $uuid;

            $this->logger->info($message, [__METHOD__, $uuid]);
            $this->addHistoryEntry(Uuid::uuid4()->toString(), $uuid, $message);
            $this->db->commit();
        } catch (PDOException | QueryException $exception) {
            $this->db->rollBack();
            $this->logger->warning(
                'Cannot create a history entry for the user: ' . $uuid . ': ' . $exception->getMessage(),
                [__METHOD__, $uuid]
            );
        }
    }

    private function addHistoryEntry(string $id, string $userId, string $entry): void
    {
        $this->userHistoryRepository->create(
            new UserHistory(['id' => $id, 'user_id' => $userId, 'entry' => $entry])
        );
    }

}
