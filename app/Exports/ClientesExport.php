<?php

namespace App\Exports;

use App\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\Request;

class ClientesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */






















    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        if($this->request->has('teste')){
            return Cliente::where('id', 1);
        }
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
