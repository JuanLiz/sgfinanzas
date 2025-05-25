import os
import re

from bs4 import BeautifulSoup

# Obtener el directorio donde se ejecuta el script
__location__ = os.path.realpath(os.path.join(os.getcwd(), os.path.dirname(__file__)))


def get_account_class_properties(class_digit_str):
    """
    Determines naturaleza for PUC and a default tipo for ContrapartidaPUC
    based on the first digit of the account code (the class).
    """
    naturaleza_map = {
        '1': 'Deudora',    # Activo
        '2': 'Acreedora',  # Pasivo
        '3': 'Acreedora',  # Patrimonio
        '4': 'Acreedora',  # Ingresos
        '5': 'Deudora',    # Gastos
        '6': 'Deudora',    # Costos de venta
        '7': 'Deudora',    # Costos de producción
        '8': 'Deudora',    # Cuentas de orden deudoras
        '9': 'Acreedora',  # Cuentas de orden acreedoras
    }
    
    # Default contpuc_tipo based on class
    # This is an interpretation, adjust as needed for your application logic
    contpuc_tipo_map = {
        '1': 'Ingreso', # e.g. money into bank account (asset)
        '2': 'Egreso',  # e.g. recording a payable (liability), often for an expense
        '3': 'Ingreso', # e.g. capital contribution (patrimony)
        '4': 'Ingreso', # Ingresos
        '5': 'Egreso',  # Gastos
        '6': 'Egreso',  # Costos de venta
        '7': 'Egreso',  # Costos de producción
        '8': 'Egreso',  # Cuentas de orden deudoras (less clear, assuming egreso-like)
        '9': 'Ingreso', # Cuentas de orden acreedoras (less clear, assuming ingreso-like)
    }
    
    naturaleza = naturaleza_map.get(class_digit_str)
    contpuc_tipo = contpuc_tipo_map.get(class_digit_str)
    
    return naturaleza, contpuc_tipo

def parse_puc_html(html_filepath):
    """
    Parses the HTML file to extract PUC and Contrapartida data.
    """
    if not os.path.exists(html_filepath):
        print(f"Error: File not found at {html_filepath}")
        return [], [], None, None

    with open(html_filepath, 'r', encoding='utf-8') as f:
        html_content = f.read()

    soup = BeautifulSoup(html_content, 'html.parser')
    
    puc_data = []
    contrapartida_data = []
    
    first_code_element = soup.find('span', class_='code')
    if not first_code_element:
        print(f"Warning: No codes found in {html_filepath}. Skipping.")
        return [], [], None, None
        
    file_class_digit = first_code_element.text.strip()[0]
    default_naturaleza, default_contpuc_tipo = get_account_class_properties(file_class_digit)

    if default_naturaleza is None:
        print(f"Warning: Could not determine naturaleza for class {file_class_digit} in {html_filepath}")
        return [], [], None, None

    list_items = soup.select('ul.account-list li')

    for item in list_items:
        a_tag = item.find('a')
        if not a_tag:
            continue
        
        code_span = a_tag.find('span', class_='code')
        if not code_span:
            continue
            
        code = code_span.text.strip()
        
        # Extract description: text after the <code> span within <a>
        # Use .contents to get all children, then filter for NavigableString
        description_parts = []
        for content_part in a_tag.contents:
            if content_part == code_span:
                continue
            if isinstance(content_part, str): # NavigableString is a subclass of str
                description_parts.append(content_part.strip())
        
        description = " ".join(description_parts).strip()
        # A simpler way if structure is always <span...> text_node
        # description = a_tag.text.replace(code_span.text, '').strip()


        if len(code) == 4:
            puc_data.append({
                'puc_codigo': code,
                'puc_descripcion': description,
                'puc_naturaleza': default_naturaleza # All 4-digit codes in this file share this
            })
        elif len(code) == 6:
            parent_puc_codigo = code[:4]
            contrapartida_data.append({
                'contpuc_codigo': code,
                'contpuc_descripcion': description,
                'contpuc_tipo': default_contpuc_tipo, # All 6-digit codes in this file get this default
                'parent_puc_codigo': parent_puc_codigo
            })
            
    return puc_data, contrapartida_data, file_class_digit, default_naturaleza

def generate_puc_seeder_php(puc_entries, class_digit, class_description_map, seeder_name_suffix):
    """
    Generates PHP code for the PUC seeder.
    """
    if not puc_entries:
        return ""

    class_description = class_description_map.get(class_digit, f"Clase{class_digit}")
    
    php_code = f"""<?php

namespace Database\\Seeders;

use App\\Models\\PUC;
use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Carbon;

class PUC{seeder_name_suffix}Seeder extends Seeder
{{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {{
        $cuentasPUC = [
"""
    for entry in puc_entries:
        # Escape single quotes in description for PHP string
        desc = entry['puc_descripcion'].replace("'", "\\'")
        php_code += f"            ['puc_codigo' => '{entry['puc_codigo']}', 'puc_descripcion' => '{desc}', 'puc_naturaleza' => '{entry['puc_naturaleza']}'],\n"
    
    php_code += f"""        ];

        $fecha = Carbon::now();

        foreach ($cuentasPUC as $cuenta) {{
            PUC::firstOrCreate(
                ['puc_codigo' => $cuenta['puc_codigo']], // Check if already exists
                [
                    'puc_descripcion' => $cuenta['puc_descripcion'],
                    'puc_naturaleza' => $cuenta['puc_naturaleza'],
                    'estado' => 'Activo',
                    'fecha_registro' => $fecha,
                ]
            );
        }}
        
        $this->command->info('PUC Seeder for {class_description} (Class {class_digit}) ran successfully!');
    }}
}}
"""
    return php_code

def generate_contrapartida_seeder_php(contrapartida_entries, class_digit, class_description_map, seeder_name_suffix):
    """
    Generates PHP code for the ContrapartidaPUC seeder.
    """
    if not contrapartida_entries:
        return ""

    class_description = class_description_map.get(class_digit, f"Clase{class_digit}")

    php_code = f"""<?php

namespace Database\\Seeders;

use App\\Models\\ContrapartidaPUC;
use App\\Models\\PUC; // To lookup parent PUC ID
use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Carbon;
use Illuminate\\Support\\Facades\\Log; // For logging if parent PUC not found

class ContrapartidaPUC{seeder_name_suffix}Seeder extends Seeder
{{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {{
        $cuentasContrapartida = [
"""
    for entry in contrapartida_entries:
        desc = entry['contpuc_descripcion'].replace("'", "\\'")
        php_code += f"            ['contpuc_codigo' => '{entry['contpuc_codigo']}', 'contpuc_descripcion' => '{desc}', 'contpuc_tipo' => '{entry['contpuc_tipo']}', 'parent_puc_codigo' => '{entry['parent_puc_codigo']}'],\n"

    php_code += f"""        ];

        $fecha = Carbon::now();

        foreach ($cuentasContrapartida as $cuenta) {{
            $parentPUC = PUC::where('puc_codigo', $cuenta['parent_puc_codigo'])->first();

            if (!$parentPUC) {{
                Log::warning("Parent PUC with code " . $cuenta['parent_puc_codigo'] . " not found for contrapartida " . $cuenta['contpuc_codigo'] . ". Skipping.");
                $this->command->error("Parent PUC with code " . $cuenta['parent_puc_codigo'] . " not found for contrapartida " . $cuenta['contpuc_codigo'] . ". Skipping.");
                continue;
            }}

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
        }}
        
        $this->command->info('ContrapartidaPUC Seeder for {class_description} (Class {class_digit}) ran successfully!');
    }}
}}
"""
    return php_code


if __name__ == "__main__":
    # --- Configuration ---
    # Provide the path to your HTML file
    html_file_path = __location__ + '/clase9.txt' 
    
    # For better seeder names and output messages
    class_map = {
        '1': "Activo",
        '2': "Pasivo",
        '3': "Patrimonio",
        '4': "Ingresos",
        '5': "Gastos",
        '6': "CostosDeVenta", # No spaces for class names
        '7': "CostosDeProduccion",
        '8': "CuentasDeOrdenDeudoras",
        '9': "CuentasDeOrdenAcreedoras"
    }
    # --- End Configuration ---

    puc_items, contrapartida_items, class_id, _ = parse_puc_html(html_file_path)

    if class_id:
        seeder_suffix_name = class_map.get(class_id, f"Clase{class_id}").replace(" ", "") # e.g. Pasivo, CostosDeVenta

        # Generate PUC Seeder
        puc_seeder_content = generate_puc_seeder_php(puc_items, class_id, class_map, seeder_suffix_name)
        if puc_seeder_content:
            puc_seeder_filename = f"PUC{seeder_suffix_name}Seeder.php"
            with open(puc_seeder_filename, 'w', encoding='utf-8') as f:
                f.write(puc_seeder_content)
            print(f"Generated {puc_seeder_filename}")

        # Generate ContrapartidaPUC Seeder
        contrapartida_seeder_content = generate_contrapartida_seeder_php(contrapartida_items, class_id, class_map, seeder_suffix_name)
        if contrapartida_seeder_content:
            contrapartida_seeder_filename = f"ContrapartidaPUC{seeder_suffix_name}Seeder.php"
            with open(contrapartida_seeder_filename, 'w', encoding='utf-8') as f:
                f.write(contrapartida_seeder_content)
            print(f"Generated {contrapartida_seeder_filename}")
            
        print("\n--- How to use in Laravel ---")
        print(f"1. Place {puc_seeder_filename} and {contrapartida_seeder_filename} into your `database/seeders/` directory.")
        print("2. Ensure your App\\Models\\PUC and App\\Models\\ContrapartidaPUC models exist and are correctly set up (especially fillable properties).")
        print("3. In `database/seeders/DatabaseSeeder.php`, add these to the `run` method:")
        print(f"   $this->call(PUC{seeder_suffix_name}Seeder::class);")
        print(f"   $this->call(ContrapartidaPUC{seeder_suffix_name}Seeder::class); // Ensure this runs AFTER the PUC seeder")
        print("4. Run `php artisan migrate` (if you haven't already for these tables).")
        print("5. Run `php artisan db:seed` or `php artisan db:seed --class=PUC{seeder_suffix_name}Seeder` followed by `php artisan db:seed --class=ContrapartidaPUC{seeder_suffix_name}Seeder`.")
    else:
        print(f"Could not process {html_file_path} correctly.")