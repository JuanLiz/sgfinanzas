<?php

namespace Database\Seeders;

use App\Models\PUC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PUCActivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentasPUC = [
            ['puc_codigo' => '1105', 'puc_descripcion' => 'Caja', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1110', 'puc_descripcion' => 'Bancos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1115', 'puc_descripcion' => 'Remesas en tránsito', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1120', 'puc_descripcion' => 'Cuentas de ahorro', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1125', 'puc_descripcion' => 'Fondos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1205', 'puc_descripcion' => 'Acciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1210', 'puc_descripcion' => 'Cuotas o partes de interés social', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1215', 'puc_descripcion' => 'Bonos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1220', 'puc_descripcion' => 'Cédulas', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1225', 'puc_descripcion' => 'Certificados', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1230', 'puc_descripcion' => 'Papeles comerciales', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1235', 'puc_descripcion' => 'Títulos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1240', 'puc_descripcion' => 'Aceptaciones bancarias o financieras', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1245', 'puc_descripcion' => 'Derechos fiduciarios', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1250', 'puc_descripcion' => 'Derechos de recompra de inversiones negociadas (repos)', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1255', 'puc_descripcion' => 'Obligatorias', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1260', 'puc_descripcion' => 'Cuentas en participación', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1295', 'puc_descripcion' => 'Otras inversiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1299', 'puc_descripcion' => 'Provisiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1305', 'puc_descripcion' => 'Clientes', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1310', 'puc_descripcion' => 'Cuentas corrientes comerciales', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1315', 'puc_descripcion' => 'Cuentas por cobrar a casa matriz', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1320', 'puc_descripcion' => 'Cuentas por cobrar a vinculados económicos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1323', 'puc_descripcion' => 'Cuentas por cobrar a directores', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1325', 'puc_descripcion' => 'Cuentas por cobrar a socios y accionistas', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1328', 'puc_descripcion' => 'Aportes por cobrar', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1330', 'puc_descripcion' => 'Anticipos y avances', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1332', 'puc_descripcion' => 'Cuentas de operación conjunta', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1335', 'puc_descripcion' => 'Depósitos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1340', 'puc_descripcion' => 'Promesas de compra venta', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1345', 'puc_descripcion' => 'Ingresos por cobrar', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1350', 'puc_descripcion' => 'Retención sobre contratos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1355', 'puc_descripcion' => 'Anticipo de impuestos y contribuciones o saldos a favor', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1360', 'puc_descripcion' => 'Reclamaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1365', 'puc_descripcion' => 'Cuentas por cobrar a trabajadores', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1370', 'puc_descripcion' => 'Préstamos a particulares', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1380', 'puc_descripcion' => 'Deudores varios', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1385', 'puc_descripcion' => 'Derechos de recompra de cartera negociada', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1390', 'puc_descripcion' => 'Deudas de difícil cobro', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1399', 'puc_descripcion' => 'Provisiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1405', 'puc_descripcion' => 'Materias primas', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1410', 'puc_descripcion' => 'Productos en proceso', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1415', 'puc_descripcion' => 'Obras de construcción en curso', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1417', 'puc_descripcion' => 'Obras de urbanismo', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1420', 'puc_descripcion' => 'Contratos en ejecución', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1425', 'puc_descripcion' => 'Cultivos en desarrollo', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1428', 'puc_descripcion' => 'Plantaciones agrícolas', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1430', 'puc_descripcion' => 'Productos terminados', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1435', 'puc_descripcion' => 'Mercancías no fabricadas por la empresa', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1440', 'puc_descripcion' => 'Bienes raíces para la venta', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1445', 'puc_descripcion' => 'Semovientes', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1450', 'puc_descripcion' => 'Terrenos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1455', 'puc_descripcion' => 'Materiales, repuestos y accesorios', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1460', 'puc_descripcion' => 'Envases y empaques', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1465', 'puc_descripcion' => 'Inventarios en tránsito', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1499', 'puc_descripcion' => 'Provisiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1504', 'puc_descripcion' => 'Terrenos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1506', 'puc_descripcion' => 'Materiales proyectos petroleros', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1508', 'puc_descripcion' => 'Construcciones en curso', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1512', 'puc_descripcion' => 'Maquinaria y equipos en montaje', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1516', 'puc_descripcion' => 'Construcciones y edificaciones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1520', 'puc_descripcion' => 'Maquinaria y equipo', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1524', 'puc_descripcion' => 'Equipo de oficina', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1528', 'puc_descripcion' => 'Equipo de computación y comunicación', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1532', 'puc_descripcion' => 'Equipo médico-científico', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1536', 'puc_descripcion' => 'Equipo de hoteles y restaurantes', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1540', 'puc_descripcion' => 'Flota y equipo de transporte', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1544', 'puc_descripcion' => 'Flota y equipo fluvial y/o marítimo', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1548', 'puc_descripcion' => 'Flota y equipo aéreo', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1552', 'puc_descripcion' => 'Flota y equipo férreo', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1556', 'puc_descripcion' => 'Acueductos, plantas y redes', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1560', 'puc_descripcion' => 'Armamento de vigilancia', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1562', 'puc_descripcion' => 'Envases y empaques', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1564', 'puc_descripcion' => 'Plantaciones agrícolas y forestales', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1568', 'puc_descripcion' => 'Vías de comunicación', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1572', 'puc_descripcion' => 'Minas y canteras', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1576', 'puc_descripcion' => 'Pozos artesianos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1580', 'puc_descripcion' => 'Yacimientos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1584', 'puc_descripcion' => 'Semovientes', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1588', 'puc_descripcion' => 'Propiedades, planta y equipo en tránsito', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1592', 'puc_descripcion' => 'Depreciación acumulada', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1596', 'puc_descripcion' => 'Depreciación diferida', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1597', 'puc_descripcion' => 'Amortización acumulada', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1598', 'puc_descripcion' => 'Agotamiento acumulado', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1599', 'puc_descripcion' => 'Provisiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1605', 'puc_descripcion' => 'Crédito mercantil', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1610', 'puc_descripcion' => 'Marcas', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1615', 'puc_descripcion' => 'Patentes', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1620', 'puc_descripcion' => 'Concesiones y franquicias', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1625', 'puc_descripcion' => 'Derechos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1630', 'puc_descripcion' => 'Know how', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1635', 'puc_descripcion' => 'Licencias', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1698', 'puc_descripcion' => 'Depreciación y/o amortización acumulada', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1699', 'puc_descripcion' => 'Provisiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1705', 'puc_descripcion' => 'Gastos pagados por anticipado', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1710', 'puc_descripcion' => 'Cargos diferidos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1715', 'puc_descripcion' => 'Costos de exploración por amortizar', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1720', 'puc_descripcion' => 'Costos de explotación y desarrollo', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1730', 'puc_descripcion' => 'Cargos por corrección monetaria diferida', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1798', 'puc_descripcion' => 'Amortización acumulada', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1805', 'puc_descripcion' => 'Bienes de arte y cultura', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1895', 'puc_descripcion' => 'Diversos', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1899', 'puc_descripcion' => 'Provisiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1905', 'puc_descripcion' => 'De inversiones', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1910', 'puc_descripcion' => 'De propiedades, planta y equipo', 'puc_naturaleza' => 'Deudora'],
            ['puc_codigo' => '1995', 'puc_descripcion' => 'De otros activos', 'puc_naturaleza' => 'Deudora'],
        ];

        $fecha = Carbon::now();

        foreach ($cuentasPUC as $cuenta) {
            PUC::firstOrCreate(
                ['puc_codigo' => $cuenta['puc_codigo']], // Check if already exists
                [
                    'puc_descripcion' => $cuenta['puc_descripcion'],
                    'puc_naturaleza' => $cuenta['puc_naturaleza'],
                    'estado' => 'Activo',
                    'fecha_registro' => $fecha,
                ]
            );
        }
        
        $this->command->info('PUC Seeder for Activo (Class 1) ran successfully!');
    }
}
