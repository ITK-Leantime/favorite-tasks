<?php

namespace Leantime\Plugins\FavoriteTasks\Services;

use Leantime\Domain\Tickets\Repositories\Tickets;
use Leantime\Plugins\FavoriteTasks\Repositories\FavoriteTasksRepository;

/**
 * Favorite tasks service
 */
class FavoriteTasks
{
  /**
   * Constructor for favorite tasks service.
   *
   * @param \Leantime\Plugins\FavoriteTasks\Repositories\FavoriteTasksRepository $favoriteTasksRepository
   * @param \Leantime\Domain\Tickets\Repositories\Tickets                        $ticketRepository
   */
    public function __construct(
        private readonly FavoriteTasksRepository $favoriteTasksRepository,
        private readonly Tickets $ticketRepository
    ) {
        session(['lastPage' => BASE_URL . '/dashboard/home']);
    }

  /**
   * Setup relation table.
   *
   * @return void
   */
    public function install(): void
    {
        $this->favoriteTasksRepository->setupTables();
    }

  /**
   * Remove relation table.
   *
   * @return void
   */
    public function uninstall(): void
    {
        $this->favoriteTasksRepository->removeTables();
    }

  /**
   * @return \Closure|mixed|object|null
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
    public function getFavoriteTasksWidget()
    {
        return app()->make('Leantime\Domain\Widgets\Models\Widget', [
          'id' => 'favoriteTasks',
          'name' => 'Favorite tasks',
          'description' => 'Dashboard for displaying your favorite tasks ',
          'widgetUrl' => BASE_URL . '/favoriteTasks/favoriteTasks/get',
          'gridHeight' => 15,
          'gridWidth' => 4,
          'gridMinHeight' => 0,
          'gridMinWidth' => 4,
          'gridX' => 8,
          'gridY' => 41,
          'alwaysVisible' => false,
          'noTitle' => false,
        ]);
    }

  /**
   * @return array
   */
    public function getUserFavouriteIssues(): array
    {
        $userFavorites = $this->favoriteTasksRepository->getUserFavorites(session('userdata.id'));
        $favorites = [];

        foreach ($userFavorites as $favorite) {
            $favorites[] = $this->ticketRepository->getTicket($favorite['issueId']);
        }

        return $favorites;
    }

  /**
   * @param array $payload
   *
   * @return string
   */
    public function getFavoriteTaskSubscribeHtml(array $payload): string
    {
        $isFavorite = !empty($this->favoriteTasksRepository->getUserFavorite($payload['ticketId'], session('userdata.id')));
        $label = $isFavorite ? 'Remove from favorites' : 'Add to favorites';
        $favoriteClass = $isFavorite ? 'button-favorites-remove' : 'button-favorites-add';
        $favoriteIcon = $isFavorite ? '<i class="fa-solid fa-star tw-mr-sm"></i>' : '<i class="fa-regular fa-star tw-mr-sm"></i>';

        return '<div class="' . $favoriteClass . '"><button hx-post="/favorite_tasks/change_favorite" hx-swap="outerHTML" class="buttons-html5 dt-button">' . $favoriteIcon . $label . '</button></div><hr>';
    }
}
