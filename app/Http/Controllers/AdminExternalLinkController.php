<?php

namespace App\Http\Controllers;

use App\Models\ExternalLink;
use Illuminate\Http\Request;

class AdminExternalLinkController extends Controller
{
    public function index()
    {
        $externalLinks = ExternalLink::latest()->paginate(10);
        return view('admin.external-links.index', compact('externalLinks'));
    }

    public function create()
    {
        return view('admin.external-links.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'url' => 'required|url|max:255',
            'category' => 'nullable|max:100',
            'is_active' => 'boolean'
        ]);

        $externalLink = ExternalLink::create([
            'name' => $validatedData['name'],
            'url' => $validatedData['url'],
            'category' => $validatedData['category'] ?? null,
            'is_active' => $validatedData['is_active'] ?? true
        ]);

        return redirect()->route('admin.external-links.index')
            ->with('success', 'Liên kết ngoài đã được tạo thành công.');
    }

    public function edit(ExternalLink $externalLink)
    {
        return view('admin.external-links.edit', compact('externalLink'));
    }

    public function update(Request $request, ExternalLink $externalLink)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'url' => 'required|url|max:255',
            'category' => 'nullable|max:100',
            'is_active' => 'boolean'
        ]);

        $externalLink->update([
            'name' => $validatedData['name'],
            'url' => $validatedData['url'],
            'category' => $validatedData['category'] ?? null,
            'is_active' => $validatedData['is_active'] ?? true
        ]);

        return redirect()->route('admin.external-links.index')
            ->with('success', 'Liên kết ngoài đã được cập nhật thành công.');
    }

    public function destroy(ExternalLink $externalLink)
    {
        $externalLink->delete();

        return redirect()->route('admin.external-links.index')
            ->with('success', 'Liên kết ngoài đã được xóa thành công.');
    }
}