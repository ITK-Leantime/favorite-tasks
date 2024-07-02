<?php

namespace Leantime\Plugins\FavoriteTasks\Repositories;

use Leantime\Core\Db as DbCore;
use PDO;

/**
 * Ticket template repository class.
 */
class FavoriteTasksRepository
{
  /**
   * Constructor.
   *
   * @param DbCore $db
   */
    public function __construct(private readonly DbCore $db)
    {
    }

  /**
   * Setup tables on install.
   *
   * @return void
   */
    public function setupTables(): void
    {
        $query = <<<SQL
            CREATE TABLE `zp_favorite_tasks` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `issueId` int(11) DEFAULT NULL,
                `userId` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY zp_favorite_tasks_issueId_index (`issueId`),
                KEY zp_favorite_tasks_userId_index (`userId`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;

        $stmn = $this->db->database->prepare($query);
        $stmn->execute();
        $stmn->closeCursor();
    }

  /**
   * Remove tables on uninstall.
   *
   * @return void
   */
    public function removeTables(): void
    {
        $query = <<<SQL
            DROP TABLE `zp_favorite_tasks`;
        SQL;

        $stmn = $this->db->database->prepare($query);
        $stmn->execute();
        $stmn->closeCursor();
    }

  /**
   * Add to favorites.
   *
   * @param string $issueId
   * @param string $userId
   *
   * @return void
   */
    public function addFavorite(string $issueId, string $userId): void
    {
        $sql = <<<SQL
            INSERT INTO zp_favorite_tasks (
                issueId,
                userId
            ) VALUES (
            	:issueId,
            	:userId
            );
        SQL;

        $stmn = $this->db->database->prepare($sql);

        $stmn->bindValue(':issueId', $issueId);
        $stmn->bindValue(':userId', $userId);

        $stmn->execute();
        $stmn->closeCursor();
    }

  /**
   * Get a favorite issue by user and issue id.
   *
   * @param int $issueId
   * @param int $userId
   *
   * @return array|false
   */
    public function getUserFavorite(int $issueId, int $userId)
    {
        $sql = <<<SQL
            SELECT
                *
            FROM zp_favorite_tasks
            WHERE
                issueId = :issueId
            AND
                userId = :userId;
        SQL;

        $stmn = $this->db->database->prepare($sql);

        $stmn->bindValue(':issueId', $issueId);
        $stmn->bindValue(':userId', $userId);
        $stmn->execute();
        $values = $stmn->fetchAll();
        $stmn->closeCursor();

        return $values;
    }

  /**
   * Get all favorites by user.
   *
   * @param int $userId
   *
   * @return bool|array
   */
    public function getUserFavorites(int $userId): bool|array
    {
        $sql = <<<SQL
            SELECT
                *
            FROM zp_favorite_tasks
            WHERE
                userId = :userId;
        SQL;

        $stmn = $this->db->database->prepare($sql);

        $stmn->bindValue(':userId', $userId);
        $stmn->execute();
        $values = $stmn->fetchAll();
        $stmn->closeCursor();

        return $values;
    }

  /**
   * Delete a favorite by favorite id.
   *
   * @param string $id
   *
   * @return void
   */
    public function deleteFavorite(string $id): void
    {
      // Remove relations with template id
        $sql = <<<SQL
            DELETE FROM
                zp_favorite_tasks
            WHERE
                id = :id;
        SQL;

        $stmn = $this->db->database->prepare($sql);

        $stmn->bindValue(':id', $id);

        $stmn->execute();
        $stmn->closeCursor();
    }
}
