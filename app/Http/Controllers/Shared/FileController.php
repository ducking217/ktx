<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**

 * Khu vực: Class
 
 * Vai trò: Mô tả chức năng chính của lớp trong module tương ứng.

 */

class FileController extends Controller
{
    /**
     * Show private file (CCCD, etc.) via signed URL or admin auth.
     */
    public function showPrivateFile(Request $request, ?string $path = null): StreamedResponse
    {
        $user = $request->user();
        $isAdmin = $user && method_exists($user, 'isAdminGroup') ? (bool) $user->isAdminGroup() : false;

        $path = (string) ($path ?: $request->query('path', ''));
        $path = ltrim($path, '/');
        if ($path === '') {
            abort(404);
        }
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
