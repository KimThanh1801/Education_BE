<?php

namespace App\Services;

use App\Models\Semesters;
use App\Repositories\SemesterRepository;

class SemesterService
{
    protected $semesterRepo;

    public function __construct(SemesterRepository $semesterRepo)
    {
        $this->semesterRepo = $semesterRepo;
    }

    public function getAll()
    {
        return $this->semesterRepo->getAll();
    }

    public function create(array $data)
    {
        return $this->semesterRepo->create($data);
    }

    public function find($id)
    {
        return $this->semesterRepo->find($id);
    }

    public function update($id, array $data)
    {
        return $this->semesterRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->semesterRepo->delete($id);
    }
        public function getLatestSemester()
    {
        return Semesters::orderBy('id', 'desc')->first();
    }
}
