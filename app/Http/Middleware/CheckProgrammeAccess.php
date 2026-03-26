<?php

// app/Http/Middleware/CheckProgrammeAccess.php

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Programme;

class CheckProgrammeAccess
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $programmeId = $request->route('programmeId');

        // Vérifiez si l'utilisateur a accès au programme
        $hasAccess = $user->programmes()->where('id', $programmeId)->exists();

        if (!$hasAccess) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        return $next($request);
    }
}
