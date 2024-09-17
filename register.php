<?php

use Leantime\Core\Events\EventDispatcher;
use Leantime\Domain\Widgets\Models\Widget;
use Leantime\Plugins\FavoriteTasks\Services\FavoriteTasks;

EventDispatcher::add_filter_listener(
    'leantime.domain.widgets.services.widgets.__construct.availableWidgets',
    'defineFavoriteTasksWidget'
);

EventDispatcher::add_filter_listener(
    'leantime.domain.widgets.services.widgets.__construct.defaultWidgets',
    'addFavoriteTasksWidgetAsDefault'
);

EventDispatcher::add_event_listener(
// Register event listener.
    'leantime.core.template.tpl.*.beforeSubtasks',
    function ($payload) {
        echo app()->make(FavoriteTasks::class)->getFavoriteTaskSubscribeHtml($payload);
    },
    50
);

/**
 * Define the favorite tasks widget.
 *
 * @param array<string, mixed> $availableWidgets
 *
 * @return array<string, mixed>
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
 * @param array<string, mixed> $defaultWidgets
 *
 * @return array<string, mixed>
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 */
function addFavoriteTasksWidgetAsDefault(array $defaultWidgets): array
{
    $defaultWidgets['favoriteTasks'] = app()->make(FavoriteTasks::class)->getFavoriteTasksWidget();

    return $defaultWidgets;
}
