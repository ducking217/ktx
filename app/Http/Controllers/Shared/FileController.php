<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Show private file (CCCD, etc.) via signed URL or admin auth.
     */
    public function showPrivateFile(Request $request, string $path): StreamedResponse
    {
        $user = $request->user();
        $isAdmin = $user && method_exists($user, 'isAdminGroup') ? (bool) $user->isAdminGroup() : false;

        $path = ltrim($path, '/');
        if (str_contains($path, '..')) {
            abort(403);
        }

        if (! $isAdmin && ! URL::hasValidSignature($request)) {
            abort(403, 'Invalid or expired signed URL');
        }

        if (! $isAdmin) {
            $sv = $user?->sinhvien;
            $allowedPaths = array_values(array_filter([
                $sv?->anh_the_path,
                $sv?->anh_cccd_path,
            ]));
            if (! in_array($path, $allowedPaths, true)) {
                abort(403);
            }
        }

        if (! Storage::disk('private')->exists($path)) {
            abort(404);
        }

        return Storage::disk('private')->response($path);
    }

    /**
     * Generate signed URL for private file access
     */
    public static function generateSignedUrl(string $path, int $expiresInMinutes = 60): string
    {
        return URL::temporarySignedRoute('private.file', now()->addMinutes($expiresInMinutes), ['path' => $path]);
    }
}

