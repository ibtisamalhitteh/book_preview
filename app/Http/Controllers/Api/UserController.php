<?php

namespace App\Http\Controllers\Api;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\User;
use App\Repositories\User\UserRepo;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponser;
    private UserRepo $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * This is function return history of books related to user.
     */
    public function getHistory(Request $request)
    {
        try {
            $user = Auth::user('api');

            $data = [ "userhistory" => $user->userhistory()->get()];
            return $this->success($data, "get user history successfully", 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->error($message , 400) ;
        }
    }

    /**
     * Export to Pdf.
     */
    public function generatePDFExport($activity)
    { 
        $users = User::all();
        $pdf = PDF::loadView('pdf.usersdetails', array('users' =>  $users))
        ->setPaper('a4', 'portrait');
        return $pdf->download('users-details.pdf');  
    }

    /**
     * Export to Excel.
     */
    public function generateExcelExport(Request $request)
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
