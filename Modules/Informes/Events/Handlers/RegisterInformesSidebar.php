<?php

namespace Modules\Informes\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterInformesSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
          $group->item(trans('Informes'), function (Item $item) {
              $item->icon('fa fa-line-chart');
              $item->weight(11);
              $item->route('admin.informes.informe.index');
              $item->authorize(
                 $this->auth->hasAccess('informes.informes.index')
              );
// append
          });
      });

        return $menu;
    }
}
