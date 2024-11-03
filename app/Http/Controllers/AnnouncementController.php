<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{

    public function stop(Announcement $announcement)
    {
        $announcement = Announcement::findOrFail($announcement->id);

        $announcement->activation = 'Inactive';
        $announcement->manual_stop = true;
        $announcement->save();

        return redirect()->back()->with('success', 'Announcement has been stopped successfully.');
    }

    public function continue(Announcement $announcement)
    {
        $announcement = Announcement::findOrFail($announcement->id);

        $announcement->activation = 'Active';
        $announcement->manual_stop = false;
        $announcement->save();

        return redirect()->back()->with('success', 'Announcement has been stopped successfully.');
    }



    public function updateStatus(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|string'
        ]);

        $announcement = Announcement::find($id);
        if ($announcement) {
            $announcement->activation = $request->input('status');
            $announcement->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function view()
    {
        $announcements = Announcement::all();
        return view('admin.admin_page.announcement.announcement', ['announcements' => $announcements]);
    }

    public function create()
    {
        return view('admin.admin_page.announcement.announcementCreate');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'adminId' => 'required|exists:admins,id',
            'title' => 'required|string|unique:announcements',
            'content' => 'required|string',
            'start' => 'required|date|before_or_equal:end',
            'end' => 'required|date|after_or_equal:start',
            'distributed_to' => 'required|array|min:1',
            'distributed_to.*' => 'in:All,Student,Faculty,Guest',
            'attachment' => 'nullable|file|mimes:jpg,png|max:20480',
            // 'activation' => 'required|string|in:Activate,Deactivate',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = $file->getClientOriginalName();
            $destinationPath = storage_path('app/public/attachments');

            if (file_exists($destinationPath . '/' . $filename)) {
                return redirect()->back()->withErrors(['attachment' => 'The file already exists.']);
            } else {

                $attachmentPath = $file->storeAs('public/attachments', $filename);
            }
        }

        $distributed_to = in_array('All', $data['distributed_to']) ? 'All' : implode(',', $data['distributed_to']);

        Announcement::create([
            'adminId' => $data['adminId'],
            'title' => $data['title'],
            'content' => $data['content'],
            'start' => $data['start'],
            'end' => $data['end'],
            'distributed_to' => $distributed_to,
            'attachment' => $attachmentPath,
            // 'activation' => $data['activation'],
        ]);

        return redirect()->route('admin.announcement')->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.admin_page.announcement.announcementEdit', ['announcement' => $announcement]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        // Validate the incoming request data
        $data = $request->validate([
            'adminId' => 'required|exists:admins,id',
            'title' => 'required|string|unique:announcements,title,' . $announcement->id,
            'content' => 'required|string',
            'start' => 'required|date|before_or_equal:end',
            'end' => 'required|date|after-or_equal:start',
            'distributed_to' => 'required|array|min:1',
            'distributed_to.*' => 'in:All,Student,Faculty,Guest',
            'attachment' => 'nullable|file|mimes:jpg,png|max:20480',
            // 'activation' => 'required|string|in:Activate,Deactivate',
        ]);

        $attachmentPath = $announcement->attachment;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = $file->getClientOriginalName();
            $destinationPath = storage_path('app/public/attachments');

            if ($attachmentPath && file_exists(storage_path('app/' . $attachmentPath))) {
                unlink(storage_path('app/' . $attachmentPath));
            }

            $attachmentPath = $file->storeAs('public/attachments', $filename);
        }

        $distributed_to = in_array('All', $data['distributed_to']) ? 'All' : implode(',', $data['distributed_to']);

        $announcement->update([
            'adminId' => $data['adminId'],
            'title' => $data['title'],
            'content' => $data['content'],
            'start' => $data['start'],
            'end' => $data['end'],
            'distributed_to' => $distributed_to,
            'attachment' => $attachmentPath,
            // 'activation' => $data['activation'],
        ]);

        return redirect()->route('admin.announcement')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {

        $announcement_file = $announcement->attachment;
        $filePath = storage_path('app/' . $announcement_file);

        if ($announcement_file && file_exists($filePath)) {
            unlink($filePath);
        }

        $announcement->delete();

        return redirect()->route('admin.announcement')->with('success', 'Announcement updated successfully.');
    }

    public function viewAnnouncement(Announcement $announcement)
    {

        $announcements = Announcement::where('activation', 'Activate')->get();
        $noAnnouncements = false;

        if ($announcements->isEmpty()) {
            $noAnnouncements = true;
        }
        return view('main_layouts.announcement', compact('announcement', 'noAnnouncements', 'announcements'));
    }
}
