<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HomepageBlock;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{
    public function index()
    {
        $homepageBlocks = HomepageBlock::paginate(10);
        return view('admin.homepage-blocks.index', compact('homepageBlocks'));
    }

    public function create()
    {
        return view('admin.homepage-blocks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:homepage_blocks,name',
            'type' => 'required|in:slider,news,banner',
            'display_order' => 'required|integer',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Tên khối không được để trống.',
            'name.unique' => 'Tên khối đã tồn tại.',
            'name.max' => 'Tên khối không được vượt quá 255 ký tự.',
            'type.required' => 'Loại khối không được để trống.',
            'type.in' => 'Loại khối không hợp lệ.',
            'display_order.required' => 'Thứ tự hiển thị không được để trống.',
            'display_order.integer' => 'Thứ tự hiển thị phải là số nguyên.',
        ]);

        // Combine keys and values into configuration
        $configuration = [];
        $keys = $request->input('configuration.keys', []);
        $values = $request->input('configuration.values', []);

        foreach ($keys as $index => $key) {
            if (!empty($key) && isset($values[$index])) {
                // Try to parse JSON values
                $value = $values[$index];

                // Attempt to decode JSON, if it fails, use the original string
                $parsedValue = json_decode($value, true);
                $configuration[$key] = $parsedValue === null ? $value : $parsedValue;
            }
        }

        $validated['configuration'] = $configuration;

        HomepageBlock::create($validated);

        return redirect()
            ->route('admin.homepage-blocks.index')
            ->with('success', 'Tạo khối trang chủ thành công.');
    }

    public function edit(HomepageBlock $homepageBlock)
    {
        return view('admin.homepage-blocks.edit', compact('homepageBlock'));
    }

    public function update(Request $request, HomepageBlock $homepageBlock)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:homepage_blocks,name,' . $homepageBlock->id,
            'type' => 'required|in:slider,news,banner',
            'display_order' => 'required|integer',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Tên khối không được để trống.',
            'name.unique' => 'Tên khối đã tồn tại.',
            'name.max' => 'Tên khối không được vượt quá 255 ký tự.',
            'type.required' => 'Loại khối không được để trống.',
            'type.in' => 'Loại khối không hợp lệ.',
            'display_order.required' => 'Thứ tự hiển thị không được để trống.',
            'display_order.integer' => 'Thứ tự hiển thị phải là số nguyên.',
        ]);

        // Combine keys and values into configuration
        $configuration = [];
        $keys = $request->input('configuration.keys', []);
        $values = $request->input('configuration.values', []);

        foreach ($keys as $index => $key) {
            if (!empty($key) && isset($values[$index])) {
                // Try to parse JSON values
                $value = $values[$index];

                // Attempt to decode JSON, if it fails, use the original string
                $parsedValue = json_decode($value, true);
                $configuration[$key] = $parsedValue === null ? $value : $parsedValue;
            }
        }

        $validated['configuration'] = $configuration;

        $homepageBlock->update($validated);

        return redirect()
            ->route('admin.homepage-blocks.index')
            ->with('success', 'Cập nhật khối trang chủ thành công.');
    }
}
