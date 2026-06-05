<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function index()
    {
        $members = Organization::all();
        return view('admin.organization.index', compact('members'));
    }

    public function create()
    {
        return view('admin.organization.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('photo')->store('organizations', 'public');

        $member = Organization::create([
            'name' => $request->name,
            'position' => $request->position,
            'period' => $request->period,
            'photo' => $path,
        ]);

        AnalyticsService::logActivity(auth()->id(), 'organization_create', "Organisasi: {$member->name}", [
            'target_type' => Organization::class,
            'target_id' => $member->id,
            'action' => 'create'
        ]);

        return redirect()->route('admin.organization.index')->with('success', 'Pengurus berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $member = Organization::findOrFail($id);

        AnalyticsService::logActivity(auth()->id(), 'organization_delete', "Organisasi: {$member->name}", [
            'action' => 'delete'
        ]);
        
        if ($member->photo && Storage::exists('public/' . $member->photo)) Storage::delete('public/' . $member->photo);
        $member->delete();
        return back()->with('success', 'Data pengurus berhasil dihapus!');
    }

    public function indexApi()
    {
        $members = Organization::all();
        return response()->json(['status' => 'success', 'data' => $members], 200);
    }

    public function storeApi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('photo')->store('organizations', 'public');

        $member = Organization::create([
            'name' => $request->name,
            'position' => $request->position,
            'period' => $request->period,
            'photo' => $path,
        ]);

        AnalyticsService::logActivity(auth()->id(), 'organization_create', "Organisasi: {$member->name}", [
            'target_type' => Organization::class,
            'target_id' => $member->id,
            'action' => 'create'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Pengurus berhasil ditambahkan via API!', 'data' => $member], 201);
    }

    public function destroyApi($id)
    {
        $member = Organization::find($id);
        if (!$member) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);

        AnalyticsService::logActivity(auth()->id(), 'organization_delete', "Organisasi: {$member->name}", [
            'action' => 'delete'
        ]);
        
        if ($member->photo && Storage::exists('public/' . $member->photo)) Storage::delete('public/' . $member->photo);
        $member->delete();

        return response()->json(['status' => 'success', 'message' => 'Data pengurus berhasil dihapus via API!'], 200);
    }
}