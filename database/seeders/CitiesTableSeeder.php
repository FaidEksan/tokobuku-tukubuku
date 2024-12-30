<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data kota dari API RajaOngkir
        $cities = $this->fetchCities();

        if ($cities === null) {
            $this->command->error('Failed to fetch cities from API.');
            return;
        }

        // Simpan data kota ke database
        $this->storeCities($cities);

        $this->command->info('Cities table seeded successfully.');
    }

    /**
     * Fetch cities data from API.
     *
     * @return array|null
     */
    private function fetchCities(): ?array
    {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key'),
        ])->get(config('rajaongkir.endpoints.city'));

        if ($response->failed()) {
            return null;
        }

        return $response->json()['rajaongkir']['results'] ?? null;
    }

    /**
     * Store cities data into the database.
     *
     * @param array $cities
     * @return void
     */
    private function storeCities(array $cities): void
    {
        $data = collect($cities)->map(function ($city) {
            return [
                'id'          => $city['city_id'],
                'province_id' => $city['province_id'],
                'name'        => $city['city_name'] . ' - (' . $city['type'] . ')',
            ];
        })->toArray();

        City::insert($data);
    }
}