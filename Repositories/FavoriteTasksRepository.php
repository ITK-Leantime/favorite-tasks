<?php

namespace Leantime\Plugins\FavoriteTasks\Repositories;

use Illuminate\Database\Query\Builder;

/**
 * Favorite tasks repository class.
 */
class FavoriteTasksRepository
{
    /**
     * Returns a query builder bound to the default database connection.
     *
     * @return Builder Returns an instance of the query builder.
     */
    private function query(): Builder
    {
        return app('db')->connection()->query();
    }

    /**
     * Setup tables on install.
     *
     * @return void
     */
    public function setupTables(): void
    {
        app('db')->connection()->statement(<<<SQL
            CREATE TABLE `zp_favorite_tasks` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `issueId` int(11) DEFAULT NULL,
                `userId` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY zp_favorite_tasks_issueId_index (`issueId`),
                KEY zp_favorite_tasks_userId_index (`userId`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL);
    }

    /**
     * Remove tables on uninstall.
     *
     * @return void
     */
    public function removeTables(): void
    {
        app('db')->connection()->statement('DROP TABLE `zp_favorite_tasks`;');
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
        $this->query()
            ->from('zp_favorite_tasks')
            ->insert([
                'issueId' => $issueId,
                'userId' => $userId,
            ]);
    }

    /**
     * Get a user's favorite rows for a given issue.
     *
     * @param int $issueId
     * @param int $userId
     *
     * @return array<int, array<string, mixed>>
     */
    public function getUserFavorite(int $issueId, int $userId): array
    {
        return $this->query()
            ->from('zp_favorite_tasks')
            ->where('issueId', '=', $issueId)
            ->where('userId', '=', $userId)
            ->get()
            ->map(fn ($row) => (array) $row)
            ->all();
    }

    /**
     * Get all favorites by user.
     *
     * @param int $userId
     *
     * @return array<int, array<string, mixed>>
     */
    public function getUserFavorites(int $userId): array
    {
        return $this->query()
            ->from('zp_favorite_tasks')
            ->where('userId', '=', $userId)
            ->get()
            ->map(fn ($row) => (array) $row)
            ->all();
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
        $this->query()
            ->from('zp_favorite_tasks')
            ->where('id', '=', $id)
            ->delete();
    }
}
