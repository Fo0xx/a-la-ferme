<?php

namespace Database\Seeders;

use App\Models\Lang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lang::truncate();

        $countries = [
            ['name' => 'Français (French)', 'iso_code' => 'FR', 'langage_locale' => 'fr-FR', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => 'English (English)', 'iso_code' => 'EN', 'langage_locale' => 'en-US', 'date_format_lite' => 'm/d/Y', 'date_format_full' => 'm/d/Y H:i:s'],
            ['name' => 'Español (Spanish)', 'iso_code' => 'ES', 'langage_locale' => 'es-ES', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => 'Deutsch (German)', 'iso_code' => 'DE', 'langage_locale' => 'de-DE', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => 'Italiano (Italian)', 'iso_code' => 'IT', 'langage_locale' => 'it-IT', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => 'Nederlands (Dutch)', 'iso_code' => 'NL', 'langage_locale' => 'nl-NL', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => 'Português (Portuguese)', 'iso_code' => 'PT', 'langage_locale' => 'pt-PT', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => 'Русский (Russian)', 'iso_code' => 'RU', 'langage_locale' => 'ru-RU', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => '中文 (Chinese)', 'iso_code' => 'ZH', 'langage_locale' => 'zh-CN', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => '日本語 (Japanese)', 'iso_code' => 'JA', 'langage_locale' => 'ja-JP', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => '한국어 (Korean)', 'iso_code' => 'KO', 'langage_locale' => 'ko-KR', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
            ['name' => 'Polski (Polish)', 'iso_code' => 'PL', 'langage_locale' => 'pl-PL', 'date_format_lite' => 'd/m/Y', 'date_format_full' => 'd/m/Y H:i:s'],
        ];

        foreach ($countries as $key => $value) {
            Lang::create($value);
        }
    }
}
