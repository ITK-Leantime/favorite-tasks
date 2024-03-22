<?php

use Leantime\Core\Events;
use Leantime\Domain\Widgets\Models\Widget;
use Leantime\Plugins\FavoriteTasks\Services\FavoriteTasks;

Events::add_filter_listener(
    'leantime.domain.widgets.services.widgets.__construct.availableWidgets',
    'defineFavoriteTasksWidget'
);

Events::add_filter_listener(
    'leantime.domain.widgets.services.widgets.__construct.defaultWidgets',
    'addFavoriteTasksWidgetAsDefault'
);

Events::add_event_listener(
    'leantime.core.template.tpl.*.afterScriptLibTags',
    function () {
        echo '<script src="/dist/js/plugin-FavoriteTasks.js"></script>';
    }
);

Events::add_event_listener(
// Register event listener.
    'leantime.core.template.tpl.*.beforeSubtasks',
    // Create function for the event.
    function ($payload) {
        echo app()->make(FavoriteTasks::class)->getFavoriteTaskSubscribeHtml($payload);
    },
    // Priority
    50
);

/**
 * Define the favorite tasks widget.
 *
 * @param array $availableWidgets
 *
 * @return mixed
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 */
function defineFavoriteTasksWidget(array $availableWidgets): array
{
    $availableWidgets['favoriteTasks'] = app()->make(FavoriteTasks::class)->getFavoriteTasksWidget();

    return $availableWidgets;
}

/**
 * Add the widget to default widgets.
 *
 * @param array $defaultWidgets
 *
 * @return mixed
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 */
function addFavoriteTasksWidgetAsDefault(array $defaultWidgets): array
{
    $defaultWidgets['favoriteTasks'] = app()->make(FavoriteTasks::class)->getFavoriteTasksWidget();

    return $defaultWidgets;
}
