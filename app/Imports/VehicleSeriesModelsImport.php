<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Admin\VehicleSeriesModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class VehicleSeriesModelsImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public function collection(Collection $rows)
    {
        $lastSeries = null; // To store the last non-null series value

        foreach ($rows as $row) {
            // Fill forward logic for 'series'
            if (!empty($row['series'])) {
                $lastSeries = $row['series'];
            } else {
                $row['series'] = $lastSeries; // Fill forward the last non-null series
            }

            // Skip rows where 'series' is still null after fill-forward
            if (empty($row['series'])) {
                // \Log::warning('Skipped Row: Missing series.', $row->toArray());
                continue;
            }

            // \Log::info('Processed Row Data:', $row->toArray());

            // Check if the model exists based on 'new_model_name_customer'
            $existingModel = VehicleSeriesModel::where('new_model_name_customer', $row['new_model_name_customer_view'])->first();

            if ($existingModel) {
                // Update the existing model with new data
                $existingModel->update([
                    'series' => $row['series'],
                    'previous_name' => $row['previous_name_back_end_use_only'],
                    'new_model_name_backend' => $row['new_model_name_back_end_use_only'], // Update to new name
                    'new_model_name_customer' => $row['new_model_name_customer_view'],
                    'description' => $row['desc_customer_view_quote_use'],
                    'price' => $row['price'],
                    'discount' => is_numeric($row['discount']) ? $row['discount'] : null, // Ensure valid numeric
                    'amount' => $row['amount'],
                    'photo' => $row['photo'] ?? $existingModel->photo,
                ]);
            } else {
                // Create a new record for unmatched data
                VehicleSeriesModel::create([
                    'series' => $row['series'],
                    'previous_name' => $row['previous_name_back_end_use_only'],
                    'new_model_name_backend' => $row['new_model_name_back_end_use_only'],
                    'new_model_name_customer' => $row['new_model_name_customer_view'],
                    'description' => $row['desc_customer_view_quote_use'],
                    'price' => $row['price'],
                    'discount' => is_numeric($row['discount']) ? $row['discount'] : null, // Ensure valid numeric
                    'amount' => $row['amount'],
                    'photo' => $row['photo'] ?? null,
                ]);
            }
        }
    }

    protected function evaluateFormula($formula)
    {
        if (is_numeric($formula)) {
            return $formula;
        }

        // Handle simple Excel formulas like =F2-H2
        if (preg_match('/^=([A-Z]+\d+)-([A-Z]+\d+)$/', $formula, $matches)) {
            // Assuming $matches[1] and $matches[2] are column references (F2, H2)
            $value1 = $this->getCellValue($matches[1]);
            $value2 = $this->getCellValue($matches[2]);
            return $value1 - $value2;
        }

        return null; // Default for unsupported formats
    }
}
