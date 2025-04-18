<?php


namespace App\Exports;

  
use App\Repositories\User\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings

{

    /**

    * @return \Illuminate\Support\Collection

    */

    public function collection()

    {

        return User::select("id", "name", "email")->get();

    }

  

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function headings(): array

    {

        return ["ID", "Name", "Email"];

    }

}