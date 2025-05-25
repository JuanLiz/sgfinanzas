<?php

namespace Database\Seeders;

use App\Models\ContrapartidaPUC;
use App\Models\PUC; // To lookup parent PUC ID
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log; // For logging if parent PUC not found

class ContrapartidaPUCPatrimonioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasContrapartida = [
            ['contpuc_codigo' => '310505', 'contpuc_descripcion' => 'Capital autorizado', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3105'],
            ['contpuc_codigo' => '310510', 'contpuc_descripcion' => 'Capital por suscribir (DB)', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3105'],
            ['contpuc_codigo' => '310515', 'contpuc_descripcion' => 'Capital suscrito por cobrar (DB)', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3105'],
            ['contpuc_codigo' => '311505', 'contpuc_descripcion' => 'Cuotas o partes de interés social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3115'],
            ['contpuc_codigo' => '311510', 'contpuc_descripcion' => 'Aportes de socios-fondo mutuo de inversión', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3115'],
            ['contpuc_codigo' => '311515', 'contpuc_descripcion' => 'Contribución de la empresa-fondo mutuo de inversión', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3115'],
            ['contpuc_codigo' => '311520', 'contpuc_descripcion' => 'Suscripciones del público', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3115'],
            ['contpuc_codigo' => '320505', 'contpuc_descripcion' => 'Prima en colocación de acciones', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3205'],
            ['contpuc_codigo' => '320510', 'contpuc_descripcion' => 'Prima en colocación de acciones por cobrar (DB)', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3205'],
            ['contpuc_codigo' => '320515', 'contpuc_descripcion' => 'Prima en colocación de cuotas o partes de interés social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3205'],
            ['contpuc_codigo' => '321005', 'contpuc_descripcion' => 'En dinero', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3210'],
            ['contpuc_codigo' => '321010', 'contpuc_descripcion' => 'En valores mobiliarios', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3210'],
            ['contpuc_codigo' => '321015', 'contpuc_descripcion' => 'En bienes muebles', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3210'],
            ['contpuc_codigo' => '321020', 'contpuc_descripcion' => 'En bienes inmuebles', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3210'],
            ['contpuc_codigo' => '321025', 'contpuc_descripcion' => 'En intangibles', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3210'],
            ['contpuc_codigo' => '322505', 'contpuc_descripcion' => 'De acciones', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3225'],
            ['contpuc_codigo' => '322510', 'contpuc_descripcion' => 'De cuotas o partes de interés social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3225'],
            ['contpuc_codigo' => '330505', 'contpuc_descripcion' => 'Reserva legal', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330510', 'contpuc_descripcion' => 'Reservas por disposiciones fiscales', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330515', 'contpuc_descripcion' => 'Reserva para readquisición de acciones', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330516', 'contpuc_descripcion' => 'Acciones propias readquiridas (DB)', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330517', 'contpuc_descripcion' => 'Reserva para readquisición de cuotas o partes de interés social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330518', 'contpuc_descripcion' => 'Cuotas o partes de interés social propias readquiridas (DB)', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330520', 'contpuc_descripcion' => 'Reserva para extensión agropecuaria', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330525', 'contpuc_descripcion' => 'Reserva Ley 7ª de 1990', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330530', 'contpuc_descripcion' => 'Reserva para reposición de semovientes', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330535', 'contpuc_descripcion' => 'Reserva Ley 4ª de 1980', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '330595', 'contpuc_descripcion' => 'Otras', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3305'],
            ['contpuc_codigo' => '331005', 'contpuc_descripcion' => 'Para futuras capitalizaciones', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3310'],
            ['contpuc_codigo' => '331010', 'contpuc_descripcion' => 'Para reposición de activos', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3310'],
            ['contpuc_codigo' => '331015', 'contpuc_descripcion' => 'Para futuros ensanches', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3310'],
            ['contpuc_codigo' => '331095', 'contpuc_descripcion' => 'Otras', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3310'],
            ['contpuc_codigo' => '331505', 'contpuc_descripcion' => 'Para beneficencia y civismo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '331510', 'contpuc_descripcion' => 'Para futuras capitalizaciones', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '331515', 'contpuc_descripcion' => 'Para futuros ensanches', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '331520', 'contpuc_descripcion' => 'Para adquisición o reposición de propiedades, planta y equipo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '331525', 'contpuc_descripcion' => 'Para investigaciones y desarrollo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '331530', 'contpuc_descripcion' => 'Para fomento económico', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '331535', 'contpuc_descripcion' => 'Para capital de trabajo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '331540', 'contpuc_descripcion' => 'Para estabilización de rendimientos', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '331545', 'contpuc_descripcion' => 'A disposición del máximo órgano social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '331595', 'contpuc_descripcion' => 'Otras', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3315'],
            ['contpuc_codigo' => '340505', 'contpuc_descripcion' => 'De capital social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3405'],
            ['contpuc_codigo' => '340510', 'contpuc_descripcion' => 'De superávit de capital', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3405'],
            ['contpuc_codigo' => '340515', 'contpuc_descripcion' => 'De reservas', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3405'],
            ['contpuc_codigo' => '340520', 'contpuc_descripcion' => 'De resultados de ejercicios anteriores', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3405'],
            ['contpuc_codigo' => '340525', 'contpuc_descripcion' => 'De activos en período improductivo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3405'],
            ['contpuc_codigo' => '340530', 'contpuc_descripcion' => 'De saneamiento fiscal', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3405'],
            ['contpuc_codigo' => '340535', 'contpuc_descripcion' => 'De ajustes Decreto 3019 de 1989', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3405'],
            ['contpuc_codigo' => '340540', 'contpuc_descripcion' => 'De dividendos y participaciones decretadas en acciones, cuotas o partes de interés social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3405'],
            ['contpuc_codigo' => '340545', 'contpuc_descripcion' => 'Superávit método de participación', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3405'],
            ['contpuc_codigo' => '380505', 'contpuc_descripcion' => 'Acciones', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3805'],
            ['contpuc_codigo' => '380510', 'contpuc_descripcion' => 'Cuotas o partes de interés social', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3805'],
            ['contpuc_codigo' => '380515', 'contpuc_descripcion' => 'Derechos fiduciarios', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3805'],
            ['contpuc_codigo' => '381004', 'contpuc_descripcion' => 'Terrenos', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381006', 'contpuc_descripcion' => 'Materiales proyectos petroleros', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381008', 'contpuc_descripcion' => 'Construcciones y edificaciones', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381012', 'contpuc_descripcion' => 'Maquinaria y equipo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381016', 'contpuc_descripcion' => 'Equipo de oficina', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381020', 'contpuc_descripcion' => 'Equipo de computación y comunicación', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381024', 'contpuc_descripcion' => 'Equipo médico-científico', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381028', 'contpuc_descripcion' => 'Equipo de hoteles y restaurantes', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381032', 'contpuc_descripcion' => 'Flota y equipo de transporte', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381036', 'contpuc_descripcion' => 'Flota y equipo fluvial y/o marítimo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381040', 'contpuc_descripcion' => 'Flota y equipo aéreo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381044', 'contpuc_descripcion' => 'Flota y equipo férreo', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381048', 'contpuc_descripcion' => 'Acueductos, plantas y redes', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381052', 'contpuc_descripcion' => 'Armamento de vigilancia', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381056', 'contpuc_descripcion' => 'Envases y empaques', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381060', 'contpuc_descripcion' => 'Plantaciones agrícolas y forestales', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381064', 'contpuc_descripcion' => 'Vías de comunicación', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381068', 'contpuc_descripcion' => 'Minas y canteras', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381072', 'contpuc_descripcion' => 'Pozos artesianos', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381076', 'contpuc_descripcion' => 'Yacimientos', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '381080', 'contpuc_descripcion' => 'Semovientes', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3810'],
            ['contpuc_codigo' => '389505', 'contpuc_descripcion' => 'Bienes de arte y cultura', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3895'],
            ['contpuc_codigo' => '389510', 'contpuc_descripcion' => 'Bienes entregados en comodato', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3895'],
            ['contpuc_codigo' => '389515', 'contpuc_descripcion' => 'Bienes recibidos en pago', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3895'],
            ['contpuc_codigo' => '389520', 'contpuc_descripcion' => 'Inventario de semovientes', 'contpuc_tipo' => 'Ingreso', 'parent_puc_codigo' => '3895'],
        ];

        $fecha = Carbon::now();

        foreach ($cuentasContrapartida as $cuenta) {
            $parentPUC = PUC::where('puc_codigo', $cuenta['parent_puc_codigo'])->first();

            if (!$parentPUC) {
                Log::warning("Parent PUC with code " . $cuenta['parent_puc_codigo'] . " not found for contrapartida " . $cuenta['contpuc_codigo'] . ". Skipping.");
                $this->command->error("Parent PUC with code " . $cuenta['parent_puc_codigo'] . " not found for contrapartida " . $cuenta['contpuc_codigo'] . ". Skipping.");
                continue;
            }

            ContrapartidaPUC::firstOrCreate(
                ['contpuc_codigo' => $cuenta['contpuc_codigo']], // Check if already exists
                [
                    'contpuc_descripcion' => $cuenta['contpuc_descripcion'],
                    'contpuc_tipo' => $cuenta['contpuc_tipo'],
                    'puc_idpuc' => $parentPUC->idpuc,
                    'estado' => 'Activo',
                    'fecha_registro' => $fecha,
                ]
            );
        }
        
        $this->command->info('ContrapartidaPUC Seeder for Patrimonio (Class 3) ran successfully!');
    }
}
