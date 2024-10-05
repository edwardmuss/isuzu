<?php

namespace App\Exports;
use App\Helpers\DbHelper;
use App\Model\UssdUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Excel implements FromQuery, WithHeadings
{
    use Exportable;
    private $request;
    private $model;

    public function __construct($request, Model $model)
    {
        $this->request = $request;
        $this->model = $model;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        $users = DbHelper::create_query($this->model, $this->request);
        return $users;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return Schema::getColumnListing($this->model->getTable());
    }
}