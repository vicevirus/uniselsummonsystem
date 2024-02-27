<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueSummon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Student;


class SummonController extends Controller
{
    public function paySummon(Request $request)
    {
        // Retrieve the summon ID from the request
        $summonId = $request->summonId;


        // Find the IssueSummon by summon ID
        $issueSummon = IssueSummon::where('summonId', $summonId)->first();

        // Check if IssueSummon exists
        if ($issueSummon) {
            // Update the status to 'paid'
            $issueSummon->update(['status' => 'paid']);

            return view('user.userSummonPaid');
        } else {

            return response()->json(['error' => 'IssueSummon not found'], 404);
        }
    }

    public function updateSummon(Request $request, $summonId)
    {
        // Find the IssueSummon by summon ID
        $issueSummon = IssueSummon::where('summonId', $summonId)->first();

        // Check if IssueSummon exists
        if ($issueSummon) {
            // Update the IssueSummon with the new data
            $issueSummon->update([
                'violation' => $request->violation,
                'fineAmount' => $request->fineAmount,
            ]);

            // Redirect back to the manage summons page with a success message
            return redirect()->route('admin.manage_summons')->with('success', 'Summon updated successfully.');
        } else {
            // Redirect back with an error message if the summon was not found
            return redirect()->route('admin.manage_summons')->with('error', 'Summon not found');
        }
    }

    public function deleteSummon(Request $request, $summonId)
    {
        // Find the IssueSummon by summon ID
        $issueSummon = IssueSummon::where('summonId', $summonId)->first();

        // Check if IssueSummon exists
        if ($issueSummon) {
            // Delete the IssueSummon
            $issueSummon->delete();

            // Redirect back to the manage summons page with a success message
            return redirect()->route('admin.manage_summons')->with('success', 'Summon deleted successfully.');
        } else {
            // Redirect back with an error message if the summon was not found
            return redirect()->route('admin.manage_summons')->with('error', 'Summon not found');
        }
    }





    public function editSummonView(Request $request, $summonId)
    {
        // Find the IssueSummon by summon ID
        $issueSummon = IssueSummon::where('summonId', $summonId)->first();

        // Check if IssueSummon exists
        if ($issueSummon) {
            return view('admin.adminEditSummon', ['summon' => $issueSummon]);
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'IssueSummon not found.');
        }
    }

    public function createSummon(Request $request)
    {
        // Validate request data

        $validator = Validator::make($request->all(), [
            'QRCodeId' => 'required|exists:students,QRCodeId',
            'fineAmount' => 'required|numeric',
            'dueDate' => 'required',
            'securityId' => 'required|exists:security_guards,securityId',
        ]);


        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Parse the dueDate string using Carbon
        $dueDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->dueDate);


        // Find the student with the specified QRCodeId
        $student = Student::where('QRCodeId', $request->QRCodeId)->first();


        // Create a summon
        IssueSummon::create([
            'violation' => $request->violation,
            'fineAmount' => $request->fineAmount,
            'dueDate' => $dueDate, // Use the parsed dueDate
            'issuedBy' => $request->securityName,
            'QRCodeId' => $request->QRCodeId,
            'securityId' => $request->securityId,
        ]);

        $response = Http::post('https://terminal.adasms.com/api/v1/send', [
            '_token' => env('ADA_SMS_API_KEY'),
            'phone' => $student->phoneNumber,
            'message' => "UNISEL: You have been summoned RM" . $request->fineAmount . " for violation: " . $request->violation . '. Pay your summon before ' . $request->dueDate . ".\n\nPlease use the UNISEL summon website to pay off your summon.",

        ]);

        return response()->json(['message' => 'Summon created successfully' . $response], 200);
    }
}
