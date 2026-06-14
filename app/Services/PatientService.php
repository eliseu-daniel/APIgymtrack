<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\PatientRegistration;
use App\Models\PatientWeight;
use App\Models\Anthropometry;
use Illuminate\Database\Eloquent\Collection;

class PatientService
{
    public function getAllPatients(): Collection
    {
        return Patient::all();
    }

    public function getPatient(int $id): ?Patient
    {
        return Patient::find($id);
    }

    public function createPatient(array $data): Patient
    {
        if (isset($data['birth_date'])) {
            $data['birth_date'] = $this->convertDateFormat($data['birth_date']);
        }

        return Patient::create($data);
    }

    public function updatePatient(int $id, array $data): ?Patient
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return null;
        }

        if (!empty($data['birth_date'])) {
            $data['birth_date'] = $this->convertDateFormat($data['birth_date']);
        }

        $patient->update($data);
        return $patient->fresh();
    }

    public function deactivatePatient(int $id): ?Patient
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return null;
        }

        $patient->update(['is_active' => false]);
        return $patient;
    }

    public function getPatientsForEducator(int $educatorId): Collection
    {
        return Patient::select('patients.*')
            ->join('patient_registrations', 'patients.id', '=', 'patient_registrations.patient_id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->get();
    }

    public function getRegisteredPatientIds(int $educatorId): array
    {
        return PatientRegistration::where('educator_id', $educatorId)
            ->pluck('patient_id')
            ->unique()
            ->toArray();
    }

    private function convertDateFormat(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        $dateTime = \DateTime::createFromFormat('d/m/Y', $date);
        if ($dateTime) {
            return $dateTime->format('Y-m-d');
        }

        return $date;
    }
}
