<?php

namespace App\Http\Controllers\Admin\Audits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $audits = Audit::with('user')->whereNotIn('auditable_type', [
            'App\Modules\Cart\Models\CartStorage'
        ])
            ->orderBy('created_at', 'desc')->get();
        return view('audit.index', ['audits' => $audits]);
    }

}
