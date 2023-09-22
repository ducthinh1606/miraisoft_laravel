<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Account::paginate(2);
        } catch (\Exception $exception) {
            Log::info($exception);
            return $exception;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAccountRequest $request)
    {
        try {
            return Account::create($request->all());
        } catch (\Exception $exception) {
            Log::info($exception);
            return $exception;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return Account::find($id);
        } catch (\Exception $exception) {
            Log::info($exception);
            return $exception;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, string $id)
    {
        try {
            return Account::where('registerID', $id)->update($request->all());
        } catch (\Exception $exception) {
            Log::info($exception);
            return $exception;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            return Account::destroy($id);
        } catch (\Exception $exception) {
            Log::info($exception);
            return $exception;
        }
    }
}
