<?php

declare(strict_types=1);

namespace App\Sidebar;

use Shopper\Sidebar\AbstractAdminSidebar;
use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\Contracts\Builder\Menu;

final class BlogSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(__('Content'), function (Group $group): void {
            $group->weight(5);
            $group->setAuthorized();
            $group->collapsible();

            $group->item(__('Blog Posts'), function (Item $item): void {
                $item->weight(1);
                $item->useSpa();
                $item->route('shopper.blog.posts.index');
                $item->setIcon('phosphor-article');
            });

            $group->item(__('Blog Categories'), function (Item $item): void {
                $item->weight(2);
                $item->useSpa();
                $item->route('shopper.blog.categories.index');
                $item->setIcon('phosphor-tag');
            });
        });

        return $menu;
    }
}
