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
              'Calcio' => [
                'mg/dl',
                '8.5-10.5',
                'rango'
              ],
              'Magnesio' => [
                'mg/dl',
                '1.7-2.5',
                'rango'
              ],
              'Fosforo' => [
                'mg/dl',
                'Niños 4.0 - 4.0 | Adultos 2.5 - 5.6',
                'rango_edad'
              ],
              'Amilasa' => [
                'UA/dl',
                '0-120',
                'rango'
              ],
              'Lipasa' => [
                'U/L',
                '2-15',
                'rango'
              ],
              'Aldolasa' => [
                'U/L',
                '1.2-8.8',
                'rango'
              ],
              'Hb A1C' => [
                '%',
                '0-6.5',
                'rango'
              ],
            ],
            'Perfil Lipidico' => [
              'Colesterol Total' => [
                'mg/dl',
                '0-200',
                'rango'
              ],
              'HDL' => [
                'mg/dl',
                'Fem 45 - x | Masc 35 - x',
                'rango_sexo'
              ],
              'LDL' => [
                'mg/dl',
                '0-150',
                'rango'
              ],
              'VLDL' => [
                'mg/dl',
                '0-40',
                'rango'
              ],
              'Trigliceridos' => [
                'mg/dl',
                '0-150',
                'rango'
              ],
              'Lipidos totales' => [
                'mg/dl',
                '400-800',
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
              'Gamma GT' => [
                'U/L',
                '11-61',
                'rango'
              ],
            ],
            'Electrolitos' => [
              'Sodio' => [
                'mEq/l',
                '135-148',
                'rango'
              ],
              'Potasio' => [
                'mEq/l',
                '135-148',
                'rango'
              ],
              'Cloro' => [
                'mEq/l',
                '135-148',
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
          'Tipificación Sanguinea' => [
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
          ],
        ];
        $s_orden = 0;
        $ss_orden = 0;
        $d_orden = 0;
        foreach ($secciones as $key => $seccion_) {
          $seccion = new Seccion();
          $seccion->titulo = $key;
          $seccion->orden = $s_orden;
          $seccion->background = 'img/back-resultado-1.jpg';
          $seccion->save();
          $ss_orden = 0;
          foreach ($seccion_ as $key => $subseccion_) {
            $subseccion = new Subseccion();
            $subseccion->titulo = $key;
            $subseccion->seccion_id = $seccion->id;
            $subseccion->orden = $ss_orden;
            if($seccion->titulo == $subseccion->titulo)
              $subseccion->mostrar = false;
            $subseccion->save();
            $d_orden = 0;
            foreach ($subseccion_ as $key => $determinacion) {
              $det = new Determinacion();
              $det->titulo = $key;
              $det->unidad_medida = $determinacion[0];
              $det->rango_referencia = $determinacion[1];
              $det->subseccion_id = $subseccion->id;
              $det->tipo_referencia = $determinacion[2];
              $det->orden = $d_orden;
              $det->save();
              $d_orden++;
            }
            $ss_orden++;
          }
          $s_orden++;
        }


        $microbiologia = [
          'Urocultivo' => [
            'Examen en Fresco',
            'Coloración de Gram',
            'Recuento de colonias',
            'Antibiograma',
          ],
          'Coprocultivo' => [
            'Examen Macroscópico',
            'Examen en Fresco',
            'Benedict',
            'Proteínas',
            'Coloración de Gram',
            'Coloración de Ziebl Nielsen',
            'Cultivo',
          ],
          'Cultivo De Hisopado Faringeo' => [
            'Examen en fresco',
            'Coloración de Gram',
            'Coloración de Giemsa',
            'Coloración de Ziebl Nielsen',
            'Cultivo'
          ]
        ];

        $seccion = new Seccion();
        $seccion->titulo = 'Microbiología';
        $seccion->orden = $s_orden;
        $seccion->salto_pagina = true;
        $seccion->background = 'img/back-resultado-2.jpg';
        $seccion->save();
        $ss_orden = 0;
        foreach ($microbiologia as $sskey => $subseccion_) {
          $subseccion = new Subseccion();
          $subseccion->titulo = $sskey;
          $subseccion->seccion_id = $seccion->id;
          $subseccion->orden = $ss_orden;
          $subseccion->save();
          $d_orden = 0;
          foreach ($subseccion_ as $dkey => $det_) {
            $det = new Determinacion();
            $det->titulo = $det_;
            $det->subseccion_id = $subseccion->id;
            $det->tipo_referencia = 'sin_referencia';
            $det->orden = $d_orden;
            $det->multiples_lineas = true;
            if($det_ == 'Antibiograma'){
              $det->trato_especial = true;
              $det->tipo_trato = 'antibiograma';
            }
            $det->save();
            $d_orden++;
          }
          $ss_orden++;
        }

        DB::table('backgorund_images')->insert([
          ['file' => 'img/back-resultado-1.jpg'],
          ['file' => 'img/back-resultado-2.jpg'],
        ]);

        DB::table('configuraciones')->insert([
          [
            'key' => 'cont_diario',
            'value' => '0',
            'text' => 'Contador diario',
          ],
          [
            'key' => 'antibiograma',
            'value' => 'Ampicilina/Sulbactam, Ampicilina, Cefixima, Cefotaxima, Cefalotina, Cefuroxima, Ceftazidima, Ciprofloxacina, Norfloxacina, Gentamicina, Nitrofurantoina, Trimetoprima/sulfametazol',
            'text' => 'Antibiograma',
          ],
        ]);
        DB::commit();
    }
}
