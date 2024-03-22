<?php

namespace Leantime\Plugins\FavoriteTasks\Hxcontrollers;

use Leantime\Plugins\FavoriteTasks\Services\FavoriteTasks as FavoriteTasksService;
use Symfony\Component\HttpFoundation\Response;
use Leantime\Core\Controller;
use Leantime\Plugins\FavoriteTasks\Repositories\FavoriteTasksRepository;

/**
 * Change favorites controller.
 */
final class ChangeFavorite extends Controller
{
  /**
   * @var \Leantime\Plugins\FavoriteTasks\Repositories\FavoriteTasksRepository
   */
    private FavoriteTasksRepository $favoriteTasksRepository;

  /**
   * Controller constructor
   *
   * @return void
   */
    public function init(
        FavoriteTasksRepository $favoriteTasksRepository,
    ) {
        $this->favoriteTasksRepository = $favoriteTasksRepository;
    }

  /**
   * Change favorite status on issue.
   *
   * POST: /favoritetasks/changefavorite
   *
   * @see \Leantime\Core\Frontcontroller::executeAction().
   *
   * @param array $payload
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
    public function post(array $payload): Response
    {
        $isFavorite = false;
        $favorites = $this->favoriteTasksRepository->getUserFavorite($payload['id'], $_SESSION['userdata']['id']);

        if (!empty($favorites)) {
            foreach ($favorites as $favorite) {
                $this->favoriteTasksRepository->deleteFavorite($favorite['id']);
            }
        } else {
            $this->favoriteTasksRepository->addFavorite($payload['id'], $_SESSION['userdata']['id']);
            $isFavorite = true;
        }

        $label = $isFavorite ? 'Remove from favorites' : 'Add to favorites';
        $favoriteIcon = $isFavorite ? '<i class="fa-solid fa-star tw-mr-sm"></i>' : '<i class="fa-regular fa-star tw-mr-sm"></i>';

        return new Response('<button hx-post="/favorite_tasks/changefavorite" hx-swap="outerHTML" class="buttons-html5 dt-button">' . $favoriteIcon . $label . '</button><hr>');
    }
}
