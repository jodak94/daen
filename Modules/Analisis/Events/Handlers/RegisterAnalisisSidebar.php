<?php

namespace Modules\Analisis\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterAnalisisSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
          $group->item(trans('Resultados'), function (Item $item) {
              $item->icon('fa fa-flask');
              $item->weight(1);
              $item->append('admin.analisis.analisis.create');
              $item->route('admin.analisis.analisis.index');
              $item->authorize(
                   /* append */
              );
          });
        });

        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('Configuraciones'), function (Item $item) {
                $item->icon('fa fa-cog');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('analisis::seccions.title.seccions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.analisis.seccion.create');
                    $item->route('admin.analisis.seccion.index');
                    $item->authorize(
                        $this->auth->hasAccess('analisis.seccions.index')
                    );
                });
                $item->item(trans('analisis::subseccions.title.subseccions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.analisis.subseccion.create');
                    $item->route('admin.analisis.subseccion.index');
                    $item->authorize(
                        $this->auth->hasAccess('analisis.subseccions.index')
                    );
                });
                $item->item(trans('Determinaciones'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.analisis.determinacion.create');
                    $item->route('admin.analisis.determinacion.index');
                    $item->authorize(
                        $this->auth->hasAccess('analisis.determinacions.index')
                    );
                });
            });
        });

        return $menu;
    }
}
