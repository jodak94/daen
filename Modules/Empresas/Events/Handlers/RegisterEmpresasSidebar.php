<?php

namespace Modules\Empresas\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterEmpresasSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('empresas::empresas.title.empresas'), function (Item $item) {
                $item->icon('fa fa-industry');
                $item->weight(10);
                $item->route('admin.empresas.empresa.index');
                $item->append('admin.empresas.empresa.create');
                $item->authorize(
                    $this->auth->hasAccess('empresas.empresas.index')
                );
            });
        });

        return $menu;
    }
}
