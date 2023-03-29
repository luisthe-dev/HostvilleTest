<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProgramRequest;
use App\Models\Program;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{

    public function fetchPrograms()
    {
        return SuccessResponse('Programs Fetched Successfully', Program::all());
    }

    public function fetchProgram($id)
    {
        $program = Program::find($id);

        if (!$program) return  ErrorResponse('Program Does Not Exist');

        return SuccessResponse('Program Found Successfully', $program);
    }

    public function createProgram(CreateProgramRequest $request)
    {
        if (!$request->hasFile('program_image')) return ErrorResponse('Program Image Is Required');

        $coverPath = Storage::put('/public/programs_covers', $request->program_image);

        $program = new Program([
            'program_title' => $request->program_name,
            'program_description' => $request->program_description,
            'program_cover' => $coverPath,
            'program_duration' => $request->program_duration,
        ]);

        $program->save();

        return SuccessResponse('Program Created Successfully', $program, 201);
    }
}
