<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SemesterService;

class SemesterController extends Controller
{
    protected $semesterService;

    public function __construct(SemesterService $semesterService)
    {
        $this->semesterService = $semesterService;
    }

    // Lấy tất cả học kỳ
    public function index()
    {
        $semesters = $this->semesterService->getAll();
        return response()->json($semesters);
    }

    // Thêm mới học kỳ
public function store()
{
    // Lấy học kỳ mới nhất để tăng số
    $lastSemester = $this->semesterService->getLatestSemester();

    // Nếu chưa có học kỳ nào, bắt đầu từ 1
    $newNumber = $lastSemester ? intval(preg_replace('/[^0-9]/', '', $lastSemester->name)) + 1 : 1;

    // Tính ngày bắt đầu và kết thúc học kỳ mới, ví dụ mỗi kỳ cách 6 tháng
    $startDate = now()->addMonths(6 * ($newNumber - 1))->format('Y-m-d');
    $endDate = now()->addMonths(6 * $newNumber)->format('Y-m-d');

    // Dữ liệu học kỳ mới
    $semesterData = [
        'name'       => 'Semester ' . $newNumber,
        'start_date' => $startDate,
        'end_date'   => $endDate,
    ];

    // Tạo học kỳ mới
    try {
        $semester = $this->semesterService->create($semesterData);
        return response()->json($semester, 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to create new semester', 'error' => $e->getMessage()], 500);
    }
}


    // Lấy chi tiết học kỳ
    public function show($id)
    {
        $semester = $this->semesterService->find($id);
        return response()->json($semester);
    }

    // Cập nhật học kỳ
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date'   => 'sometimes|required|date|after:start_date',
        ]);

        $semester = $this->semesterService->update($id, $request->all());
        return response()->json($semester);
    }

    // Xóa học kỳ
    public function destroy($id)
    {
        $this->semesterService->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
