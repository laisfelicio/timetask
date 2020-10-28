<?php

namespace App\Exports;

use App\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cliente::all();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Nome Cliente',
            'Data de delete',
            'Data de criacao',
            'Data de update'
        ];
    }
}
