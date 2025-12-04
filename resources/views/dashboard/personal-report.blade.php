<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report - Personal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing:border-box; margin:0; padding:0; font-family:"Poppins",sans-serif; }

        body { background:#e6f6ff; min-height:100vh; display:flex; }

        /* sidebar kiri */
        .sidebar {
            width:230px;
            background:linear-gradient(180deg,#111a78,#1845c6);
            color:#fff;
            padding:24px 18px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
        }

        .logo-box {
            display:flex;align-items:center;gap:10px;
            margin-bottom:32px;padding-left:6px;
        }
        .logo-icon {
            width:34px;height:34px;border-radius:12px;
            background:#fff;color:#1845c6;
            display:flex;align-items:center;justify-content:center;
            font-weight:700;
        }
        .logo-text { font-size:22px;font-weight:700; }

        .nav { list-style:none;margin-top:12px; }
        .nav li { margin-bottom:10px; }
        .nav a {
            display:flex;align-items:center;gap:8px;
            padding:10px 12px;border-radius:12px;
            text-decoration:none;font-size:14px;
            color:#dbe6ff;
        }
        .nav a.active { background:rgba(255,255,255,0.15);color:#fff; }

        /* konten kanan */
        .content { flex:1;padding:24px 32px; }

        .page-title { font-size:24px;font-weight:700;color:#22366b;margin-bottom:6px; }
        .page-subtitle { font-size:13px;color:#6a7ba3;margin-bottom:16px; }

        .top-row { display:flex;gap:18px;align-items:flex-start; }

        .report-main { flex:2; }

        .filter-bar {
            background:#fff;border-radius:16px;
            padding:10px 14px;
            display:flex;gap:12px;align-items:center;
            margin-bottom:14px;
            box-shadow:0 8px 20px rgba(0,0,0,0.05);
        }
        .filter-group { display:flex;flex-direction:column;font-size:11px;color:#4b5c8e; }
        .filter-group select {
            margin-top:2px;border-radius:999px;border:1px solid #c3d5f5;
            padding:4px 10px;font-size:12px;
        }

        .chart-box {
            background:#fff;border-radius:16px;
            padding:14px 16px;
            box-shadow:0 8px 20px rgba(0,0,0,0.05);
            min-height:180px;
            margin-bottom:16px;
        }
        .chart-title { font-size:14px;font-weight:600;color:#294377;margin-bottom:8px; }
        .chart-placeholder {
            font-size:12px;color:#7c8bb3;
        }

        /* summary cards kanan */
        .summary-col { flex:1;display:flex;flex-direction:column;gap:10px; }

        .summary-card {
            background:#fff;border-radius:16px;
            padding:12px 14px;
            box-shadow:0 8px 20px rgba(0,0,0,0.05);
        }
        .summary-label { font-size:11px;color:#7c8bb3;margin-bottom:4px; }
        .summary-value { font-size:18px;font-weight:600;color:#22366b; }
        .summary-sub { font-size:12px;color:#4b5c8e; }

        /* tabel transaksi */
        .table-box {
            margin-top:18px;background:#fff;border-radius:16px;
            padding:12px 14px;
            box-shadow:0 8px 20px rgba(0,0,0,0.05);
        }
        table { width:100%;border-collapse:collapse;font-size:12px; }
        thead { background:#f2f5ff; }
        th,td { padding:8px 6px;border-bottom:1px solid #eef1ff;text-align:left; }
        th { color:#4b5c8e;font-weight:600;font-size:11px; }
        tbody tr:last-child td { border-bottom:none; }

        .tx-saving { color:#1c9c5d;font-weight:600; }
        .tx-withdraw { color:#e14848;font-weight:600; }

        @media(max-width:900px){
            .sidebar{display:none;}
            .content{padding:18px 14px;}
            .top-row{flex-direction:column;}
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div>
        <div class="logo-box">
            <div class="logo-icon">P</div>
            <div class="logo-text">Poolin</div>
        </div>
        <ul class="nav">
            <li><a href="{{ route('personal.home') }}">🏠 Home</a></li>
            <li><a href="{{ route('personal.goals') }}">🎯 My Goals</a></li>
            <li><a href="{{ route('personal.report') }}" class="active">📋 Report</a></li>
            <li><a href="{{ route('personal.setting') }}">⚙️ Setting</a></li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="page-title">Report</div>
    <div class="page-subtitle">Overview of your savings and goal progress.</div>

    <div class="top-row">
        {{-- kiri: filter + "chart" --}}
        <div class="report-main">
            {{-- filter --}}
            <form class="filter-bar" method="GET" action="{{ route('personal.report') }}">
                <div class="filter-group">
                    <span>Date Range</span>
                    <div style="display:flex;gap:6px;">
                        <select name="month">
                            <option value="">All Months</option>
                            @for($m=1;$m<=12;$m++)
                                <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->format('M') }}
                                </option>
                            @endfor
                        </select>
                        <select name="year">
                            <option value="">All Years</option>
                            @for($y = now()->year-2; $y <= now()->year+1; $y++)
                                <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="filter-group">
                    <span>All Goals</span>
                    <select name="goal_id">
                        <option value="all">All Goals</option>
                        @foreach($goals as $g)
                            <option value="{{ $g->id }}" {{ $goalId == $g->id ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-left:auto;">
                    <button type="submit"
                            style="border:none;border-radius:999px;padding:6px 14px;
                                   background:#1845c6;color:#fff;font-size:12px;cursor:pointer;">
                        Apply
                    </button>
                </div>
            </form>

            {{-- chart placeholder --}}
            <div class="chart-box">
                <div class="chart-title">Savings Chart</div>
                <div class="chart-placeholder">
                    (Nanti bisa diganti chart beneran. Sekarang kita tampilin total saving per bulan:)
                </div>
                @if(!empty($chartData))
                    <ul style="margin-top:8px;font-size:11px;color:#4b5c8e;">
                        @foreach($chartData as $m => $sum)
                            <li>
                                {{ \Carbon\Carbon::create()->month($m)->format('M') }} :
                                Rp {{ number_format($sum,0,',','.') }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div style="margin-top:8px;font-size:11px;color:#7c8bb3;">
                        Pilih Year untuk melihat ringkasan per bulan.
                    </div>
                @endif
            </div>
        </div>

        {{-- kanan: summary cards --}}
        <div class="summary-col">
            <div class="summary-card">
                <div class="summary-label">Total Savings Added</div>
                <div class="summary-value">
                    Rp {{ number_format($totalSavings,0,',','.') }}
                </div>
                <div class="summary-sub">From selected range</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Total Finished Goals</div>
                <div class="summary-value">{{ $totalFinishedGoals }}</div>
                <div class="summary-sub">All time</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Total Expenditure</div>
                <div class="summary-value">
                    Rp {{ number_format($totalExpenditure,0,',','.') }}
                </div>
                <div class="summary-sub">Withdrawals in selected range</div>
            </div>
        </div>
    </div>

    {{-- tabel transaksi --}}
    <div class="table-box">
        <div style="font-size:14px;font-weight:600;color:#294377;margin-bottom:8px;">
            Transactions
        </div>

        <table>
            <thead>
            <tr>
                <th style="width:90px;">Date</th>
                <th>Goals</th>
                <th style="width:110px;">Amount</th>
                <th style="width:80px;">Type</th>
                <th>Notes</th>
                <th style="width:90px;">Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse($transactions as $tx)
                @php
                    $isSaving = $tx->jenis === 'saving';
                    $tabungan = $tx->tabungan;
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($tx->tgl_transaksi)->format('d/m/Y') }}</td>
                    <td>{{ $tabungan?->nama ?? '-' }}</td>
                    <td class="{{ $isSaving ? 'tx-saving' : 'tx-withdraw' }}">
                        {{ $isSaving ? '+ ' : '- ' }}
                        Rp {{ number_format($tx->nominal,0,',','.') }}
                    </td>
                    <td>{{ ucfirst($tx->jenis) }}</td>
                    <td>{{ $tx->keterangan ?? '-' }}</td>
                    <td>{{ $tabungan?->status ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:#7c8bb3;">
                        No transactions for this filter.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
