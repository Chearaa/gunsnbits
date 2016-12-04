<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Admin gallery list view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminGalleryList() {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        $galleries = Gallery::all();

        return view('admin.gallery.list', compact(
            'galleries'
        ));
    }

    /**
     * Admin gallery add view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminGalleryAdd() {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        return view('admin.gallery.add');
    }

    /**
     * Admin gallery add validation and create function.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminGalleryAddPost(Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        $rules = [
            'title' => 'required|max:255',
            'subtitle' => 'max:255'
        ];

        $messages = [
            'title.required' => 'Bitte gebe einen Titel an.',
            'title.max' => 'Der Titel darf nicht länger als 255 Zeichen lang sein.',
            'subtitle.max' => 'Der Untertitel darf nicht länger als 255 Zeichen lang sein.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('admin.gallery.add'))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $gallery = new Gallery([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'slug' => str_slug($request->title),
                'description' => $request->description
            ]);
            $gallery->save();

            flash('Die Galerie wurde angelegt.', 'success');
            return redirect(route('admin.gallery.list'));
        }
    }

    public function adminAlbumList(Gallery $gallery) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        return view('admin.gallery.album.list', compact(
            'gallery'
        ));
    }
}