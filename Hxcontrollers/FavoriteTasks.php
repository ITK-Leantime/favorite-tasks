<?php

namespace Leantime\Plugins\FavoriteTasks\Hxcontrollers;

use Leantime\Core\Controller\HtmxController;
use Leantime\Plugins\FavoriteTasks\Services\FavoriteTasks as FavoriteTasksService;
use Leantime\Core\Language;

/**
 *  A controller for displaying a template with favorite tasks.
 */
class FavoriteTasks extends HtmxController
{
  /**
   * @var string
   */
    protected static string $view = 'favoritetasks::partials.favoritetaskswidget';

  /**
   * @var \Leantime\Plugins\FavoriteTasks\Services\FavoriteTasks
   */
    private FavoriteTasksService $favoriteTasksService;

  /**
   * Controller constructor
   *
   * @return void
   */
    public function init(
        FavoriteTasksService $favoriteTasksService
    ) {
        $this->favoriteTasksService = $favoriteTasksService;
        session(["lastPage" => BASE_URL . "/dashboard/home"]);
    }

  /**
   * Get method for the template variables
   *
   * @return void
   */
    public function get()
    {
        $tplVars = [
          'tickets' => $this->favoriteTasksService->getUserFavouriteIssues(),
        ];

        $this->tpl->assign('tickets', $tplVars['tickets']);
    }
}
