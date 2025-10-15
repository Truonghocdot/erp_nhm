<?php

namespace App\Modules\File\Infrastructure\Http\Controller;

use App\Core\Controller;
use App\Modules\File\Domain\Model\File;
use App\Modules\File\Domain\Services\FileService;
use App\Modules\File\Utils\Constant\FileVisibility;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    protected FileService $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function show($id)
    {
        $file = File::findOrFail($id);

        // Kiểm tra quyền truy cập
        if ($file->visibility === FileVisibility::PRIVATE && !auth()->user()?->can('view_private_file')) {
            abort(Response::HTTP_FORBIDDEN, 'Access denied.');
        }

        // Lấy file từ storage
        $path = $file->path;

        if (!Storage::exists($path)) {
            abort(Response::HTTP_NOT_FOUND, 'File not found.');
        }

        // Trả về tuỳ theo loại file
        return match ($file->type) {
            FileType::IMAGE => response()->file(Storage::path($path), [
                'Content-Type' => 'image/' . $file->extension,
            ]),
            FileType::DOCUMENT => response()->file(Storage::path($path), [
                'Content-Type' => 'application/pdf',
            ]),
            default => response()->download(Storage::path($path)),
        };
    }


    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'visibility' => 'required|in:public,private',
        ]);

        $path = $request->file('file')->store('uploads');

        $file = File::create([
            'path' => $path,
            'extension' => $request->file('file')->getClientOriginalExtension(),
            'size' => $request->file('file')->getSize(),
            'visibility' => $request->visibility,
            'type' => FileType::fromExtension($request->file('file')->getClientOriginalExtension()),
        ]);

        return response()->json($file);
    }
}
