<?php

namespace Database\Seeders;

use App\Models\ContrapartidaPUC;
use App\Models\PUC; // To lookup parent PUC ID
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log; // For logging if parent PUC not found

class ContrapartidaPUCCuentasDeOrdenDeudorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasContrapartida = [
            ['contpuc_codigo' => '810505', 'contpuc_descripcion' => 'Valores mobiliarios', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8105'],
            ['contpuc_codigo' => '810510', 'contpuc_descripcion' => 'Bienes muebles', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8105'],
            ['contpuc_codigo' => '810599', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8105'],
            ['contpuc_codigo' => '811005', 'contpuc_descripcion' => 'Valores mobiliarios', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8110'],
            ['contpuc_codigo' => '811010', 'contpuc_descripcion' => 'Bienes muebles', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8110'],
            ['contpuc_codigo' => '811015', 'contpuc_descripcion' => 'Bienes inmuebles', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8110'],
            ['contpuc_codigo' => '811020', 'contpuc_descripcion' => 'Contratos de ganado en participación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8110'],
            ['contpuc_codigo' => '811099', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8110'],
            ['contpuc_codigo' => '811505', 'contpuc_descripcion' => 'En arrendamiento', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8115'],
            ['contpuc_codigo' => '811510', 'contpuc_descripcion' => 'En préstamo', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8115'],
            ['contpuc_codigo' => '811515', 'contpuc_descripcion' => 'En depósito', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8115'],
            ['contpuc_codigo' => '811520', 'contpuc_descripcion' => 'En consignación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8115'],
            ['contpuc_codigo' => '811599', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8115'],
            ['contpuc_codigo' => '812005', 'contpuc_descripcion' => 'Ejecutivos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8120'],
            ['contpuc_codigo' => '812010', 'contpuc_descripcion' => 'Incumplimiento de contratos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8120'],
            ['contpuc_codigo' => '819505', 'contpuc_descripcion' => 'Valores adquiridos por recibir', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8195'],
            ['contpuc_codigo' => '819595', 'contpuc_descripcion' => 'Otras', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8195'],
            ['contpuc_codigo' => '819599', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8195'],
            ['contpuc_codigo' => '830505', 'contpuc_descripcion' => 'Bienes muebles', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8305'],
            ['contpuc_codigo' => '830510', 'contpuc_descripcion' => 'Bienes inmuebles', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8305'],
            ['contpuc_codigo' => '830599', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8305'],
            ['contpuc_codigo' => '831005', 'contpuc_descripcion' => 'Acciones', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8310'],
            ['contpuc_codigo' => '831010', 'contpuc_descripcion' => 'Bonos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8310'],
            ['contpuc_codigo' => '831095', 'contpuc_descripcion' => 'Otros', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8310'],
            ['contpuc_codigo' => '831506', 'contpuc_descripcion' => 'Materiales proyectos petroleros', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831516', 'contpuc_descripcion' => 'Construcciones y edificaciones', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831520', 'contpuc_descripcion' => 'Maquinaria y equipo', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831524', 'contpuc_descripcion' => 'Equipo de oficina', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831528', 'contpuc_descripcion' => 'Equipo de computación y comunicación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831532', 'contpuc_descripcion' => 'Equipo médico-científico', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831536', 'contpuc_descripcion' => 'Equipo de hoteles y restaurantes', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831540', 'contpuc_descripcion' => 'Flota y equipo de transporte', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831544', 'contpuc_descripcion' => 'Flota y equipo fluvial y/o marítimo', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831548', 'contpuc_descripcion' => 'Flota y equipo aéreo', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831552', 'contpuc_descripcion' => 'Flota y equipo férreo', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831556', 'contpuc_descripcion' => 'Acueductos, plantas y redes', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831560', 'contpuc_descripcion' => 'Armamento de vigilancia', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831562', 'contpuc_descripcion' => 'Envases y empaques', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831564', 'contpuc_descripcion' => 'Plantaciones agrícolas y forestales', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831568', 'contpuc_descripcion' => 'Vías de comunicación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831572', 'contpuc_descripcion' => 'Minas y canteras', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831576', 'contpuc_descripcion' => 'Pozos artesianos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831580', 'contpuc_descripcion' => 'Yacimientos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831584', 'contpuc_descripcion' => 'Semovientes', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '831599', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8315'],
            ['contpuc_codigo' => '832005', 'contpuc_descripcion' => 'País', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8320'],
            ['contpuc_codigo' => '832010', 'contpuc_descripcion' => 'Exterior', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8320'],
            ['contpuc_codigo' => '832505', 'contpuc_descripcion' => 'Inversiones', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8325'],
            ['contpuc_codigo' => '832510', 'contpuc_descripcion' => 'Deudores', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8325'],
            ['contpuc_codigo' => '832595', 'contpuc_descripcion' => 'Otros activos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8325'],
            ['contpuc_codigo' => '833005', 'contpuc_descripcion' => 'Bonos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8330'],
            ['contpuc_codigo' => '833095', 'contpuc_descripcion' => 'Otros', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8330'],
            ['contpuc_codigo' => '839505', 'contpuc_descripcion' => 'Cheques posfechados', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8395'],
            ['contpuc_codigo' => '839510', 'contpuc_descripcion' => 'Certificados de depósito a término', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8395'],
            ['contpuc_codigo' => '839515', 'contpuc_descripcion' => 'Cheques devueltos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8395'],
            ['contpuc_codigo' => '839520', 'contpuc_descripcion' => 'Bienes y valores en fideicomiso', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8395'],
            ['contpuc_codigo' => '839525', 'contpuc_descripcion' => 'Intereses sobre deudas vencidas', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8395'],
            ['contpuc_codigo' => '839595', 'contpuc_descripcion' => 'Diversas', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8395'],
            ['contpuc_codigo' => '839599', 'contpuc_descripcion' => 'Ajustes por inflación', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8395'],
            ['contpuc_codigo' => '839905', 'contpuc_descripcion' => 'Inversiones', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8399'],
            ['contpuc_codigo' => '839910', 'contpuc_descripcion' => 'Inventarios', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8399'],
            ['contpuc_codigo' => '839915', 'contpuc_descripcion' => 'Propiedades, planta y equipo', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8399'],
            ['contpuc_codigo' => '839920', 'contpuc_descripcion' => 'Intangibles', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8399'],
            ['contpuc_codigo' => '839925', 'contpuc_descripcion' => 'Cargos diferidos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8399'],
            ['contpuc_codigo' => '839995', 'contpuc_descripcion' => 'Otros activos', 'contpuc_tipo' => 'Egreso', 'parent_puc_codigo' => '8399'],
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
        
        $this->command->info('ContrapartidaPUC Seeder for CuentasDeOrdenDeudoras (Class 8) ran successfully!');
    }
}
