<?php

namespace Modules\Analisis\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Analisis\Entities\Analisis;
use Modules\Analisis\Entities\Seccion;
use Modules\Analisis\Entities\Subseccion;
use Modules\Analisis\Entities\Resultado;
use Modules\Analisis\Entities\Determinacion;
use DB;
use Log;
class AnalisisDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        DB::beginTransaction();

        $secciones = [
          'Química' => [
            'Química' => [
              'Glicemia' => [
                'mg/dl',
                '70-110',
                'rango'
              ],
            ],
            'Perfil Lipidico' => [
              'Colesterol Total' => [
                'mg/dl',
                '0-200',
                'rango'
              ],
              'Trigliceridos' => [
                'mg/dl',
                '0-150',
                'rango'
              ],
            ],
            'Perfil Renal' => [
              'Urea' => [
                'mg/dl',
                '15-50',
                'rango'
              ],
              'Creatinina' => [
                'mg/dl',
                '0.7-1.4',
                'rango'
              ],
              'Acido Urico' => [
                'mg/dl',
                'Fem 2.5 - 6.8 | Masc 3.0 - 7.2',
                'rango_sexo'
              ],
            ],
            'Perfil Hepático' => [
              'GOT' => [
                'U/L',
                '0-12',
                'rango'
              ],
              'GPT' => [
                'U/L',
                '0-12',
                'rango'
              ],
              'Fosfatasa Alcalina' => [
                'U/L',
                'Niños 100 - 400 | Adultos 68 - 240',
                'rango_edad'
              ],
              'Bilirrubina Total' => [
                'mg/dl',
                '0-1.0',
                'rango'
              ],
              'Bilirrubina Directa' => [
                'mg/dl',
                '0-0.2',
                'rango'
              ],
              'Bilirrubina Indirecta' => [
                'mg/dl',
                '0-0.8',
                'rango'
              ],
            ],
          ],
          'Inmunologia' => [
            'Inmunologia' => [
              'VDRL' => [
                null,
                'no_reactiva',
                'reactiva'
              ],
              'Chagas IgG' => [
                null,
                'negativo',
                'booleano'
                ],
              ],
          ],
          'Tipificación' => [
            'Tipificación Sanguinea' => [
              'Grupo Sanguineo' => [
                null,
                null,
                null,
              ],
              'Factor RH' => [
                null,
                null,
                null,
              ],
            ],
          ],
          'Análisis de Orina' => [
            'Exámen Físico' => [
              'Aspecto' => [
                null,
                null,
                null,
              ],
              'Color' => [
                null,
                null,
                null,
              ],
              'Ph' => [
                null,
                null,
                null,
              ],
              'Densidad' => [
                null,
                null,
                null,
              ],
            ],
            'Sedimiento' => [
              'Leucocitos' => [
                null,
                null,
                null,
              ],
              'Hematies' => [
                null,
                null,
                null,
              ],
              'Células Epiteliales Planas' => [
                null,
                null,
                null,
              ],
              'Mucus y Fibras Hialina' => [
                null,
                null,
                null,
              ],
              'Bacterias' => [
                null,
                null,
                null,
              ],
            ],
            'Exámen Químico Cualitativo' => [
              'Glucosa' => [
                null,
                null,
                null,
              ],
              'Proteína' => [
                null,
                null,
                null,
              ],
              'Cetona' => [
                null,
                null,
                null,
              ],
              'Urobilinogeno' => [
                null,
                null,
                null,
              ],
              'Bilirrubina' => [
                null,
                null,
                null,
              ],
              'Sangre' => [
                null,
                null,
                null,
              ],
              'Nitrito' => [
                null,
                null,
                null,
              ],
            ]
          ]
        ];
        foreach ($secciones as $key => $seccion_) {
          $seccion = new Seccion();
          $seccion->titulo = $key;
          $seccion->save();
          foreach ($seccion_ as $key => $subseccion_) {
            $subseccion = new Subseccion();
            $subseccion->titulo = $key;
            $subseccion->seccion_id = $seccion->id;
            $subseccion->save();
            foreach ($subseccion_ as $key => $determinacion) {
              $det = new Determinacion();
              $det->titulo = $key;
              $det->unidad_medida = $determinacion[0];
              $det->rango_referencia = $determinacion[1];
              $det->subseccion_id = $subseccion->id;
              $det->tipo_referencia = $determinacion[2];
              $det->save();
            }
          }
        }
        DB::commit();
    }
}
