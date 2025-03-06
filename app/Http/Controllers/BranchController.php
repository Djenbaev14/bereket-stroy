<?php

namespace App\Http\Controllers;

use App\Http\Resources\BranchResource;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(){
        $brands = Branch::orderBy('id','desc')->get();
        return $this->responsePagination($brands, BranchResource::collection($brands));
    }
}
