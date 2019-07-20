<?php

namespace Modules\Pacientes\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterPacientesSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('Pacientes'), function (Item $item) {
                $item->icon('fa fa-users');
                $item->route('admin.pacientes.paciente.index');
                $item->append('admin.pacientes.paciente.create');
                $item->route('admin.pacientes.paciente.index');
                $item->weight(3);
                $item->authorize(
                  $this->auth->hasAccess('pacientes.pacientes.index')
                );
            });
        });

        return $menu;
    }
}
