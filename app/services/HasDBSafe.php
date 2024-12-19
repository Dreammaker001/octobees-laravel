<?php

namespace App\services;

use Illuminate\Support\Facades\DB;

trait HasDBSafe
{
    public function DBSafe($func)
    {
        try {
            DB::beginTransaction();

            $data = $func();

            DB::commit();
            return $data;
        } catch (\Throwable $th) {

            DB::rollBack();
            throw $th;
        }
    }
}
