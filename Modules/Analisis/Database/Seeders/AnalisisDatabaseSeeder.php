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
                'Niños 4.0 - 7.0 | Adultos 2.5 - 5.6',
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
                'Fem 45 - ∞ | Masc 35 - ∞',
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
                'rango_hasta'
              ],
              'Bilirrubina Directa' => [
                'mg/dl',
                '0-0.2',
                'rango_hasta'
              ],
              'Bilirrubina Indirecta' => [
                'mg/dl',
                '0-0.8',
                'rango_hasta'
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
                '3.5-5.0',
                'rango'
              ],
              'Cloro' => [
                'mEq/l',
                '95-109',
                'rango'
              ],
            ],
            'Proteinograma' => [
              'Protenias Totales' => [
                'g/dl',
                '6.1-7.9',
                'rango'
              ],
              'Albumina' => [
                'g/dl',
                '3.5-4.8',
                'rango'
              ],
              'Globulinas' => [
                'g/dl',
                '2.5-4.0',
                'rango'
              ],
            ],
          ],
          'Inmunologia' => [
            'Inmunologia' => [
              'VDRL' => [
                null,
                'no_reactiva',
                'reactiva',
                null,
                'select',
                '|No Reactiva|Reactiva T:1/1|Reactiva T:1/2|Reactiva T:1/4|Reactiva T:1/8|Reactiva T:1/16|Reactiva T:1/64|Reactiva T:1/128|Reactiva T:1/256|Reactiva T:1/512'
              ],
              'Chagas IgG' => [
                null,
                'negativo',
                'booleano'
              ],
              'Chagas IgM' => [
                null,
                'negativo',
                'booleano'
              ],
              'PCR Cuantitativo' => [
                'mg/l',
                '0-6',
                'rango'
              ],
              'PCR Cualitativo' => [
                null,
                'no_reactiva',
                'reactiva'
              ],
              'HIV1-HIV2-ac' => [
                null,
                'no_reactiva',
                'reactiva'
              ],
              'Artritest' => [
                'UI/ml',
                '0-30',
                'rango'
              ],
              'ASTO' => [
                'UI/ml',
                '0-200',
                'rango_hasta'
              ],
              'FTA-abs-IgG' => [
                null,
                'negativo',
                'booleano'
              ],
              'FTA-abs-IgM' => [
                null,
                'negativo',
                'booleano'
              ],
              'Hepatitis B (HbsAg)' => [
                null,
                'negativo',
                'booleano'
              ],
              'Hepatitis A-IgM' => [
                null,
                'negativo',
                'booleano'
              ],
              'Hepatitis A Total' => [
                null,
                'negativo',
                'booleano'
              ],
              'Hepatitis C' => [
                null,
                'negativo',
                'booleano'
              ],
              'Test de Coombs - Indirecto' => [
                null,
                'negativo',
                'booleano'
              ],
              'Test de Coombs - Directo' => [
                null,
                'negativo',
                'booleano'
              ],
              'IgE Total' => [
                null,
                'negativo',
                'booleano'
              ],
              'Antinucleares ANA -IgG, Anticuerpos' => [
                'KUI/ML',
                '0-100',
                'rango_hasta'
              ],
              'DNA ds, Anticuerpos' => [
                null,
                'negativo',
                'booleano',
                'Negativo:dil.1:20'
              ],
              'Estradiol' => [
                'pg/ml',
                null,
                null,
                '1º Mitad: 10-73 pg/ml |
                 2º Mitad: 23-240 pg/ml |
                 Fase lutea: 14-255 pg/ml |
                 Pico Ovulatorio: 80-560 pg/ml |
                 Menopausia: Menor a 35 pg/mg'
              ],
              'Hormona Luteinizante LH' => [
                'mUI/ml',
                null,
                null,
                '1- Fase Folicular: 1-7 mUI/ml |
                 2- Mitad de Ciclo: 6-73 mUI/ml |
                 3- Fase Lutea: 0.5-10 mUI/ml |
                 4- Post Menopausia: 0-58 mUI/ml |
                 5- Contraceptivo Oral: 0-5.9 mUI/ml |
                 6- Pre Pubertad: 0'
              ],
              'Progesterona' => [
                'ng/ml',
                null,
                null,
                '1- Fase Folicular: 0.15-1.4 ng/ml |
                 2- Fase Lutea: 1.6-2.1 ng/ml |
                 3- Fase Lutea media: 5.2-23 ng/ml |
                 4- Post Menopausia: 0.11-0.90 ng/ml |
                 Mujeres Embarazadas |
                 1er Trimestre: 7.4-71 ng/ml|
                 2do Trimestre: 18-106 ng/ml|
                 3er Trimestre: 41-100 ng/ml'
              ],
              'Prolactina' => [
                'ng/ml',
                null,
                null,
                'Mujeres: 5-26 ng/ml|
                 Post Menopausia: 3.3-18 ng/ml|
                 Pre Pubertad: Menor a 1.5 ng/ml'
              ],
            ],
            'Serologia para Dengue' => [
              'Anticuerpo IgG' => [
                null,
                'negativo',
                'booleano'
              ],
              'Anticuerpo IgM' => [
                null,
                'negativo',
                'booleano'
              ],
              'NS1 Antigeno' => [
                null,
                'negativo',
                'booleano'
              ],
            ]
          ],
          'Endocrinología' => [
            'Endocrinología' => [
              'TSH' => [
                'uUI/ml',
                '0.25-5.0',
                'rango'
              ],
              'T3 TOTAL' => [
                'ng/ml',
                '90-190',
                'rango'
              ],
              'T4 TOTAL' => [
                'ug/ml',
                '4.5-12.5',
                'rango'
              ],
              'TPO ac' => [
                'UI/ml',
                '0-100',
                'rango_hasta'
              ],
              'T4 LIBRE (FT4)' => [
                'pmol/l',
                '10-20',
                'rango'
              ],
              'T3 LIBRE (FT3)' => [
                'pmol/l',
                '4-8.3',
                'rango'
              ],
              'PAS' => [
                'ng/ml',
                '0-4',
                'rango_hasta'
              ],
              'PAS LIBRE' => [
                'ng/ml',
                null,
                'sin referencia'
              ],
              'B-HCG' => [
                null,
                'negativo',
                'booleano',
                'En caso de persistir el atraso repetir |
                 el análisis a las 1 (una) semana. |
                 El nivel en la sangre es superior |
                 a 1 mIU. durante el embarazo normal.',
                'bhcg',
              ],
              'B-HCG Cuantitativo' => [
                'mUI/ml',
                '0-5',
                'rango',
                'Inferior a 5 mUI/ml |
                 Mujeres embarazadas: |
                 Semanas después del primer dia |
                 del último perior menstrual. |
                 Semanas: |
                 4        196 - 3537 mUI/ml |
                 5        1026 - 30964 mUI/ml |
                 6        4250 - 81172 mUI/ml |
                 7-8      6000 - 114430 mUI/ml |
                9-10     18344 - 98807 mUI/ml |',
              ],
              'TESTOSTERONA total' => [
                'ng/ml',
                '10-73.2',
                'rango'
              ],
              'TESTOSTERONA libre' => [
                'ng/ml',
                '0.7-3.6',
                'rango'
              ],
              'Hormona Foliculo Estimulante-F.S.H.' => [
                'mU/ml',
                null,
                null,
                '1- Fase Folicular: 3.3-8.8 mU/ml |
                 2- Mitad de Ciclo: 5.4-20 mU/ml |
                 3- Fase Lutea: 1.6-8.7 mU/ml |
                 4- Post Menopausia: 9.5-126 mU/ml |
                 5- Con anticonceptivos Oral: 0-4.6 mU/ml |
                 6- Pre Pubertad(1-13 años): 0.1 - 3.4 mU/ml'
              ],
            ],
          ],
          'Hematología' => [
            'Hematología' => [
              'C3,Complemento' => [
                'ng/dl',
                '70-176',
                'rango'
              ],
              'C4,Complemento' => [
                'ng/dl',
                '15-70',
                'rango'
              ],
              'CEA' => [
                'ng/dl',
                null,
                'sin_referencia',
                'No fumadores 0-3 | Fumadores 0-5'
              ],
              'CA 125' => [
                'U/ml',
                '0-30',
                'rango'
              ],
              'CA 19.9' => [
                'U/ml',
                '0-40',
                'rango'
              ],
            ],
          ],
          'Tipificación Sanguinea' => [
            'Tipificación Sanguinea' => [
              'Grupo Sanguineo' => [
                null,
                null,
                'sin_referencia',
                null,
                'select',
                '|A|B|AB|O'
              ],
              'Factor RH' => [
                null,
                null,
                'sin_referencia',
                null,
                'select',
                '|Positivo (+)|Negativo (-)'
              ],
            ],
          ],
          'Crasis Sanguinea' => [
            'Crasis Sanguinea' => [
              'Tiempo de Protrombina' => [
                '%',
                '70 - 100',
                'rango',
                '70 - 100 % de actuvidad normal'
              ],
              'I.N.R' => [
                null,
                '0-1.0',
                'rango_hasta',
              ],
              'T.T.P.A.' => [
                'seg.',
                '20-40',
                'rango',
              ],
              'Recuento de plaquetas' => [
                '/mm3',
                '150000-450000',
                'rango',
              ],
            ],
          ],
          'Análisis de Orina' => [
            'Orina de 24 horas' => [
              'Proteinuria' => [
                'mg/24 Hs.',
                '30-140',
                'rango'
              ],
              'Cratinina en Sangre' => [
                'mg/dl',
                '0.8-1.4',
                'rango'
              ],
              'Creatinina en Orina' => [
                'g/24 Hs.',
                '0.9-1.5',
                'rango'
              ],
              'Clearence de creatinina' => [
                'ml/min Hs.',
                '80-140',
                'rango'
              ],
              'Volumen total' => [
                null,
                null,
                'sin_referencia'
              ],
            ],
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

          if($seccion == 'Endocrinología')//Caso especial para bhcg
            $eseccion = $seccion->id;
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
              if(isset($determinacion[3]))//texto_ref
                $det->texto_ref = $determinacion[3];
              if(isset($determinacion[4])){//trato_especial
                $det->trato_especial = true;
                $det->tipo_trato = $determinacion[4];
              }
              if(isset($determinacion[5])){//texto_h
                $det->texto_h = $determinacion[5];
              }
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
