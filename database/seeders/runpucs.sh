# Primero los seeders de PUC (cuentas principales)
php artisan db:seed --class=PUCPatrimonioSeeder
php artisan db:seed --class=PUCIngresosSeeder
php artisan db:seed --class=PUCGastosSeeder
php artisan db:seed --class=PUCCostosDeVentaSeeder
php artisan db:seed --class=PUCCuentasDeOrdenDeudorasSeeder
php artisan db:seed --class=PUCCuentasDeOrdenAcreedorasSeeder

# Luego los seeders de ContrapartidaPUC (subcuentas)
php artisan db:seed --class=ContrapartidaPUCActivoSeeder
php artisan db:seed --class=ContrapartidaPUCPasivoSeeder
php artisan db:seed --class=ContrapartidaPUCPatrimonioSeeder
php artisan db:seed --class=ContrapartidaPUCIngresosSeeder
php artisan db:seed --class=ContrapartidaPUCGastosSeeder
php artisan db:seed --class=ContrapartidaPUCCostosDeVentaSeeder
php artisan db:seed --class=ContrapartidaPUCCuentasDeOrdenDeudorasSeeder
php artisan db:seed --class=ContrapartidaPUCCuentasDeOrdenAcreedorasSeeder