<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrescriptionController extends Controller
{
    // Create a new prescription
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'patients_id' => 'required|exists:patients,id',  // Ensuring the patient exists
            'med_id' => 'required|exists:medicines,id',      // Ensuring the medicine exists
            'prescription_date' => 'required|date',          // Ensuring a valid date
            'qty_taken' => 'required|integer|min:1',         // Ensuring quantity is positive integer
        ]);

        // If validation fails, return validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // 422 Unprocessable Entity
        }

        // Create the prescription record
        $prescription = Prescription::create([
            'patients_id' => $request->patients_id,
            'med_id' => $request->med_id,
            'prescription_date' => $request->prescription_date,
            'qty_taken' => $request->qty_taken,
        ]);

        // Return success response
        return response()->json([
            'message' => 'Prescription created successfully!',
            'prescription' => $prescription,
        ], 201);
    }

    // Update an existing prescription
    public function update(Request $request, $id)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'patients_id' => 'required|exists:patients,id',
            'med_id' => 'required|exists:medicines,id',
            'prescription_date' => 'required|date',
            'qty_taken' => 'required|integer|min:1',
        ]);

        // If validation fails, return validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the prescription by ID
        $prescription = Prescription::find($id);
        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404); // 404 Not Found
        }

        // Update prescription details
        $prescription->update($request->all());

        // Return success response
        return response()->json([
            'message' => 'Prescription updated successfully!',
            'prescription' => $prescription,
        ], 200);
    }

    // Delete a prescription
    public function destroy($id)
    {
        // Find the prescription by ID
        $prescription = Prescription::find($id);
        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404); // 404 Not Found
        }

        // Delete the prescription
        $prescription->delete();

        // Return success response
        return response()->json(['message' => 'Prescription deleted successfully'], 200);
    }
}
