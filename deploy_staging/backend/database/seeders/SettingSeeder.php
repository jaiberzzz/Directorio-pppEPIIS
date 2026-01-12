<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'contact_address' => "Av. Garcilaso de la Vega S/N\nAbancay, Apurímac",
            'contact_email' => 'epiis@unamba.edu.pe',
            'contact_phone' => '(083) 321-987',
            'contact_phone_raw' => '083321987',
            'map_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15501.587877995393!2d-72.88764560000001!3d-13.633999999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x916d02d871781255%3A0x6734107055745802!2sUniversidad%20Nacional%20Micaela%20Bastidas%20de%20Apurimac!5e0!3m2!1ses-419!2spe!4v1703964593414!5m2!1ses-419!2spe',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
