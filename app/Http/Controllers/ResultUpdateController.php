<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultUpdateController extends Controller
{
    public function update(Request $request, Address $address)
    {
        $values = $request->input('values', []);

        foreach ($values as $resultId => $value) {
            $result = $address->results()->find($resultId);
            if ($result) {
                $result->value = $value;
                $result->save();
            }
        }

        return redirect()->back()->with('success', 'Resultate wurden gespeichert.');
    }
}