<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = [
            ['cod' => '01', 'name' => 'Alava'],
            ['cod' => '02', 'name' => 'Albacete'],
            ['cod' => '03', 'name' => 'Alicante'],
            ['cod' => '04', 'name' => 'Almera'],
            ['cod' => '05', 'name' => 'Avila'],
            ['cod' => '06', 'name' => 'Badajoz'],
            ['cod' => '07', 'name' => 'Balears (Illes)'],
            ['cod' => '08', 'name' => 'Barcelona'],
            ['cod' => '09', 'name' => 'Burgos'],
            ['cod' => '10', 'name' => 'Cáceres'],
            ['cod' => '11', 'name' => 'Cádiz'],
            ['cod' => '12', 'name' => 'Castellón'],
            ['cod' => '13', 'name' => 'Ciudad Real'],
            ['cod' => '14', 'name' => 'Córdoba'],
            ['cod' => '15', 'name' => 'Coruña (A)'],
            ['cod' => '16', 'name' => 'Cuenca'],
            ['cod' => '17', 'name' => 'Girona'],
            ['cod' => '18', 'name' => 'Granada'],
            ['cod' => '19', 'name' => 'Guadalajara'],
            ['cod' => '20', 'name' => 'Guipzcoa'],
            ['cod' => '21', 'name' => 'Huelva'],
            ['cod' => '22', 'name' => 'Huesca'],
            ['cod' => '23', 'name' => 'Jaén'],
            ['cod' => '24', 'name' => 'León'],
            ['cod' => '25', 'name' => 'Lleida'],
            ['cod' => '26', 'name' => 'Rioja (La)'],
            ['cod' => '27', 'name' => 'Lugo'],
            ['cod' => '28', 'name' => 'Madrid'],
            ['cod' => '29', 'name' => 'Málaga'],
            ['cod' => '30', 'name' => 'Murcia'],
            ['cod' => '31', 'name' => 'Navarra'],
            ['cod' => '32', 'name' => 'Ourense'],
            ['cod' => '33', 'name' => 'Asturias'],
            ['cod' => '34', 'name' => 'Palencia'],
            ['cod' => '35', 'name' => 'Palmas (Las)'],
            ['cod' => '36', 'name' => 'Pontevedra'],
            ['cod' => '37', 'name' => 'Salamanca'],
            ['cod' => '38', 'name' => 'Santa Cruz de Tenerife'],
            ['cod' => '39', 'name' => 'Cantabria'],
            ['cod' => '40', 'name' => 'Segovia'],
            ['cod' => '41', 'name' => 'Sevilla'],
            ['cod' => '42', 'name' => 'Soria'],
            ['cod' => '43', 'name' => 'Tarragona'],
            ['cod' => '44', 'name' => 'Teruel'],
            ['cod' => '45', 'name' => 'Toledo'],
            ['cod' => '46', 'name' => 'Valencia'],
            ['cod' => '47', 'name' => 'Valladolid'],
            ['cod' => '48', 'name' => 'Vizcaya'],
            ['cod' => '49', 'name' => 'Zamora'],
            ['cod' => '50', 'name' => 'Zaragoza'],
            ['cod' => '51', 'name' => 'Ceuta'],
            ['cod' => '52', 'name' => 'Melilla'],
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }
    }
}
