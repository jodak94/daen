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
              'Ácido Úrico' => [
                'mg/dl',
                'Fem 2.5 - 6.8 | Masc 3.0 - 7.2',
                'rango_sexo'
              ],
            ],
            'Perfil Hepático' => [
              'GOT' => [
                'U/L',
                'Fem 0 - 31 | Masc 0 - 38',
                'rango_sexo'
              ],
              'GPT' => [
                'U/L',
                'Fem 0 - 32 | Masc 0 - 40',
                'rango_sexo'
              ],
              'Fosfatasa Alcalina' => [
                'U/L',
                'Niños 0 - 645 | Adultos 98 - 279',
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
                'sin_referencia',
              ],
              'Factor RH' => [
                null,
                null,
                'sin_referencia',
              ],
            ],
          ],
          'Análisis de Orina' => [
            'Exámen Físico' => [
              'Aspecto' => [
                null,
                null,
                'sin_referencia',
              ],
              'Color' => [
                null,
                null,
                'sin_referencia',
              ],
              'Ph' => [
                null,
                null,
                'sin_referencia',
              ],
              'Densidad' => [
                null,
                null,
                'sin_referencia',
              ],
            ],
            'Sedimiento' => [
              'Leucocitos' => [
                null,
                null,
                'sin_referencia',
              ],
              'Hematies' => [
                null,
                null,
                'sin_referencia',
              ],
              'Células Epiteliales Planas' => [
                null,
                null,
                'sin_referencia',
              ],
              'Mucus y Fibras Hialina' => [
                null,
                null,
                'sin_referencia',
              ],
              'Bacterias' => [
                null,
                null,
                'sin_referencia',
              ],
            ],
            'Exámen Químico Cualitativo' => [
              'Glucosa' => [
                null,
                null,
                'sin_referencia',
              ],
              'Proteína' => [
                null,
                null,
                'sin_referencia',
              ],
              'Cetona' => [
                null,
                null,
                'sin_referencia',
              ],
              'Urobilinogeno' => [
                null,
                null,
                'sin_referencia',
              ],
              'Bilirrubina' => [
                null,
                null,
                'sin_referencia',
              ],
              'Sangre' => [
                null,
                null,
                'sin_referencia',
              ],
              'Nitrito' => [
                null,
                null,
                'sin_referencia',
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

        DB::table('backgorund_images')->insert([
          ['file' => 'img/back-1.jpg'],
          ['file' => 'img/back-2.jpg'],
        ]);
        DB::commit();
    }
}
