<?php

namespace Modules\Plantillas\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterPlantillasSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('plantillas::plantillas.title.plantillas'), function (Item $item) {
                $item->icon('fa fa-file-text-o');
                $item->weight(10);
                $item->append('admin.plantillas.plantilla.create');
                $item->route('admin.plantillas.plantilla.index');
                $item->authorize(
                     $this->auth->hasAccess('plantillas.plantillas.index')
                );
            });
        });

        return $menu;
    }
}
