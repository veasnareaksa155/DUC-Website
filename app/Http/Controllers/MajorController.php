<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class MajorController extends Controller
{
    public function show($department, $major)
    {
        // Prioritize dynamic database department first
        $dept = \App\Models\Department::where('slug', $major)->first();
        if ($dept) {
            $facultyModel = \App\Models\Faculty::find($department);
            $departmentData = [
                'title' => $dept->name,
                'faculty' => $facultyModel ? $facultyModel->name : 'Faculty',
                'description' => $dept->description ?: '...',
                'mission' => $dept->mission ?: '...',
                'vision' => $dept->vision ?: '...',
                'goals' => $dept->goals ?: '...',
                'custom_sections' => $dept->custom_sections,
                'programs' => $dept->programs,
                'majors' => $dept->majors,
            ];

            return Inertia::render('DepartmentPage', [
                'department' => $departmentData,
                'facultyId' => $department,
            ]);
        }

        // Fallback to static programs.php
        $programs = require resource_path('data/programs.php');
        if (isset($programs[$major])) {
            return Inertia::render('Department/Show', [
                'program' => $programs[$major],
                'facultyHref' => '/department/' . $department,
            ]);
        }

        abort(404);
    }
}