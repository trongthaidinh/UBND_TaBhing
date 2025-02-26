<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HomepageBlock;
use Illuminate\Http\Request;

class AdminBannerController extends Controller
{
    public function index(Request $request)
    {
        $query = HomepageBlock::where('type', 'banner');

        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->input('status'));
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $banners = $query->paginate(10);
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:homepage_blocks,name',
            'display_order' => 'required|integer',
            'is_active' => 'boolean',
            'link_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',  // Max 2MB
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Tên banner không được để trống.',
            'name.unique' => 'Tên banner đã tồn tại.',
            'name.max' => 'Tên banner không được vượt quá 255 ký tự.',
            'display_order.required' => 'Thứ tự hiển thị không được để trống.',
            'display_order.integer' => 'Thứ tự hiển thị phải là số nguyên.',
            'link_url.url' => 'Đường link không hợp lệ.',
            'image.image' => 'Tệp phải là hình ảnh.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $configuration = [
            'link_url' => $request->input('link_url'),
            'image_path' => $imagePath ? 'storage/' . $imagePath : null,
            'description' => $request->input('description'),
        ];

        HomepageBlock::create([
            'name' => $validated['name'],
            'type' => 'banner',
            'display_order' => $validated['display_order'],
            'is_active' => $validated['is_active'] ?? true,
            'configuration' => $configuration,
        ]);

        return redirect()
            ->route('admin.banner.index')
            ->with('success', 'Tạo banner thành công.');
    }

    public function edit(HomepageBlock $banner)
    {
        // Ensure this is a banner block
        if ($banner->type !== 'banner') {
            abort(404);
        }
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, HomepageBlock $banner)
    {
        // Ensure this is a banner block
        if ($banner->type !== 'banner') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:homepage_blocks,name,' . $banner->id,
            'display_order' => 'required|integer',
            'is_active' => 'boolean',
            'link_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',  // Max 2MB
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Tên banner không được để trống.',
            'name.unique' => 'Tên banner đã tồn tại.',
            'name.max' => 'Tên banner không được vượt quá 255 ký tự.',
            'display_order.required' => 'Thứ tự hiển thị không được để trống.',
            'display_order.integer' => 'Thứ tự hiển thị phải là số nguyên.',
            'link_url.url' => 'Đường link không hợp lệ.',
            'image.image' => 'Tệp phải là hình ảnh.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ]);

        // Handle image upload
        $imagePath = $banner->configuration['image_path'] ?? null;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imagePath) {
                $oldImagePath = str_replace('storage/', '', $imagePath);
                Storage::disk('public')->delete($oldImagePath);
            }

            // Store new image
            $newImagePath = $request->file('image')->store('banners', 'public');
            $imagePath = 'storage/' . $newImagePath;
        }

        $configuration = [
            'link_url' => $request->input('link_url'),
            'image_path' => $imagePath,
            'description' => $request->input('description'),
        ];

        $banner->update([
            'name' => $validated['name'],
            'display_order' => $validated['display_order'],
            'is_active' => $validated['is_active'] ?? true,
            'configuration' => $configuration,
        ]);

        return redirect()
            ->route('admin.banner.index')
            ->with('success', 'Cập nhật banner thành công.');
    }

    public function destroy(HomepageBlock $banner)
    {
        // Ensure this is a banner block
        if ($banner->type !== 'banner') {
            abort(404);
        }

        $banner->delete();

        return redirect()
            ->route('admin.banner.index')
            ->with('success', 'Xóa banner thành công.');
    }
}
