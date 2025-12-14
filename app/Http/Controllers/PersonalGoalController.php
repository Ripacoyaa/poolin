<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalGoalController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status', 'active'); // default active

    $query = Tabungan::where('user_id', Auth::id())
        ->whereNull('room_id'); // personal only

    if ($statusFilter === 'active') {
        $query->where('status', 'active');
    } elseif ($statusFilter === 'finished') {
        $query->where('status', 'finished');
    } else {
        // all → tidak tambah filter status
    }

    $goals = $query->orderBy('created_at', 'desc')->get();

    return view('dashboard.goals', [
        'goals'        => $goals,
        'statusFilter' => $statusFilter,
    ]);
    }

    public function create()
    {
        return view('dashboard.goal-form');
    }

    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required|string|max:255',
        'target_tabungan' => 'required|numeric|min:0',
        'target_tanggal' => 'nullable|date',    
        'deskripsi' => 'nullable|string',
        'foto' => 'nullable|image|max:2048',
    ]);
    
    if ($request->hasFile('foto')) {
    $fotoPath = $request->file('foto')->store('goals', 'public');
} else {
    $fotoPath = null;
}

        Tabungan::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'target_tabungan' => $request->target_tabungan,
            'target_tanggal' => $request->target_tanggal, // ✅ ini penting
            'deskripsi' => $request->deskripsi,
            'foto' => $path ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('personal.goals')
            ->with('success', 'Goal/tabungan berhasil dibuat.');
    }

    public function edit(Tabungan $goal)
    {
        $this->authorizeGoal($goal);

        return view('dashboard.goal-form', compact('goal'));
    }

    public function update(Request $request, Tabungan $goal)
    {
        $this->authorizeGoal($goal);

        $request->validate([
        'nama' => 'required|string|max:255',
        'target_tabungan' => 'required|numeric|min:1',
        'target_tanggal' => 'nullable|date',
        'deskripsi' => 'nullable|string',
        'foto' => 'nullable|image|max:2048',
        'status' => 'required|in:active,finished',
    ]);

        $goal->update([
        'nama' => $request->nama,
        'target_tabungan' => $request->target_tabungan,
        'target_tanggal' => $request->target_tanggal, // ✅
        'deskripsi' => $request->deskripsi,
        'status' => $request->status,
    ]);

    if ($request->hasFile('foto')) {
    $fotoPath = $request->file('foto')->store('goals', 'public');
    $goal->foto = $fotoPath;
    $goal->save();
}


        return redirect()->route('personal.goals')
            ->with('success', 'Goal/tabungan berhasil diupdate.');
    }

    public function destroy(Tabungan $goal)
    {
        $this->authorizeGoal($goal);

        $goal->delete();

        return redirect()->route('personal.goals')
            ->with('success', 'Goal/tabungan dihapus.');
    }

    private function authorizeGoal(Tabungan $goal)
    {
        if ($goal->user_id !== Auth::id()) {
            abort(403);
        }
    }

    
    public function saveForm(Tabungan $goal)
    {
        $this->authorizeGoal($goal);

        // hitung progress buat ditampilkan
        $target    = $goal->target_tabungan ?? 0;
        $collected = $goal->total_terkumpul ?? 0;
        $progress  = $target > 0 ? min(100, round($collected / $target * 100)) : 0;

        return view('dashboard.save-now', compact('goal', 'target', 'collected', 'progress'));
    }

    public function saveStore(Request $request, Tabungan $goal)
    {
        $this->authorizeGoal($goal);

        $request->validate([
            'jenis'         => 'required|in:saving,withdraw',
            'tgl_transaksi' => 'required|date',
            'nominal'       => 'required|numeric|min:1',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        $nominal = (int) $request->nominal;

        // Kalau withdraw, pastikan saldo cukup
        if ($request->jenis === 'withdraw' && $nominal > $goal->total_terkumpul) {
            return back()->withErrors([
                'nominal' => 'Nominal tarik melebihi saldo terkumpul.',
            ])->withInput();
        }

        // Simpan transaksi
        $jenis = $request->jenis ?? 'saving'; // atau ambil dari tombol/action

Transaksi::create([
    'user_id'       => Auth::id(),
    'tabungan_id'   => $goal->id,
    'nominal'       => $request->nominal,
    'keterangan'    => $request->keterangan ?? '-',
    'tgl_transaksi' => now(),
    'jenis'         => $jenis,                 // ✅ WAJIB
]);



        // Update total_terkumpul
        if ($request->jenis === 'saving') {
            $goal->total_terkumpul += $nominal;
        } else {
            $goal->total_terkumpul -= $nominal;
        }

        // Optional: auto ubah status selesai
        if ($goal->total_terkumpul >= $goal->target_tabungan) {
            $goal->status = 'finished';
        } else {
            $goal->status = 'active';
        }

        $goal->save();

        return redirect()->route('personal.goals')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

}
