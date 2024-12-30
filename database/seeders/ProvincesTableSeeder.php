<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data provinsi dari API RajaOngkir
        $provinces = $this->fetchProvinces();

        if ($provinces === null) {
            $this->command->error('Failed to fetch provinces from API.');
            return;
        }

        // Simpan data provinsi ke database
        $this->storeProvinces($provinces);

        $this->command->info('Provinces table seeded successfully.');
    }

    /**
     * Fetch provinces data from API.
     *
     * @return array|null
     */
    private function fetchProvinces(): ?array
    {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key'),
        ])->get(config('rajaongkir.endpoints.province'));

        if ($response->failed()) {
            return null;
        }

        return $response->json()['rajaongkir']['results'] ?? null;
    }

    /**
     * Store provinces data into the database.
     *
     * @param array $provinces
     * @return void
     */
    private function storeProvinces(array $provinces): void
    {
        $data = collect($provinces)->map(function ($province) {
            return [
                'id'   => $province['province_id'],
                'name' => $province['province'],
            ];
        })->toArray();

        Province::insert($data);
    }
}