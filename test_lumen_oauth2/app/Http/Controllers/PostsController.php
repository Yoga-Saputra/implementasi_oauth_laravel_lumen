<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index()
    {
        $dt = DB::table('posts')->get();
        return response()->json([
            'message' => 'success',
            'data' => $dt
        ]);
    }
}
