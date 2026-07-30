<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Faculty;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function show($id): Response
    {
        // If $id is a string slug (e.g. "graphic-design" or "digital-marketing")
        if (!is_numeric($id)) {
            $dept = Department::where('slug', $id)->first();
            if ($dept) {
                return $this->renderDepartment($dept);
            }

            $faculty = Faculty::where('slug', $id)->first();
            if ($faculty) {
                return $this->renderFaculty($faculty);
            }

            abort(404);
        }

        // If $id is numeric, check Faculty first (e.g. /department/1 for Faculty 1)
        $faculty = Faculty::with('departments')->find($id);
        if ($faculty) {
            return $this->renderFaculty($faculty);
        }

        // Otherwise check Department by numeric ID
        $dept = Department::find($id);
        if ($dept) {
            return $this->renderDepartment($dept);
        }

        abort(404);
    }

    private function renderDepartment(Department $dept): Response
    {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque harum accusantium, numquam alias, modi ab repellendus neque molestias nihil vero.';

        $departmentData = [
            'id' => $dept->id,
            'title' => $dept->name,
            'slug' => $dept->slug,
            'faculty' => $dept->faculty ? $dept->faculty->name : 'Faculty',
            'description' => $dept->description ?: $lorem,
            'mission' => $dept->mission ?: '...',
            'vision' => $dept->vision ?: '...',
            'goals' => $dept->goals ?: '...',
            'custom_sections' => $dept->custom_sections,
            'programs' => $dept->programs,
            'majors' => $dept->majors,
        ];

        return Inertia::render('DepartmentPage', [
            'department' => $departmentData,
            'facultyId' => $dept->faculty_id ?? 1,
        ]);
    }

    private function renderFaculty(Faculty $faculty): Response
    {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque harum accusantium, numquam alias, modi ab repellendus neque molestias nihil vero.';

        $facultyData = [
            'id' => $faculty->id,
            'name' => $faculty->name,
            'orgChartImage' => $faculty->org_chart_image ?: '/images/org-chart-placeholder.jpg',
            'mission' => $faculty->mission ?: '...',
            'vision' => $faculty->vision ?: '...',
            'goals' => $faculty->goals ?: '...',
            'custom_sections' => $faculty->custom_sections,
            'departmentNames' => $faculty->departments->pluck('name')->toArray(),
            'departments' => $faculty->departments->map(function ($dept) use ($lorem) {
                return [
                    'name' => $dept->name,
                    'slug' => $dept->slug,
                    'description' => $dept->description ?: $lorem,
                ];
            })->toArray(),
        ];

        return Inertia::render('DepartmentDetail', [
            'facultyData' => $facultyData,
        ]);
    }

    public function department($facultyId, $departmentSlug): Response
    {
        $dept = Department::where('slug', $departmentSlug)->first();

        if (!$dept) {
            abort(404);
        }

        return $this->renderDepartment($dept);
    }
}
