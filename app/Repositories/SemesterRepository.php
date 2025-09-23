<?php

namespace App\Repositories;

use App\Models\Semester;
use App\Models\Semesters;

class SemesterRepository
{
    // Lấy tất cả học kỳ
    public function getAll()
    {
        return Semesters::all();
    }

    // Tạo học kỳ mới
    public function create(array $data)
    {
        return Semesters::create($data);
    }

    // Tìm học kỳ theo ID
    public function find($id)
    {
        return Semesters::findOrFail($id);
    }

    // Cập nhật học kỳ
    public function update($id, array $data)
    {
        $semester = $this->find($id);
        $semester->update($data);
        return $semester;
    }

    // Xóa học kỳ
    public function delete($id)
    {
        $semester = $this->find($id);
        return $semester->delete();
    }
}
