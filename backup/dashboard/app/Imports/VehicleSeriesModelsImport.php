<?php

namespace App\Imports;

use App\Model\VehicleSeriesModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VehicleSeriesModelsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            VehicleSeriesModel::updateOrCreate(
                ['series' => $row['series']], // Update based on 'series'
                [
                    'previous_name' => $row['previous_name_back_end_use_only'],
                    'new_model_name_backend' => $row['new_model_name_back_end_use_only'],
                    'new_model_name_customer' => $row['new_model_name_customer_view'],
                    'description' => $row['desc_customer_view_quote_use'],
                    'price' => $row['price'],
                    'discount' => $row['discount'],
                    'amount' => $row['amount'],
                    'photo' => $row['photo'] ?? null,
                ]
            );
        }
    }
}
