<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Role;
use App\User;
use App\Video;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VideosController extends Controller
{
    public function index()
    {
        $videos = Video::all();

        return view('admin.videos.index', compact('videos'));
    }

    public function uploadVideo(Request $request)
    {
      $this->validate($request, [
         'title' => 'required|string|max:255',
         'video' => 'required|file|mimetypes:video/mp4',
        ]);
        $video = new Video;
        $video->title = $request->title;
        $video->content = $request->content;
        if ($request->hasFile('video'))
        {
            $path = $request->file('video')->store('videos', ['disk' =>      'my_files']);
            $video->url = $path;
        }
        $video->save();
   
    }

    public function create()
    {
        $users = User::all()->pluck('name', 'email', 'id');

        return view('admin.videos.create', compact('users'));
    }

    public function store(StoreVideoRequest $request)
    {
        $video = Video::create($request->all());
        return redirect()->route('admin.videos.index');
    }

    public function edit(Video $video)
    {
        $users = User::all()->pluck('name', 'email', 'id');
        $video -> load('users');

        return view('admin.videos.edit', compact('users', 'video'));
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        $video->update($request->all());

        return redirect()->route('admin.videos.index');
    }

    public function show(Video $video)
    {
        $video->load('users');

        return view('admin.videos.show', compact('video'));
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return back();
    }

}
