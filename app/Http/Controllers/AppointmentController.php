<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Patient;
use App\Models\Psychologist;
use App\Models\PsychologistSchedule;
use App\Models\ServiceRate;
use App\Models\PatientPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Appointment::with([
            'branch',
            'patient',
            'psychologist',
            'serviceRate',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('appointment_no', 'like', '%' . $search . '%')

                    ->orWhereHas('patient', function ($patient) use ($search) {
                        $patient->where('name', 'like', '%' . $search . '%');
                    })

                    ->orWhereHas('psychologist', function ($psychologist) use ($search) {
                        $psychologist->where('name', 'like', '%' . $search . '%');
                    });

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Branch
        |--------------------------------------------------------------------------
        */

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Date
        |--------------------------------------------------------------------------
        */

        if ($request->filled('appointment_date')) {
            $query->where(
                'appointment_date',
                $request->appointment_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Filter Data
        |--------------------------------------------------------------------------
        */

        $branches = Branch::where('is_active', true)
            ->orderBy('branch_name')
            ->get();

        return view(
            'appointments.index',
            compact(
                'appointments',
                'branches'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

 /*
|--------------------------------------------------------------------------
| Create
|--------------------------------------------------------------------------
*/

public function create()
{
    $branches = Branch::where('is_active', true)
        ->with('organization')
        ->orderBy('branch_name')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Patient
    |--------------------------------------------------------------------------
    |
    | Patient tidak lagi mengambil semua data.
    |
    | Patient akan dicari melalui AJAX:
    |
    | Ketik nama / nomor pasien
    |          ↓
    | /patients/search?q=...
    |
    */

    $selectedPatient = null;

    if (old('patient_id')) {
        $selectedPatient = Patient::find(old('patient_id'));
    }

    /*
    |--------------------------------------------------------------------------
    | Psychologist
    |--------------------------------------------------------------------------
    */

    $psychologists = Psychologist::where('is_active', true)
        ->orderBy('name')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Service Rate
    |--------------------------------------------------------------------------
    */

    $serviceRates = ServiceRate::where('is_active', true)
        ->orderBy('service_name')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    return view(
        'appointments.create',
        compact(
            'branches',
            'selectedPatient',
            'psychologists',
            'serviceRates'
        )
    );
}


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

public function store(Request $request)
{
    $validated = $request->validate(
        [
            'branch_id' => [
                'required',
                'integer',
                'exists:branches,id',
            ],

            'patient_id' => [
                'required',
                'integer',
                'exists:patients,id',
            ],

            'source_type' => [
                'required',
                'integer',
                'in:' .
                    Appointment::SOURCE_NORMAL . ',' .
                    Appointment::SOURCE_PACKAGE,
            ],

            'patient_package_id' => [
                'nullable',
                'integer',
                'exists:patient_packages,id',
            ],

            'service_package_detail_id' => [
                'nullable',
                'integer',
                'exists:service_package_details,id',
            ],

            'psychologist_id' => [
                'nullable',
                'integer',
                'exists:psychologists,id',
            ],

            'psychologist_schedule_id' => [
                'nullable',
                'integer',
                'exists:psychologist_schedules,id',
            ],

            'service_rate_id' => [
                'required',
                'integer',
                'exists:service_rates,id',
            ],

            'appointment_date' => [
                'required',
                'date',
            ],

            'appointment_time' => [
                'required',
                'date_format:H:i',
            ],

            'status' => [
                'required',
                'integer',
                'between:1,8',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ],
        [
            'branch_id.required' =>
                'Branch wajib dipilih.',

            'patient_id.required' =>
                'Patient wajib dipilih.',

            'source_type.required' =>
                'Sumber layanan wajib dipilih.',

            'service_rate_id.required' =>
                'Layanan wajib dipilih.',

            'appointment_date.required' =>
                'Tanggal appointment wajib diisi.',

            'appointment_time.required' =>
                'Jam appointment wajib diisi.',

            'appointment_time.date_format' =>
                'Format jam harus HH:MM.',
        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Ambil Service Rate
    |--------------------------------------------------------------------------
    */

    $serviceRate = ServiceRate::findOrFail(
        $validated['service_rate_id']
    );


    /*
    |--------------------------------------------------------------------------
    | Service Rate harus aktif
    |--------------------------------------------------------------------------
    */

    if (!$serviceRate->is_active) {

        return back()
            ->withErrors([
                'service_rate_id' =>
                    'Layanan yang dipilih sudah tidak aktif.',
            ])
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | Validasi Patient Package
    |--------------------------------------------------------------------------
    |
    | Hanya dilakukan jika sumber layanan = Patient Package.
    |
    */

    if (
        (int) $validated['source_type']
        === Appointment::SOURCE_PACKAGE
    ) {

        /*
        |----------------------------------------------------------------------
        | Patient Package wajib dipilih
        |----------------------------------------------------------------------
        */

        if (empty($validated['patient_package_id'])) {

            return back()
                ->withErrors([
                    'patient_package_id' =>
                        'Patient Package wajib dipilih.',
                ])
                ->withInput();
        }


        /*
        |----------------------------------------------------------------------
        | Layanan Package wajib dipilih
        |----------------------------------------------------------------------
        */

        if (empty($validated['service_package_detail_id'])) {

            return back()
                ->withErrors([
                    'service_package_detail_id' =>
                        'Layanan Paket wajib dipilih.',
                ])
                ->withInput();
        }


        /*
        |----------------------------------------------------------------------
        | Ambil Patient Package
        |----------------------------------------------------------------------
        */

        $patientPackage = PatientPackage::with(
            'servicePackage'
        )->findOrFail(
            $validated['patient_package_id']
        );


        /*
        |----------------------------------------------------------------------
        | Pastikan Patient Package milik pasien
        |----------------------------------------------------------------------
        */

        if (
            (int) $patientPackage->patient_id
            !== (int) $validated['patient_id']
        ) {

            return back()
                ->withErrors([
                    'patient_package_id' =>
                        'Patient Package tidak sesuai dengan pasien yang dipilih.',
                ])
                ->withInput();
        }


        /*
        |----------------------------------------------------------------------
        | Patient Package harus ACTIVE
        |----------------------------------------------------------------------
        */

        if (
            $patientPackage->status
            !== PatientPackage::STATUS_ACTIVE
        ) {

            return back()
                ->withErrors([
                    'patient_package_id' =>
                        'Patient Package sudah tidak aktif.',
                ])
                ->withInput();
        }


        /*
        |----------------------------------------------------------------------
        | Patient Package belum expired
        |----------------------------------------------------------------------
        */

        if (
            $patientPackage->expired_at
            && $patientPackage->expired_at->lt(
                $validated['appointment_date']
            )
        ) {

            return back()
                ->withErrors([
                    'patient_package_id' =>
                        'Patient Package sudah expired dan tidak dapat digunakan.',
                ])
                ->withInput();
        }


        /*
        |----------------------------------------------------------------------
        | Service Package harus aktif
        |----------------------------------------------------------------------
        */

        if (
            !$patientPackage->servicePackage
            || !$patientPackage->servicePackage->is_active
        ) {

            return back()
                ->withErrors([
                    'patient_package_id' =>
                        'Service Package sudah tidak aktif dan tidak dapat digunakan.',
                ])
                ->withInput();
        }


        /*
        |----------------------------------------------------------------------
        | Detail layanan harus benar-benar milik package
        |----------------------------------------------------------------------
        */

        $packageDetail = $patientPackage
            ->servicePackage
            ->details()
            ->where(
                'id',
                $validated['service_package_detail_id']
            )
            ->with('serviceRate')
            ->first();


        if (!$packageDetail) {

            return back()
                ->withErrors([
                    'service_package_detail_id' =>
                        'Layanan yang dipilih tidak terdapat dalam Patient Package.',
                ])
                ->withInput();
        }


        /*
        |----------------------------------------------------------------------
        | Service Rate harus sesuai dengan detail package
        |----------------------------------------------------------------------
        */

        if (
            (int) $packageDetail->service_rate_id
            !== (int) $validated['service_rate_id']
        ) {

            return back()
                ->withErrors([
                    'service_package_detail_id' =>
                        'Layanan appointment tidak sesuai dengan layanan package.',
                ])
                ->withInput();
        }


        /*
        |----------------------------------------------------------------------
        | Kuota Package
        |--------------------------------------------------------------------------
        */

        $usedQuantity = \App\Models\PatientPackageUsage::query()
            ->where(
                'patient_package_id',
                $patientPackage->id
            )
            ->where(
                'service_package_detail_id',
                $packageDetail->id
            )
            ->sum('quantity');


        $remainingQuantity =
            $packageDetail->quantity
            - $usedQuantity;


        if ($remainingQuantity <= 0) {

            return back()
                ->withErrors([
                    'service_package_detail_id' =>
                        'Kuota layanan dalam Patient Package sudah habis.',
                ])
                ->withInput();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Hitung Interval Appointment Baru
    |--------------------------------------------------------------------------
    */

    $newStart = Carbon::parse(
        $validated['appointment_date']
        . ' '
        . $validated['appointment_time']
    );

    $newEnd = $newStart
        ->copy()
        ->addMinutes(
            (int) $serviceRate->duration
        );


    /*
    |--------------------------------------------------------------------------
    | Validasi Bentrok Appointment Pasien
    |--------------------------------------------------------------------------
    */

    $patientConflict = Appointment::query()
        ->where(
            'patient_id',
            $validated['patient_id']
        )
        ->whereDate(
            'appointment_date',
            $validated['appointment_date']
        )
        ->whereNotIn('status', [
            Appointment::STATUS_COMPLETED,
            Appointment::STATUS_CLOSED,
            Appointment::STATUS_CANCELLED,
            Appointment::STATUS_NO_SHOW,
        ])
        ->get()
        ->contains(
            function ($appointment) use (
                $newStart,
                $newEnd
            ) {

                $existingStart = Carbon::parse(
                    $appointment->appointment_date->format('Y-m-d')
                    . ' '
                    . $appointment->appointment_time->format('H:i')
                );

                $existingEnd = $existingStart
                    ->copy()
                    ->addMinutes(
                        $appointment->duration
                    );

                return $newStart < $existingEnd
                    && $newEnd > $existingStart;
            }
        );


    if ($patientConflict) {

        return back()
            ->withErrors([
                'appointment_time' =>
                    'Pasien sudah memiliki appointment yang waktunya bertabrakan.',
            ])
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | Validasi Bentrok Psikolog
    |--------------------------------------------------------------------------
    */

    if (!empty($validated['psychologist_id'])) {

        $psychologistConflict = Appointment::query()
            ->where(
                'psychologist_id',
                $validated['psychologist_id']
            )
            ->whereDate(
                'appointment_date',
                $validated['appointment_date']
            )
            ->whereNotIn('status', [
                Appointment::STATUS_COMPLETED,
                Appointment::STATUS_CLOSED,
                Appointment::STATUS_CANCELLED,
                Appointment::STATUS_NO_SHOW,
            ])
            ->get()
            ->contains(
                function ($appointment) use (
                    $newStart,
                    $newEnd
                ) {

                    $existingStart = Carbon::parse(
                        $appointment->appointment_date->format('Y-m-d')
                        . ' '
                        . $appointment->appointment_time->format('H:i')
                    );

                    $existingEnd = $existingStart
                        ->copy()
                        ->addMinutes(
                            $appointment->duration
                        );

                    return $newStart < $existingEnd
                        && $newEnd > $existingStart;
                }
            );


        if ($psychologistConflict) {

            return back()
                ->withErrors([
                    'psychologist_id' =>
                        'Psikolog sudah memiliki appointment yang waktunya bertabrakan.',
                ])
                ->withInput();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Create Appointment
    |--------------------------------------------------------------------------
    */

    $appointment = DB::transaction(
        function () use (
            $validated,
            $serviceRate
        ) {

            /*
            |------------------------------------------------------------------
            | Generate Appointment Number
            |------------------------------------------------------------------
            */

            $branch = Branch::findOrFail(
                $validated['branch_id']
            );


            $prefix =
                'APT-' .
                $branch->branch_code . '-' .
                now()->format('Ym') . '-';


            $lastAppointment = Appointment::withTrashed()
                ->where(
                    'branch_id',
                    $branch->id
                )
                ->where(
                    'appointment_no',
                    'like',
                    $prefix . '%'
                )
                ->orderByDesc('id')
                ->first();


            $nextNumber = $lastAppointment
                ? ((int) substr(
                    $lastAppointment->appointment_no,
                    -6
                )) + 1
                : 1;


            $appointmentNo =
                $prefix .
                str_pad(
                    $nextNumber,
                    6,
                    '0',
                    STR_PAD_LEFT
                );


            /*
            |------------------------------------------------------------------
            | Create Appointment
            |------------------------------------------------------------------
            */

            return Appointment::create([

                'appointment_no' =>
                    $appointmentNo,

                'branch_id' =>
                    $validated['branch_id'],

                'patient_id' =>
                    $validated['patient_id'],

                'psychologist_id' =>
                    $validated['psychologist_id'] ?? null,

                'psychologist_schedule_id' =>
                    $validated['psychologist_schedule_id'] ?? null,

                'service_rate_id' =>
                    $validated['service_rate_id'],

                'source_type' =>
                    $validated['source_type'],

                'patient_package_id' =>
                    $validated['patient_package_id'] ?? null,

                'service_package_detail_id' =>
                    $validated['service_package_detail_id'] ?? null,

                'appointment_date' =>
                    $validated['appointment_date'],

                'appointment_time' =>
                    $validated['appointment_time'],

                'duration' =>
                    $serviceRate->duration,

                'status' =>
                    $validated['status'],

                'notes' =>
                    $validated['notes'] ?? null,

                'created_by' =>
                    auth()->id(),
            ]);
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'appointments.show',
            $appointment->id
        )
        ->with(
            'success',
            'Appointment berhasil dibuat.'
        );
}

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(string $id)
    {
        $appointment = Appointment::withTrashed()
            ->with([
                'branch.organization',
                'patient',
                'psychologist',
                'psychologistSchedule',
                'serviceRate',
                'creator',
            ])
            ->findOrFail($id);

        return view(
            'appointments.show',
            compact('appointment')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $branches = Branch::where('is_active', true)
            ->with('organization')
            ->orderBy('branch_name')
            ->get();

        $patients = Patient::orderBy('name')
            ->get();

        $psychologists = Psychologist::where('is_active', true)
            ->orderBy('name')
            ->get();

        $serviceRates = ServiceRate::where('is_active', true)
            ->orderBy('service_name')
            ->get();

        $schedules = PsychologistSchedule::where(
                'psychologist_id',
                $appointment->psychologist_id
            )
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return view(
            'appointments.edit',
            compact(
                'appointment',
                'branches',
                'patients',
                'psychologists',
                'serviceRates',
                'schedules'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        string $id
    ) {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate(
            [
                'branch_id' => [
                    'required',
                    'integer',
                    'exists:branches,id',
                ],

                'patient_id' => [
                    'required',
                    'integer',
                    'exists:patients,id',
                ],

                'psychologist_id' => [
                    'nullable',
                    'integer',
                    'exists:psychologists,id',
                ],

                'psychologist_schedule_id' => [
                    'nullable',
                    'integer',
                    'exists:psychologist_schedules,id',
                ],

                'service_rate_id' => [
                    'required',
                    'integer',
                    'exists:service_rates,id',
                ],

                'appointment_date' => [
                    'required',
                    'date',
                ],

                'appointment_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'status' => [
                    'required',
                    'integer',
                    'between:1,8',
                ],

                'notes' => [
                    'nullable',
                    'string',
                ],
            ]
        );

        $appointment->update([
            'branch_id' =>
                $validated['branch_id'],

            'patient_id' =>
                $validated['patient_id'],

            'psychologist_id' =>
                $validated['psychologist_id'] ?? null,

            'psychologist_schedule_id' =>
                $validated['psychologist_schedule_id'] ?? null,

            'service_rate_id' =>
                $validated['service_rate_id'],

            'appointment_date' =>
                $validated['appointment_date'],

            'appointment_time' =>
                $validated['appointment_time'],

            'status' =>
                $validated['status'],

            'notes' =>
                $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route(
                'appointments.show',
                $appointment->id
            )
            ->with(
                'success',
                'Appointment berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment berhasil diarsipkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Archived
    |--------------------------------------------------------------------------
    */

    public function archived()
    {
        $appointments = Appointment::onlyTrashed()
            ->with([
                'branch',
                'patient',
                'psychologist',
                'serviceRate',
            ])
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'appointments.archived',
            compact('appointments')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Restore
    |--------------------------------------------------------------------------
    */

    public function restore(string $id)
    {
        $appointment = Appointment::withTrashed()
            ->findOrFail($id);

        $appointment->restore();

        return redirect()
            ->route('appointments.archived')
            ->with(
                'success',
                'Appointment berhasil direstore.'
            );
    }

 public function byPsychologist(Psychologist $psychologist)
    {
        $schedules = PsychologistSchedule::where(
            'psychologist_id',
            $psychologist->id
        )
            ->where('is_active', true)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        return response()->json(
            $schedules->map(function ($schedule) use ($dayNames) {
                return [
                    'id' => $schedule->id,
                    'day_name' => $dayNames[$schedule->day_of_week],
                    'start_time' => substr($schedule->start_time, 0, 5),
                    'end_time' => substr($schedule->end_time, 0, 5),
                    'slot_duration' => $schedule->slot_duration,
                ];
            })->values()
        );
    }

    public function byPsychologistDate(
        Psychologist $psychologist,
        string $date
    ) {
        $appointments = Appointment::query()
            ->where(
                'psychologist_id',
                $psychologist->id
            )
            ->whereDate(
                'appointment_date',
                $date
            )
            ->whereNotIn('status', [
                Appointment::STATUS_COMPLETED,
                Appointment::STATUS_CLOSED,
                Appointment::STATUS_CANCELLED,
                Appointment::STATUS_NO_SHOW,
            ])
            ->with([
                'patient',
                'serviceRate',
            ])
            ->orderBy('appointment_time')
            ->get();

        return response()->json(
            $appointments->map(function ($appointment) {

                return [
                    'appointment_no' =>
                        $appointment->appointment_no,

                    'date' =>
                        $appointment->appointment_date
                            ->format('d-m-Y'),

                    'start_time' =>
                        $appointment->appointment_time
                            ->format('H:i'),

                    'end_time' =>
                        $appointment->end_time
                            ?->format('H:i'),

                    'patient_name' =>
                        $appointment->patient->name,

                    'service_name' =>
                        $appointment->serviceRate->service_name,

                    'duration' =>
                        $appointment->duration,

                    'status' =>
                        match ($appointment->status) {
                            Appointment::STATUS_DRAFT =>
                                'Draft',

                            Appointment::STATUS_RESERVED =>
                                'Reserved',

                            Appointment::STATUS_CHECKED_IN =>
                                'Checked In',

                            Appointment::STATUS_IN_PROGRESS =>
                                'In Progress',

                            default =>
                                '-',
                        },
                ];
            })->values()
        );
    }

}